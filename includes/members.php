<?php function members ()
{
	global $db, $_SESSION, $_GET;
	
	if ($_SESSION['rank'] >= 7) { $ranklimit = 10; } elseif ($_SESSION['rank'] == 6) { $ranklimit = 9;}
	elseif ($_SESSIOON['rank'] == 5) { $ranklimit = 8; } else { $ranklimit = 7; }
	
	?>
	<h2>Les Membres</h2>
	<h3 style="color:red;">Maintenance en cours. . .</h3>
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
			if ($linerank == 10) { $imgrank = "crea"; } elseif ($linerank == 9) { $imgrank = "titan"; } else { $imgrank = $linerank; }
			switch ($line['magie_rank'])
			{
				case 0: $level = "Profane"; break; case 1:$level = "Adepte"; break; case 2: $level = "Apprenti Magicien"; break;
				case 3: $level = "Magicien"; break; case 4: $level = "Mage"; break; case 5: $level = "Archimage"; break;
				case 6: $level = "Sage"; break; case 7: $level = "Divin"; break; case 8: $level = "Titanèsque"; break;
				case 9: $level = "Suprême"; break;
			}
			
			$page = $db->prepare('SELECT * FROM members WHERE rank = ? ORDER BY name ASC');
			$page->execute(array($linerank));
			
			$bgmsg = ($line['valid_bg'] == 1) ? 'BackGround RolePlay validé par le Staff' : 'BackGround en cours d\'écriture...';
			$validbg = ($line['valid_bg'] == 1) ? 'on' : 'off';
			$title = ($line['pionier'] == 1) ? 'Pionier' : $line['title'];
			$title = ($line['ban'] == 1) ? 'Banni' : $line['title'];
			$title = ($line['removed'] == 1) ? 'Oublié' : $line['title'];
			?>
			<tr>
				<th><?php echo $linename; ?></th>
				<th>Titre</th>
				<th>BG</th>
				<th>Spé'</th>
				<th>Niv'</th>
			</tr>
			<?php while ($line = $page->fetch()) { ?>
			<tr>
				<td>
					<img src="pics/rank<?php echo $imgrank; ?>.png" alt="" width="30" /> <img src="pics/avatar/miniskin_<?= $line['id']?>.png" alt="" /> <?= $line['name']?>
				</td>
				<td>
					<?php echo $title; ?>
				</td>
				<td>
					<img src="pics/valid_bg_<?php echo $validbg;?>.gif" alt="" title="<?php echo $bgmsg; ?>" width="30" />
				</td>
				<td>
					<img src="pics/magie/Magie_<?= $line['specialisation']?>.png" width="30" alt="" class="magie_type" title="<?= $line['specialisation']?>"/> / <img src="pics/magie/Magie_<?= $line['spe_2']?>.png" width="30" alt="" title="<?= $line['spe_2']?>" class="magie_type" />
				</td>
				<td>
					<img src="pics/magie_rank_<?= $line['magie_rank']?>.gif" alt="" title="Niveau <?php echo $level ;?>" />
				</td>
			</tr>
			<?php
			}
			$linerank--;
		}
	?>
		</tbody>
	</table>
<?php
} ?>
