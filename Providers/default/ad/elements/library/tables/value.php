<?php defined('_JEXEC') or die;
extract($displayData);
$style = \AD\Utils::buildStyle($style);
?>

<td style="<?php echo $style; ?>"><?php echo $content ?></td>