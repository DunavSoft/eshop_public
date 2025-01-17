<?php

namespace App\Libraries;

class ImagesConvert
{
    /**
     * The database object.
     *
     * @var object
     */
    protected $db;

    /**
     * Define the replacement property with a default value of 'underscore'
     *
     * @var string
     */
    protected $replacement = 'underscore';

    public function __construct(array $config = [])
    {
        $this->db = \Config\Database::connect();

        if (mb_internal_encoding() !== 'UTF-8') {
            mb_internal_encoding('UTF-8');
        }
    }

    public function convertImage(array $tableArray = [], array $fieldArray = [], bool $useSoftDelete = true): void
    {
        $productsLanguagesModel = new \App\Modules\Products\Models\ProductsLanguagesModel;
        $languagesModel = new \App\Modules\Languages\Models\LanguagesModel;


        if (empty($tableArray)) {
            $tableArray = ['products_images', 'articles_images', 'galleries_images', 'sliders'];
        }

        if (empty($fieldArray)) {
            $fieldArray = [
                'products_images' => 'image',
                'articles_images' => 'image',
                'galleries_images' => 'image',
                'sliders' => 'image'
            ];
        }

        foreach ($tableArray as $table) {
            $builder = $this->db->table($table);
            $builder->like($fieldArray[$table], 'data', 'after');

            if ($useSoftDelete) {
                $builder->where('deleted_at', null);
            }

            $result = $builder->get()->getResultObject();

            foreach ($result as $element) {
                $decodedImageData = $this->base64DecodeFile($element->{$fieldArray[$table]});

                if ($decodedImageData !== false) {
                    $imageResource = $this->createImageResourceFromDecodedData($decodedImageData);

                    //to avoid error on convert some .png files
                    if (!imageistruecolor($imageResource)) {
                        $width = imagesx($imageResource);
                        $height = imagesy($imageResource);
                        $trueColorImage = imagecreatetruecolor($width, $height);

                        imagecopy($trueColorImage, $imageResource, 0, 0, 0, 0, $width, $height);
                        imagedestroy($imageResource);

                        // Use the new true color image for the WebP conversion
                        $imageResource = $trueColorImage;
                    }

                    if ($imageResource !== false) {
                        $ext = 'webp';

                        if ($table == 'products_images') {
                            $locale = $languagesModel->getDefaultSiteLanguage();
                            $getLanguageTitle = $productsLanguagesModel->getProductLanguage($locale->id, $element->product_id);
                            $slug = $getLanguageTitle->slug;

                            if ($slug !== null) {
                                $fileName = $slug . $element->id . '.' . $ext;
                            } else {
                                $fileName = $table . $fieldArray[$table] . $element->id . '.' . $ext;
                            }

                            //keep the original file in a folder original_images
                            $mime = $decodedImageData['mime'];
                            $extension = explode('/', $mime)[1];

                            $path = ROOTPATH . 'public/uploads/original_images/';
                            if (!is_dir($path)) {
                                // Create the directory with recursive set to true
                                mkdir($path, 0755, true);
                            }
                            
                            $fileNameOriginal = str_replace($ext, $extension, $fileName);
                            file_put_contents($path . $fileNameOriginal, $decodedImageData['data']);
                            //end keep the original file in a folder original_images

                        } else {
                            $fileName = $table . $fieldArray[$table] . $element->id . '.' . $ext;
                        }

                        $fullPath = ROOTPATH . 'public/uploads/' . $fileName;

                        $imageResource = $this->resizeImage($imageResource, 2000, 2000);
                        $conversionResult = imagewebp($imageResource, $fullPath);
                        imagedestroy($imageResource);

                        if ($conversionResult) {
                            $save = [
                                'id' => $element->id,
                                $fieldArray[$table] => '/uploads/' . $fileName
                            ];

                            $builder->set($save);
                            $builder->where('id', $element->id);
                            $builder->update();
                        }
                    }
                }
            }
        }
    }

    private function resizeImage($imageResource, $maxWidth, $maxHeight)
    {
        $width = imagesx($imageResource);
        $height = imagesy($imageResource);

        if ($width > $maxWidth || $height > $maxHeight) {
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $newWidth = $width * $ratio;
            $newHeight = $height * $ratio;

            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage, $imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            return $newImage;
        }

        return $imageResource;
    }

    private function createImageResourceFromDecodedData($decodedImageData)
    {
        return imagecreatefromstring($decodedImageData['data']);
    }

    private function base64DecodeFile(string $data)
    {
        if (preg_match('/^data\:([a-zA-Z]+\/[\w\+\-\.]+);base64\,([\w\+\=\/]+)$/', $data, $matches)) {
            $mime = $matches[1];

            // Check if the MIME type is 'image/svg+xml' and modify it to 'image/svg'
            if ($mime === 'image/svg+xml') {
                $mime = 'image/svg';
            }

            return [
                'mime' => $mime,
                'data' => base64_decode($matches[2]),
            ];
        }

        return false;
    }


    private function getReplacement(): string
    {
        return ($this->replacement === 'dash') ? '-' : '_';
    }
}
