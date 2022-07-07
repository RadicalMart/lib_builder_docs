<?php defined('_JEXEC') or die;
extract($displayData);
$style = \AD\Utils::buildStyle($style);
?>

<p style="<?php echo $style; ?>"><?php echo $content; ?></p>