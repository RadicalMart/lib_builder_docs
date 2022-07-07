<?php namespace AD\Elements\Library\Tables;

defined('_JEXEC') or die;

use AD\Elements\BaseElement;
use AD\Elements\Element;

class Table extends BaseElement
{


	public function addColumn($data = [])
	{

		if (!isset($this->for_render_element['columns']))
		{
			$this->for_render_element['columns'] = [];
		}

		if (isset($data[0]) && is_array($data[0]))
		{
			$this->for_render_element['columns'] = array_merge($this->for_render_element['columns'], $data);
		}
		else
		{
			$this->for_render_element['columns'][] = $data;
		}

		return $this;
	}


	public function addRow($data = [])
	{

		if (!isset($this->for_render_element['rows']))
		{
			$this->for_render_element['rows'] = [];
		}

		$this->for_render_element['rows'][] = $data;

		return $this;
	}


	protected function triggerBeforeRenderData()
	{
		$columns = [];
		$rows    = [];

		foreach ($this->for_render_element['columns'] as $column)
		{
			if ($column['content'] instanceof Element)
			{
				$columns[] = $column['content']->render();
			}

			if (is_string($column['content']))
			{
				$columns[] = $column['content'];
			}
		}

		foreach ($this->for_render_element['rows'] as $row)
		{
			if ($row instanceof Element)
			{
				$rows[] = $row->render();
			}

			if (is_string($row))
			{
				$rows[] = $row;
			}
		}

		return [
			'columns' => $columns,
			'rows'    => $rows
		];
	}
}