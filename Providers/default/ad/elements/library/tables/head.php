<?php defined('_JEXEC') or die;
extract($displayData);
$style = \AD\Utils::buildStyle($style);
?>

<th style="<?php echo $style; ?>"><?php echo $content ?></th>
