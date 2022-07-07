<?php namespace AD;

defined('_JEXEC') or die;

class Config
{

	protected static $params = [];


	public static function set(string $name, $value)
	{
		static::$params[$name] = $value;

		return true;
	}


	public static function get(string $name, $default = null)
	{
		return static::$params[$name] ?? $default;
	}


}