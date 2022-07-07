<?php defined('_JEXEC') or die;
extract($displayData);
$style = \AD\Utils::buildStyle($style);
?>

<div style="<?php echo $style; ?>">
	<?php foreach ($items as $item) : ?>
		<?php echo $item; ?>
	<?php endforeach; ?>
</div>