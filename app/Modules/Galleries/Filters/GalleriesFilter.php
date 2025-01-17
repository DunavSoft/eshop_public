<?php namespace App\Modules\Galleries\Filters;

use CodeIgniter\Filters\FilterInterface;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Galleries Filter
 *
 * Replaces menu tokens with actual
 * menu content from their aliases.
 */
class GalleriesFilter implements FilterInterface
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
		
		// galleries widjet replace code
		$configApp = new \Config\App();
		if (in_array('Galleries', $configApp->loadedModules)) {
			
			$nrFoundStrings = substr_count($body, '{{gallery');
			
			if ($nrFoundStrings > 0) {
				helper('text');
				
				$galleriesModel = new \App\Modules\Galleries\Models\GalleriesModel;
				
				for ($i = 0; $i < $nrFoundStrings; $i++) {
					$galleryId = (int)string_between_twoo($body, '{{gallery,', '}}');
					
					$data['images'] = $galleriesModel->getGalleriesImagesByGalleryIdAndLocale($galleryId, $locale = $request->getLocale(), $active_only = true, $needle = '*', $needle_lang = '*');

					$replacedView = view('App\Modules\Galleries\Views\galleries_filter', $data);

					$body = str_replace("{{gallery, $galleryId}}", $replacedView, $body);
					$body = str_replace("{{gallery,$galleryId}}", $replacedView, $body);
				}
			}
		}

		// Use the new body and return the updated Response
		return $response->setBody($body);
	}
}