<?php namespace App\Modules\Languages\Filters;

use CodeIgniter\Filters\FilterInterface;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
//use Tatter\Menus\Menu;
use InvalidArgumentException;
use RuntimeException;

/**
 * Menus Filter
 *
 * Replaces menu tokens with actual
 * menu content from their aliases.
 */
class LanguagesFilter implements FilterInterface
{
	/**
	 * @codeCoverageIgnore
	 */
	public function before(RequestInterface $request, $arguments = null)
	{
		//d($request);
	}

	/**
	 * Generate setings array variable for active locale language.
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
		
		//var_dump($request->getLocale());exit;

		// Only run on HTML content
		if (strpos($response->getHeaderLine('Content-Type'), 'html') === false)
		{
			return null;
		}

		$count = 0;
		
		$body = $response->getBody();
		
		/*
		$languagesFrontModel = new \App\Modules\Languages\Models\LanguagesFrontModel;
		$languagesFrontContent = $languagesFrontModel->findAll();
		
		$languagesModel = new \App\Modules\Languages\Models\LanguagesModel;
		$languagesList = $languagesModel->getActiveElements('site');
		
		$parser = \Config\Services::parser();
		
		foreach ($languagesFrontContent as $element) {

			$languagesArray = [];
			$languagesArray['locale'] = $request->getLocale();
			
			foreach ($languagesList as $langElement) {
				$active = '';
				if ($langElement->uri == $languagesArray['locale']) {
					$active = 'active';
				}
				$languagesArray['languages'][] = [ 
					'title' => $langElement->native_name, 
					'link' => site_url($langElement->uri), 
					'active' => $active,
				];
			}
			
			$parsedString = $parser->setData($languagesArray)->renderString($element->content);
			
			$body = str_replace('{{' . $element->lang_variable . '}}', $parsedString, $body, $count);
		}
		
		*/
		
		$languagesController = new \App\Modules\Languages\Controllers\LanguagesController;
		
		$body = $languagesController->languagesFilter($body);

		// Use the new body and return the updated Response
		return $response->setBody($body);
	}
	
}
