<?php defined('_JEXEC') or die;
extract($displayData);
$level = explode('.', $level);

if (!is_array($level))
{
	$level = [];
}

array_shift($level);
$level = (count($level) - 1);

if ($level < 0)
{
	$level = 0;
}

$style['margin-left'] = $level * 10;
$style['margin-left'] .= 'px';
$style                = \AD\Utils::buildStyle($style);
?>

<div style="<?php echo $style; ?>"><?php echo $marker; ?> <?php echo $content; ?><?php echo $child; ?></div>