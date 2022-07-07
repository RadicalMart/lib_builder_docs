<?php namespace AD;

defined('_JEXEC') or die;

class Providers
{

	protected static $list = [
		'default' => __DIR__ . '/../Providers/default'
	];


	protected static $default = 'default';


	public static function add(string $name, string $path, bool $default = false)
	{
		static::$list[$name] = $path;

		if ($default)
		{
			static::$default = $name;
		}

		return true;
	}


	public static function get(string $name = '')
	{
		if (empty($name))
		{
			return static::$list[static::$default];
		}

		return static::$list[$name];
	}


}