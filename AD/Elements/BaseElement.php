<?php namespace AD\Elements;

defined('_JEXEC') or die;

use AD\Builder;
use AD\Providers;
use Closure;

class BaseElement implements Element
{

	protected $for_render_element = [
		'tag'   => '',
		'style' => [
			'text-align' => 'left',
			'size'       => '',
			'font-size'  => '',
		],
	];


	protected $config = [];


	protected $child = [];


	protected $attributes = [];


	protected $content = '';


	public function __construct(array $config = [])
	{
		$this->config = $config;

		if (isset($this->tag))
		{
			$this->for_render_element['tag'] = $this->tag;
		}
	}


	public function __call($name, $arguments)
	{

		if (strpos($name, 'setStyle') !== false && count($arguments[0]) > 0)
		{
			$name = str_replace('setStyle', '', $name);

			if ($name === '')
			{
				return $this;
			}

			$name_build = strtolower($name[0]);

			for ($i = 1; $i < strlen($name); $i++)
			{
				if (ctype_upper($name{$i}))
				{
					$name_build .= '-';
				}

				$name_build .= strtolower($name{$i});
			}

			$this->for_render_element['style'][$name_build] = $arguments[0];

			return $this;
		}

		return $this;
	}


	public function addChild(Element $element)
	{
		$this->child[] = &$element;

		return $this;
	}


	public function addInElement(Element $element, $switch = false)
	{
		$element->addChild($this);

		if ($switch)
		{
			return $element;
		}

		return $this;
	}


	public function create(string $element)
	{
		return Builder::create($element);
	}


	public function switch(Element $element)
	{
		return $element;
	}


	public function addData(string $name, $value)
	{
		$this->for_render_element[$name] = $value;

		return $this;
	}


	public function apply($apples)
	{

		$do = static function (&$apply, &$element) {
			// если анонимная функция, то просто исполняем
			if ($apply instanceof Closure)
			{
				$apply($element);

				return;
			}

			// если строка с двумя двоеточиями, значит пытаются класс с методом исполнить
			if (is_string($apply) && (strpos($apply, '::') !== false))
			{
				[$class, $method] = explode('::', $apply);
				$class_find = '';

				if (!class_exists($class))
				{
					$namespaces = Builder::getNamespace('apples');
					foreach ($namespaces as $namespace)
					{
						if (class_exists($namespace . '\\' . $class))
						{
							$class_find = $namespace . '\\' . $class;
						}
					}
				}
				else
				{
					$class_find = $class;
				}

				if (!empty($class_find) && method_exists($class_find, $method))
				{
					$class_find::$method($element);

					return;
				}
			}

		};

		if (is_array($apples))
		{
			foreach ($apples as $apply)
			{
				$do($apply, $this);
			}

			return $this;
		}

		$do($apples, $this);

		return $this;
	}


	public function setContent($value)
	{
		$this->content = $value;

		return $this;
	}


	public function getAttribute(string $name, $default = null)
	{
		return $this->attributes[$name] ?? $default;
	}


	public function setAttribute(string $name, $value)
	{
		$this->attributes[$name] = $value;

		return $this;
	}


	public function setTag(string $tag)
	{
		$this->for_render_element['tag'] = $tag;

		return $this;
	}


	public function render()
	{
		$layoutOutput        = '';
		$layout_child_output = '';
		$for_render_element  = [];
		$content             = $this->content;

		$class       = new \ReflectionClass($this);
		$path_layout = strtolower($class->getName());

		$path = implode('/', [
				Providers::get($this->config['provider'] ?? ''),
				$path_layout
			]) . '.php';

		$path = str_replace(['//', '\\'], '/', $path);

		if ($this->child > 0)
		{
			foreach ($this->child as $child)
			{
				$layout_child_output .= $child->render();
			}
		}


		if ($this->for_render_element > 0)
		{
			foreach ($this->for_render_element as $key => $child)
			{
				if (is_array($child))
				{
					$for_render_element[$key] = [];
					foreach ($child as $key_2 => $child_child)
					{
						if ($child_child instanceof Element)
						{
							$for_render_element[$key][$key_2] = $child_child->render();
						}

						$for_render_element[$key][$key_2] = $child_child;
					}

					continue;
				}

				if ($child instanceof Element)
				{
					$for_render_element[$key] = $child->render();
					continue;
				}

				$for_render_element[$key] = $child;
			}
		}


		if ($this->content instanceof Element)
		{
			$content = $this->content->render();
		}

		if (
			is_array($this->content) &&
			isset($this->content[0]) &&
			$this->content[0] instanceof Element
		)
		{
			$content = '';

			foreach ($this->content as $c_content)
			{
				$content .= $c_content->render();
			}
		}

		$displayData = array_merge([
			'content' => $content,
			'child'   => $layout_child_output,
			'align'   => $this->align,
			'attrs'   => $this->attributes
		], $for_render_element);


		if (method_exists($this, 'triggerBeforeRenderData'))
		{
			$displayData = array_merge($displayData, $this->triggerBeforeRenderData());
		}


		if (file_exists($path))
		{
			ob_start();
			include $path;
			$layoutOutput .= ob_get_clean();
		}

		return $layoutOutput;
	}

}