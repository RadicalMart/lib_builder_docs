<?php namespace AD\Elements\Library\Tables;

defined('_JEXEC') or die;

use AD\Elements\BaseElement;

class Row extends BaseElement
{


	public function setData($data)
	{
		if (is_array($data))
		{
			foreach ($data as $value)
			{
				$this->addChild($value);
			}

		}
		else
		{
			$this->addChild($data);
		}

		return $this;
	}


	public function addColumn($data)
	{
		return $this->addChild($data);
	}

}