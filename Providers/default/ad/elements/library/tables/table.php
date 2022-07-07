<?php defined('_JEXEC') or die;
extract($displayData);
$style = \AD\Utils::buildStyle($style);
?>

<table style="<?php echo $style; ?>">

	<thead>
        <tr>
            <?php foreach ($columns as $column) : ?>
               <?php echo $column; ?>
            <?php endforeach; ?>
        </tr>
	</thead>

	<tbody>
		<?php foreach ($rows as $row) : ?>
		    <?php echo $row; ?>
        <?php endforeach; ?>
	</tbody>

</table>