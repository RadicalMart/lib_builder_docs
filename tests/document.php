<?php defined('_JEXEC') or die;
extract($displayData);

use AD\Builder;
use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use RZtrade\Helpers\FormatHelper;
use RZtrade\Helpers\PriceHelper;

/**
 * @var CMSObject $lot              // Объект лота
 * @var CMSObject $sell_company     // Объект компании продавца
 * @var CMSObject $buy_company      // Объект компании покупателя
 * @var numeric   $deposit          // Залог покупателя, для участия в торгах
 * @var string    $delivery_address // Адрес, куда доставляют лот
 * @var array     $final_rates      // Последние ставки всех участников торгов
 * @var array     $metals           // Состав лота
 * @var string    $type_name        // Тип металла, который продавали
 */

$heading_content = <<<EOF
<strong>ПРОТОКОЛ</strong><br>
<strong>о результатах торгов по реализации невостребованного имущества</strong><br>
(имеет силу договора в соответствии с п.6 ст. 448 Гражданского кодекса Российской Федерации)
EOF;

$intro_content = <<<EOF
<strong>%s</strong> являющееся организатором торгов по продаже 
невостребованного имущества (далее именуется - &laquo;Организатор торгов&raquo;), 
в лице <strong>%s</strong> действующего на основании <strong>%s</strong>, с одной 
стороны, и <strong>%s</strong> именуемый в дальнейшем &laquo;Победитель торгов&raquo;, 
проведенных с 09 час. 00 мин. по 17 час. 00 мин. по московскому времени по адресу: 
город Москва, на Сайте RZTRADE.RU по адресу в сети Интернет: https://rztrade.ru, 
в которых приняли участие:
EOF;


$style_page = static function () {
	return <<<EOF
/**
 * Этот стиль нужно вставлять во все документы. Это отступы на листе
 *
 **/
@page {
	margin-top: 2cm;
	margin-right: 2cm;
	margin-bottom: 2cm;
	margin-left: 2cm;
}
EOF;
};

$style_heading = static function ($element) {
	$element->setStyleMarginTop('0')
		->setStyleMarginRight('0')
		->setStyleMarginBottom('0')
		->setStyleMarginLeft('0')
		->setStyleTextAlign('center')
		->setStyleTextIndent('1cm')
		->setStyleLineHeight('1.15')
		->setStyleFontSize('12.0pt')
		->setStyleFontFamily('Times New Roman, Times, serif');
};

$style_text = static function (&$element) {
	$element->setStyleMarginTop('6.0pt')
		->setStyleMarginRight('0')
		->setStyleMarginBottom('0')
		->setStyleMarginLeft('0')
		->setStyleTextAlign('justify')
		->setStyleTextIndent('1cm')
		->setStyleLineHeight('1.15')
		->setStyleFontSize('12.0pt')
		->setStyleFontFamily('Times New Roman, Times, serif');
};

$style_tr_border_rb = static function ($element) {
	$element
		->setStylePadding('0 5.4pt 0 5.4pt')
		->setStyleBorderRight('1pt solid windowtext')
		->setStyleBorderBottom('1pt solid windowtext');
};

$style_tr_border_lrb = static function ($element) {
	$element
		->setStylePadding('0 5.4pt 0 5.4pt')
		->setStyleBorderLeft('1pt solid windowtext')
		->setStyleBorderRight('1pt solid windowtext')
		->setStyleBorderBottom('1pt solid windowtext');
};

$style_tr_border_lb = static function ($element) {
	$element
		->setStylePadding('0 5.4pt 0 5.4pt')
		->setStyleBorderLeft('1pt solid windowtext')
		->setStyleBorderBottom('1pt solid windowtext');
};

$style_tr_border = static function ($element) {
	$element
		->setStylePadding('0 5.4pt 0 5.4pt')
		->setStyleBorderTop('1pt solid windowtext')
		->setStyleBorderRight('1pt solid windowtext')
		->setStyleBorderBottom('1pt solid windowtext')
		->setStyleBorderLeft('1pt solid windowtext');
};

$style_tr_border_rt = static function ($element) {
	$element
		->setStylePadding('0 5.4pt 0 5.4pt')
		->setStyleBorderRight('1pt solid windowtext')
		->setStyleBorderTop('1pt solid windowtext');
};

$style_tr_border_lrt = static function ($element) {
	$element
		->setStylePadding('0 5.4pt 0 5.4pt')
		->setStyleBorderLeft('1pt solid windowtext')
		->setStyleBorderRight('1pt solid windowtext')
		->setStyleBorderTop('1pt solid windowtext');
};

$style_tr_border_lt = static function ($element) {
	$element
		->setStylePadding('0 5.4pt 0 5.4pt')
		->setStyleBorderLeft('1pt solid windowtext')
		->setStyleBorderTop('1pt solid windowtext');
};

$style_tr_border_rtb = static function ($element) {
	$element
		->setStylePadding('0 5.4pt 0 5.4pt')
		->setStyleBorderRight('1pt solid windowtext')
		->setStyleBorderTop('1pt solid windowtext')
		->setStyleBorderBottom('1pt solid windowtext');
};
$style_tr_border_ltb = static function ($element) {
	$element
		->setStylePadding('0 5.4pt 0 5.4pt')
		->setStyleBorderLeft('1pt solid windowtext')
		->setStyleBorderTop('1pt solid windowtext')
		->setStyleBorderBottom('1pt solid windowtext');
};


