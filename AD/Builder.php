<?php namespace AD;

defined('_JEXEC') or die;

use AD\Elements\BaseElement;

class Builder
{

	protected static $namespaces_library = [
		'\\AD\\Elements\\Library',
	];


	protected static $namespaces_apples = [];


	public static function create(string $element, array $config = [])
	{
		$class_name  = str_replace('.', '/', $element);
		$class_split = explode('/', $class_name);

		foreach ($class_split as &$name)
		{
			$name = ucfirst($name);
		}

		$class_name = implode('\\', $class_split);

		foreach (static::$namespaces_library as $namespace)
		{
			$class = $namespace . '\\' . $class_name;

			if (class_exists($class))
			{
				return (new $class($config));
			}

		}

		return (new BaseElement($config));
	}


	public static function getNamespace($name)
	{
		$name = 'namespaces_' . $name;

		if (isset(self::$$name))
		{
			return self::$$name;
		}

		return [];
	}


	public static function registerNamespaceApples($namespace)
	{
		self::$namespaces_apples[] = $namespace;

		return true;
	}

}