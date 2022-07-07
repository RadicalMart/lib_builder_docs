<?php defined('_JEXEC') or die;
extract($displayData);
$style = \AD\Utils::buildStyle($style);
?>

<a href="<?php echo $link; ?>" style="<?php echo $style; ?>"><?php echo $content; ?></a>