$layout = Builder::create('base.layout');


Builder::create('base.heading')
	->setContent($heading_content)
	->apply($style_heading)
	->addInElement($layout);


Builder::create('base.p')
	->setContent('&nbsp;')
	->apply($style_text)
	->addInElement($layout);


Builder::create('base.p')
	->setContent(Factory::getDate()->format('«d» F Y г.'))
	->apply($style_text)
	->setStyleTextAlign('center')
	->addInElement($layout);


Builder::create('base.p')
	->setContent(
		sprintf(
			$intro_content,
			$sell_company->inface,
			$sell_company->acting_on_the_basis,
			$buy_company->title_full,
			Factory::getDate(
				$lot->date_auction_end, new \DateTimeZone('Europe/Moscow')
			)->format('«d» F Y г.'),
		)
	)
	->apply($style_text)
	->addInElement($layout);


$list = Builder::create('lists.base');

Builder::create('lists.number.row')
	->setContent('Item 1')
	->apply($style_text)
	->addInElement($list, true)
	->addLevel()

    // Можно создавать без вызова класса билдера, не разрывать цепь вызовов
    ->create('lists.number.row')
	->setContent('Item 1.1')
	->apply($style_text)
	->addInElement($list, true)
    ->create('lists.number.row')
	->setContent('Item 1.2')
	->apply($style_text)
	->addInElement($list, true)
	->addLevel();

// Можно вызывать и просто класс билдера
Builder::create('lists.number.row')
	->setContent('Item 1.2.1')
	->apply($style_text)
	->addInElement($list, true);

Builder::create('lists.number.row')
	->setContent('Item 1.2.2')
	->apply($style_text)
	->addInElement($list, true)
	->addLevel();


Builder::create('lists.base.row')
	->setContent('Item 1.2.2.1')
	->apply($style_text)
	->addInElement($list, true);

Builder::create('lists.base.row')
	->setContent('Item 1.2.2.2')
	->apply($style_text)
	->addInElement($list, true)
	->parentLevel()
	->parentLevel();

Builder::create('lists.number.row')
	->setContent('Item 1.3')
	->apply($style_text)
	->addInElement($list, true)
	->parentLevel()
	->parentLevel();

Builder::create('lists.number.row')
	->setContent('Item 2')
	->apply($style_text)
	->addInElement($list, true)
	->addInElement($layout);


$table_rates = Builder::create('tables.table')
	->setStyleWidth('100%')
	->setStyleBorderCollapse('collapse');


/** Добавляем колонки */
$table_rates
	->addColumn(
		[
			'id'      => 'id',
			'content' => Builder::create('tables.head')
				->setContent('<strong>№</strong>')
				->apply([$style_text, $style_tr_border_rb])
				->setStyleTextAlign('center')
		]
	)
	->addColumn(
		[
			'id'      => 'click',
			'content' => Builder::create('tables.head')
				->setContent('<strong>Участники торгов</strong>')
				->apply([$style_text, $style_tr_border_rb])
				->setStyleTextAlign('center')
		]
	)
	->addColumn(
		[
			'id'      => 'price',
			'content' => Builder::create('tables.head')
				->setContent('<strong>Предложения о цене</strong>')
				->apply([$style_text, $style_tr_border_rb])
				->setStyleTextAlign('center')
		]
	);


if (!empty($clicks))
{
	foreach ($clicks as $click)
	{
		// можно списком передать данные, надо соблюдать порядок в котором сами колонки добавлялись
		$table_rates
			->addRow(
				Builder::create('tables.row')
					->setData([
							Builder::create('tables.value')
								->setContent($click->ordering)
								->apply([$style_text, $style_tr_border_rb]),
							Builder::create('tables.value')
								->setContent($click->title_short ??
									'Участник №' . $click->ordering
									. ' ' . '( ИНН ' . ($click->inn ??
										'----------') . ' )')
								->apply([$style_text, $style_tr_border_rb]),
							Builder::create('tables.value')
								->setContent(
									PriceHelper::toString(
										FormatHelper::priceForLot(
											$click->price
										)
									)
								)
								->apply([$style_text, $style_tr_border_rb]),
						]
					)
			);
	}
}
else
{
	// или можно через метод addColumn, вместо setData
	$table_rates
		->addRow(
			Builder::create('tables.row')
				->addColumn(
					Builder::create('tables.value')
						->setContent('&nbsp')
						->apply($style_tr_border_rt)
				)
				->addColumn(
					Builder::create('tables.value')
						->setContent('&nbsp')
						->apply($style_tr_border_rt)
				)
				->addColumn(
					Builder::create('tables.value')
						->setContent('&nbsp')
						->apply($style_tr_border_rt)
				)
		);
}

$table_rates
	->addRow(
		Builder::create('tables.row')
			->setData([
				Builder::create('tables.value')
					->setContent('&nbsp')
					->apply($style_tr_border_rt),
				Builder::create('tables.value')
					->setContent('&nbsp')
					->apply($style_tr_border_rt),
				Builder::create('tables.value')
					->setContent('&nbsp')
					->apply($style_tr_border_rt)
			]));

$table_rates->addInElement($layout);

echo "[_STYLE_]{$style_page()}[/_STYLE_][_CONTENT_]{$layout->render()}[/_CONTENT_]";