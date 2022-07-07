<?php namespace AD\Elements\Library\Lists;

defined('_JEXEC') or die;

use AD\Elements\BaseElement;
use AD\Elements\Element;

class Base extends BaseElement
{


	protected $iterator = ['root'];


	protected $items_hash_table = [];


	public function addChild(Element $element)
	{
		$iterator        = $this->getIterator('split');
		$iterator_parent = implode('.', $iterator->iterator);
		$count           = (int) $this->items_hash_table[$iterator_parent]['count'] + 1;
		$iterator_new    = $iterator_parent . '.' . $count;

		$this->items_hash_table[$iterator_new] = [
			'prt'   => $iterator_parent,
			'count' => 0,
			'el'    => $element
		];

		$this->items_hash_table[$iterator_parent]['count'] = $count;
		$this->setIterator($iterator_new);

		return $this;
	}


	public function addLevel()
	{
		$this->iterator[] = 1;

		return $this;
	}


	public function parentLevel()
	{
		array_pop($this->iterator);

		return $this;
	}


	public function getIterator($type = 'string')
	{
		if ($type === 'array')
		{
			$this->iterator;
		}


		if ($type === 'split')
		{
			$iterator = $this->iterator;

			if (count($iterator) === 1)
			{
				return (object) [
					'last'     => '',
					'iterator' => $iterator
				];
			}

			return (object) [
				'last'     => array_pop($iterator),
				'iterator' => $iterator
			];
		}

		return implode('.', $this->iterator);
	}


	public function setIterator($iterator)
	{
		if (is_array($iterator))
		{
			$this->iterator = $iterator;
		}

		if (is_string($iterator))
		{
			$this->iterator = explode('.', $iterator);
		}

		return $this;
	}


	public function triggerBeforeRenderData()
	{
		$items = [];

		foreach ($this->items_hash_table as $key => $row)
		{
			if (isset($row['el']) && $row['el'] instanceof Element)
			{
				$row['el']->addData('level', $key);
				$items[] = $row['el']->render();
			}

		}

		return ['items' => $items];
	}

}