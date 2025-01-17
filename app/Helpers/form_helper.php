<?php
/**
	 * Textarea field
	 *
	 * @param mixed  $data
	 * @param string $value
	 * @param mixed  $extra
	 *
	 * @return string
	 */
	function form_textarea($data = '', string $value = '', $extra = ''): string
	{
		$defaults = [
			'name' => is_array($data) ? '' : $data,
			'cols' => '40',
			'rows' => '10',
		];
		if (! is_array($data) || ! isset($data['value']))
		{
			$val = $value;
		}
		else
		{
			$val = $data['value'];
			unset($data['value']); // textareas don't use the value attribute
		}

		return '<textarea ' . parse_form_attributes($data, $defaults) . stringify_attributes($extra) . '>'
				. $val
				. "</textarea>\n";
	}