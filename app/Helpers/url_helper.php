<?php

if (! function_exists('site_url'))
{
	/**
	 * Return a site URL to use in views
	 *
	 * @param mixed            $uri       URI string or array of URI segments
	 * @param string|null      $protocol
	 * @param \Config\App|null $altConfig Alternate configuration to use
	 *
	 * @return string
	 */
	function site_url($uri = '', string $protocol = null, \Config\App $altConfig = null): string
	{
		// convert segment array to string
		if (is_array($uri))
		{
			$uri = implode('/', $uri);
		}

		// use alternate config if provided, else default one
		$config = $altConfig ?? config(\Config\App::class);

		$fullPath = rtrim(base_url(), '/') . '/';

		// Add index page, if so configured
		if (! empty($config->indexPage))
		{
			$fullPath .= rtrim($config->indexPage, '/');
		}
		if (! empty($uri))
		{
			$fullPath .= '/' . $uri;
		}

		$url = new \CodeIgniter\HTTP\URI($fullPath);

		// allow the scheme to be over-ridden; else, use default
		if (! empty($protocol))
		{
			$url->setScheme($protocol);
		}

		$locale = service('request')->getLocale();
		$defaultLocale = $config->defaultLocale;

		if ($defaultLocale == $locale) {
			$url = (string) $url;
			$url = preg_replace('/' . preg_quote($locale, '/') . '\//', '', $url, 1);
		}

		return (string) $url;
	}
}