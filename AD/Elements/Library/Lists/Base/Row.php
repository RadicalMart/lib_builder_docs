<?php namespace AD\Elements\Library\Lists\Base;

defined('_JEXEC') or die;

use AD\Elements\BaseElement;
use AD\Elements\Element;

class Row extends BaseElement
{


	protected $marker = '·';


	public function setMarker($marker)
	{
		$this->marker = $marker;

		return $this;
	}


	public function triggerBeforeRenderData()
	{
		return ['marker' => $this->marker];
	}


}