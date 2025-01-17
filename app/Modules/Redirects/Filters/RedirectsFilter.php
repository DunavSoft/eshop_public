<?php

namespace App\Modules\Redirects\Filters;

use CodeIgniter\HTTP\RedirectResponse;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Redirects Filter
 */
class RedirectsFilter implements FilterInterface
{
	/**
	 * @codeCoverageIgnore
	 */
	public function before(RequestInterface $request, $arguments = null)
	{
		$segments = $request->uri->getSegments();

		$searchUri = $request->uri->getPath();
		$redirectsModel = new \App\Modules\Redirects\Models\RedirectsModel;

		$result = $redirectsModel->like('source', $searchUri, 'before')->first();

		if ($result != false) {
			$save = [];
			$save['id'] = $result->id;
			$save['count_usage'] = $result->count_usage + 1;

			$redirectsModel->save($save);

			return redirect()->to($result->target, $result->code);
		}

		//$appConfig = config('App'); // Load the App configuration
		//$defaultLocale = $appConfig->defaultLocale;
		//$supportedLocales = $appConfig->supportedLocales;

		// Check if the first segment is 'public' and redirect
		if (isset($segments[0]) && $segments[0] === 'public') {
			array_shift($segments); // Remove the 'public' segment
			$newUri = implode('/', $segments);
			return redirect()->to($newUri, 301); // 301 Moved Permanently
		}

		// Check if the first segment is not a locale and redirect to the default locale
		/*
		if (!isset($segments[0]) && $segments[0] === 'public') {
			array_shift($segments); // Prepend the default locale
			$newUri = implode('/', $segments);
			return redirect()->to($newUri, 301); // 301 Moved Permanently
		}
		*/
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
		return null;
	}
}
