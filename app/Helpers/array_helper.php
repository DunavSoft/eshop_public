<?php

if (! function_exists('append_array_to_array'))
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
	function append_array_to_array(array &$arrayToAppend, array $arrayElements)
	{
		foreach ($arrayElements as $key => $value) {
			$arrayToAppend[$key] = $value;
		}
	}
}