<?php namespace AD\Elements\Library\Base;

defined('_JEXEC') or die;

use AD\Elements\BaseElement;

class Heading extends BaseElement
{


	public function setLevel($level = 1)
	{
		$this->for_render_element['level'] = (string) $level;

		return $this;
	}


}