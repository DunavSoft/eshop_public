<?php

namespace App\Libraries;

class Breadcrumb
{
    protected $model;
    protected $menuElementsModel;

    public function __construct()
    {
        $this->model = new \App\Modules\Menus\Models\MenusModel;
    }

    public function getBreadcrumb($menuType)
    {
        $locale = service('request')->getLocale();

        $configApp = new \Config\App();

        $element = $this->model->where(['side' => $menuType])->first();

        if ($element == null) {
            return [];
        }

        $slugArray = [];

        $pagesLanguagesModel = new \App\Modules\Pages\Models\PagesLanguagesModel;
        $slugArray['page'] = $pagesLanguagesModel->getPagesLangSlugs($locale);

        $categoryLanguagesModel = new \App\Modules\Products\Models\CategoriesLanguagesModel;
        $slugArray['category'] = $categoryLanguagesModel->getCategoriessLangSlugs($locale);

        if (in_array('Articles', $configApp->loadedModules)) {
            $model = new \App\Modules\Articles\Models\ArticlesCategoriesLanguagesModel;
            $slugArray['articles'] = $model->getCategoriesArticlesLangSlugs($locale);
        }

        $namesArray = [];

        $namesArray['page'] = $pagesLanguagesModel->getPagesLangTitles($locale);

        //$namesArray['category'] = $categoryLanguagesModel->getCategoriessLangTitles($locale);

        $namesArray['category'] = '';

        if (in_array('Articles', $configApp->loadedModules)) {
            //$namesArray['articles'] = $model->getCategoriesArticlesLangSlugs($locale);
            $namesArray['articles'] = [];
        }

        if ($element !== null) {
            $menuArray = json_decode($element->content) ?? [];

            return $this->findActiveElements($menuArray, $slugArray, $namesArray, $this->extractSegment());
        }

        return [];
    }

    public function findActiveElements($menuArray, $slugArray, $namesArray, $searchSlug, $currentPath = [], $level = 1)
    {
        foreach ($menuArray as $item) {

            $result = [];

            // Determine the current item's slug
           
            if ($item->type === 'page') {
                $currentSlug = $slugArray[$item->type][$item->page] ?? null;
            }

            // Determine the current item's title
            if ($item->type === 'page') {
                $currentTitle = $namesArray[$item->type][$item->page] ?? null;
            }

            // Store both slug and title in the current path
            if ($currentSlug && $currentTitle) {
                $currentPath[$level] = [
                    'slug' => $currentSlug,
                    'title' => $currentTitle,
                ];
            }

            // Check if the current slug matches the search slug
            if ($currentSlug === $searchSlug) {
                $result = array_merge($result, $currentPath);
            }

            // Recursively search in children
            if (!empty($item->children)) {
                $result = array_merge($result, $this->findActiveElements($item->children, $slugArray, $namesArray, $searchSlug, $currentPath, $level + 1));
            }

            // Backtrack by removing the current level
            unset($currentPath[$level]);

            if (count($result) > 0) {
                return $result;
            }
        }

        return [];
    }



    private function extractSegment()
    {
        // Get the current URI instance
        $uri = service('uri');

        // Get supported locales from App configuration
        $config = config('App');
        $supportedLocales = $config->supportedLocales;

        // Check if the first segment is a locale
        $firstSegment = $uri->getSegment(1); // First segment
        $isLocale = in_array($firstSegment, $supportedLocales);

        return $isLocale ? $uri->getSegment(2) : $uri->getSegment(1);
    }
}
