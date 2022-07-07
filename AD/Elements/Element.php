<?php namespace AD\Elements;

defined('_JEXEC') or die;

interface Element
{

	public function addChild(Element $element);


    public function create(string $element);


    public function switch(Element $element);


    public function addData(string $name, $value);


	public function setContent(string $value);


	public function getAttribute(string $name, $default = null);


	public function setAttribute(string $name, $value);


	public function apply($apples);


    public function addInElement(Element $element, $switch = false);


	public function setTag(string $tag);


	public function render();


}