<?php

//--------------------------------------------------------------------

if (! function_exists('string_between_twoo'))
{
	/**
	 * String between 2 strings
	 *
	 * Gets a string between 2 strings.
	 *
	 * @param string  $str
	 * @param string  $starting_word
	 * @param string  $ending_word
	 *
	 * @return string
	 */
	function string_between_twoo($str, $starting_word, $ending_word)
	{
		$subtring_start = strpos($str, $starting_word);
		//Adding the starting index of the starting word to
		//its length would give its ending index
		$subtring_start += strlen($starting_word);
		//Length of our required sub string
		$size = strpos($str, $ending_word, $subtring_start) - $subtring_start;

		// Return the substring from the index substring_start of length size
		return substr($str, $subtring_start, $size);
	}

	function random_string_pool($len = 11, $pool = '0123456789ABCDEF')
	{
		$str = '';
		for ($i=0; $i < $len; $i++)
		{
			$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
		}
		return $str;
	}
	
	function prepare_string_for_meta($string, $limit)
	{
		$string = strip_tags($string);
		
		$i = 0;
		while (strstr($string, '{{') != false) {
			if ($string != '') {
				$specialString = string_between_twoo($string, '{{', '}}');
				$string = str_replace('{{' . $specialString . '}}', '', $string);
			}
			
			//ensure we will not loop infinite here
			if ($i > 20) {
				return;
			}
			$i++;
		}
		
		
		return character_limiter($string, $limit, '');
	}

	function mb_lcfirst($str, $encoding = "UTF-8") {
		$firstChar = mb_substr($str, 0, 1, $encoding);
		$then = mb_substr($str, 1, mb_strlen($str, $encoding) - 1, $encoding);
		
		return mb_strtolower($firstChar, $encoding) . $then;
	}
}