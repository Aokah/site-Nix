<?php function aside()
{
<?if ($_SESSION["rank"] >= 5) { if ($line['count'] >= 1) {?>
							<span style="color: red">[<?= $line['count']?>]</span>
						<? } } ?>
}
?>
