<?php function magic_level ()
{
	global $db;
	
	$select = $db->prepare('SELECT * FROM magic_level WHERE id = ? AND spe = 1'); $select->execute(array($_SESSION['id']));
	while ($line = $select->fetch())
	{
?>
		<table>
			<tbody>
				<tr>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
	<?php 
	}
	if ($line['spe_2'] != "Inconnue")
	{
		$select = $db->prepare('SELECT * FROM magic_level WHERE id = ? AND spe = 2'); $select->execute(array($_SESSION['id']));
		while ($line = $select->fetch())
		{
		?>
				<tr>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
	<?php	
		}
	} ?>
			</tbody>
		</table>
<?php
	}
}
?>
