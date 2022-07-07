<?php defined('_JEXEC') or die;
extract($displayData);
$style = \AD\Utils::buildStyle($style);
?>

<tr style="<?php echo $style; ?>"><?php echo $child ?></tr>
