<?php function members ()
{
	global $db, $_SESSION, $_GET;
	
	if ($_SESSION['rank'] >= 7) { $ranklimit = 10; } elseif ($_SESSION['rank'] == 6) { $ranklimit = 9;}
	elseif ($_SESSIOON['rank'] == 5) { $ranklimit = 8; } else { $ranklimit = 7; }
	
	if (isset($_GET['search']))
	{
		$search = intval($_GET['search']);
	}
	else
	{
		$page = $db->prepare('SELECT * FROM members WHERE rank >= ? ORDER BY rank DESC, name ASC');
		$page->execute(array($ranklimit));
	}
	?>
	<table>
		<tbody>
	<?php
	$linerank = $ranklimit;
	while ($linerank >= 1)
	{
			switch ($linerank)
			{
				case 10 : $linename = "Consciences"; break; case 9 : $linename = "Titans"; break; case 8: $linename = "Dieux"; break;
				case 7: $linename = "Opérateurs"; break; case 6: $linename = "Maitres du Jeu"; break; case 5 : $linename = "Modérateurs"; break;
				case 4: $linename = "Encadrants"; break; case 3 : $linename = "Joueurs Investis"; break; case 2 : $linename = "Joueurs"; break;
				case 1: $linename = "Nouveaux"; break;
			}
			switch ($line['magie_rank'])
			{
				case 0: $level = "Profane"; break; case 1:$level = "Adepte"; break; case 2: $level = "Apprenti Magicien"; break;
				case 3: $level = "Magicien"; break; case 4: $level = "Mage"; break; case 5: $level = "Archimage"; break;
				case 6: $level = "Sage"; break; case 7: $level = "Divin"; break; case 8: $level = "Titanèsque"; break;
				case 9: $level = "Suprême"; break;
			}
			?>
			<tr>
				<th><?php echo $linename; ?></th>
				<th>Titre</th>
				<th>BG</th>
				<th>Spé'</th>
				<th>Niv'</th>
			</tr>
			<tr>
				<td>
					<img src="pics/rank<?php echo $linerank; ?>.png" alt="" width="27" /> <img src="pics/avatar/miniskin_<?= $line['id']?>.png" alt="" /> <?= $line['name']?>
				</td>
				<td>
					<?php echo $title; ?>
				</td>
				<td>
					BG
				</td>
				<td>
					<img src="pics/magie/Magie_<?= $line['specialisation']?>.png" alt="" class="magie" title="<?= $line['specialisation']?>"/> / <img src="pics/magie/Magie_<?= $line['spe_2']?>.png" alt="" title="<?= $line['spe_2']?>" class="magie" />
				</td>
				<td>
					<img src="pics/magie_rank_<?= $line['magie_rank']?>.gif" alt="" title="Niveau <?php echo $level ;?>" />
				</td>
			</tr>
			<?php
			echo '<p>Tableau du rang '. $linerank .' ('. $linename .').</p>';
			$linerank--;
		}
	}
	?>
		</tbody>
	</table>
<?php
} ?>
