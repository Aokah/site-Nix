<?php function magic_level ()
{
	global $db;
	if (isset($_GET['perso']))
	{
		$id = intval($_GET['perso']);
	}
	else
	{
		$id = $_SESSION['id'];
	}
	
	$select = $db->prepare('SELECT * FROM magic_level WHERE id = ? AND spe = 1'); $select->execute(array($id));
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
		$select = $db->prepare('SELECT * FROM magic_level WHERE id = ? AND spe = 2'); $select->execute(array($id));
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
?>
