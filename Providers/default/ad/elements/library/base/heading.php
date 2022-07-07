<?php defined('_JEXEC') or die;
extract($displayData);
$style = \AD\Utils::buildStyle($style);
?>

<h<?php echo $level ?? 1?> style="<?php echo $style; ?>"><?php echo $content ?></h<?php echo $level ?? 1?>>