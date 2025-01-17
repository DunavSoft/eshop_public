<?php namespace App\Modules\Properties\Filters;

use CodeIgniter\Filters\FilterInterface;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use InvalidArgumentException;
use RuntimeException;

/**
 * Properties Filter
 *
 * Replaces menu tokens with actual
 * menu content from their aliases.
 */
class PropertiesFilter implements FilterInterface
{
	/**
	 * @codeCoverageIgnore
	 */
	public function before(RequestInterface $request, $arguments = null)
	{
		//d($request);
	}

	/**
	 * Replaces gallery widjet from $body with the gallery elements
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param array|null        $arguments
	 *
	 * @return ResponseInterface|null
	 */
	
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): ?ResponseInterface
	{
		// Ignore irrelevent responses
		if ((is_cli() && ENVIRONMENT !== 'testing') || $response instanceof RedirectResponse || empty($response->getBody()))
		{
			return null;
		}
		
		// Only run on HTML content
		if (strpos($response->getHeaderLine('Content-Type'), 'html') === false)
		{
			return null;
		}
		
		$body = $response->getBody();
		
		/////////// properties widjet replace code
		$configApp = new \Config\App();
		if (in_array('Properties', $configApp->loadedModules)) {
			
			$nrFoundStrings = substr_count($body, '{{properties');
			
			if ($nrFoundStrings > 0) {
				helper('text');
				
				$propertyParameters = string_between_twoo($body, '{{properties,', '}}');
				$propertyParamsArray = array_map('trim', explode(',', trim($propertyParameters)));
				
				$locale = $request->getLocale();
				$propertiesLanguagesModel = new \App\Modules\Properties\Models\PropertiesLanguagesModel;
				$propertiesImagesModel = new \App\Modules\Properties\Models\PropertiesImagesModel;

				$data['elements'] = $propertiesLanguagesModel->getPropertiesLanguagesByLocale($locale, $propertyParamsArray[1], $propertyParamsArray[2]);
				
				foreach ($data['elements'] as &$element) {
					$propertyImage = $propertiesImagesModel->getPrimaryImagesByPropertyId($element->property_id);
					
					$element->image = $propertyImage->image ?? '/assets/images/no_image.png';
				}
				
				$replacedView = view('App\Modules\Properties\Views\properties_' . $propertyParamsArray[0], $data);

				$body = str_replace('{{properties,' . $propertyParameters . '}}', $replacedView, $body);
				
			}
		}
		///////////////////

		// Use the new body and return the updated Response
		return $response->setBody($body);
	}
	
}
