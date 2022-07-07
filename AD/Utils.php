<?php namespace AD;

defined('_JEXEC') or die;

class Utils
{


	public static function buildStyle(array $attrs = [])
	{
		$output = '';

		foreach ($attrs as $key => $value)
		{
			if (empty($value))
			{
				continue;
			}

			$output .= $key . ':' . $value . ';';
		}

		return trim($output);
	}


}