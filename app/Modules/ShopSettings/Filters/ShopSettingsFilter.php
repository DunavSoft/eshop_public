<?php namespace App\Modules\ShopSettings\Filters;

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
class ShopSettingsFilter implements FilterInterface
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

		$shopsettingsModel = model('App\Modules\ShopSettings\Models\ShopSettingsModel', false);

		$shopsettingsArray = [];
		$shopsettings = $shopsettingsModel->getShopSettingsByLocale($request->getLocale());

		foreach ($shopsettings as $element) {
			$shopsettingsArray[$element->setup_key] = $element->setup_value;
			$body = str_replace('{' . $element->setup_key . '}', $element->setup_value, $body, $count);
		}

		//replace some global variables
		$locale = $request->getLocale();
		$body = str_replace('{locale}', $locale, $body);

		// Use the new body and return the updated Response
		return $response->setBody($body);
	}

}
