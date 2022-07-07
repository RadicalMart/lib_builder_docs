<?php defined('_JEXEC') or die;
extract($displayData);
$level_split = explode('.', $level);

if (!is_array($level_split))
{
	$level_split = [];
}

array_shift($level_split);
$count = (count($level_split) - 1);

if ($count < 0)
{
	$count = 0;
}

$style['margin-left'] = $count * 10;
$style['margin-left'] .= 'px';
$style                = \AD\Utils::buildStyle($style);
?>

<div style="<?php echo $style; ?>"><?php echo implode('.', $level_split); ?>. <?php echo $content; ?><?php echo $child; ?></div>