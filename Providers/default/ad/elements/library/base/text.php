<?php defined('_JEXEC') or die;
extract($displayData);
$style = \AD\Utils::buildStyle($style);
?>

<<?php echo $tag ?> style="<?php echo $style; ?>"><?php echo $content; ?></<?php echo $tag ?>>