<?php
if (! function_exists('prepare_dropdown'))
{
	/**
	 * Returns array taken from database from specific fields
	 *
	 * @param array $array
	 * @param string $index_field
	 * @param string $data_field
	 *
	 * @return array
	 */
	function prepare_dropdown(array $array, string $index_field, string $data_field)
	{
		$return_array = [];
		
		$dataFieldArray = explode(',', $data_field);

		foreach ($array as $element) {
			$str = '';
			foreach ($dataFieldArray as $elem) {
				$elem = trim($elem);
				$str .= $element->$elem . ' ';
			}
			$return_array[$element->$index_field] = trim($str);
		}

		return $return_array;
	}
}

if (! function_exists('translate_dropdown'))
{
	/**
	 * Returns array with translated text for dropdowns
	 *
	 * @param array $array - 2d array for fropdown
	 *
	 * @return array
	 */
	function translate_dropdown(array $array)
	{
		$return_array = [];
		
		foreach ($array as $key => $value) {
			$return_array[$key] = lang('AdminPanel.' . $value);
		}

		return $return_array;
	}
}


