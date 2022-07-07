<?php namespace AD\Elements\Library\Base;

defined('_JEXEC') or die;

use AD\Elements\BaseElement;

class Link extends BaseElement
{


	public function setLink($link)
	{
		$this->for_render_element['link'] = $link;

		return $this;
	}


}