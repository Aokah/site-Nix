<?php function roles ()
{
	global $db, $_SESSION;
	
	if ($_SESSION['connected'])
	{
		if ($_SESSION['rank'] > 4)
		{
			$select = $db->query('SELECT * FROM members WHERE rank > 4 AND rank < 8 AND dignitaire = 0 AND pnj = 0 ORDER BY Rank DESC');
			?>
			<table class="member_top" style="text-align:center;" cellpadding="1%">
				<tbody>
					<tr>
						<th>Staffeux</th> <th>Tâche assignée</th> <th>Détails</th> <th>Statut de la tâche</th>
					</tr>
					
					<?php
					while ($line = $select->fetch())
					{
						$presel = $db->prepare('SELECT * FROM roles WHERE user_id = ?');
						$presel->execute(array($line['id']));
						if ($line_ = $presel->fetch())
						{
							$role = $line_['name'];
							$desc = $line_["descritpion"];
							$state = $line_["state"];
						}
						else
						{
							$role = "Pas encore de tâche donnée";
							$desc = "Aucune description disponible.";
							$state = "N/A";
						}
					?>
					<tr class="memberbg_<?= $line['rank']?>">
						<td>
							<span class="name<?= $line['rank']?>"><?= $line['name']?></span>
						</td>
						<td>
							<p>
								<?= $role ?>
							</p>
						</td>
						<td>
							<p>
								<?= $desc?>
							</p>
						</td>
						<td>
							<P>
								<?= $state?>
							</P>
						</td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<?php
		}
		else
		{
			echo "<p>Navré mais vous ne possédez pas le grade suffisant pour accéder à cette page.</p>";
		}
	}
	else
	{
		echo '<p>Veuillez vous connecter pour accéder à cette page.</p>';
	}
}
?>
