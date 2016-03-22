<?php function members ()
{
	global $db, $_SESSION, $_GET;
	
	if ($_SESSION['rank'] >= 7) { $ranklimit = 10; } elseif ($_SESSION['rank'] == 6) { $ranklimit = 9;}
	elseif ($_SESSIOON['rank'] == 5) { $ranklimit = 8; } else { $ranklimit = 7; }
	
	$op = $db->execute('SELECT COUNT(*) AS op FROM members WHERE rank = 7'); $op = $op->fetch();
//	$mj = $db->exec('SELECT COUNT(*) AS mj FROM members WHERE rank = 6'); $mj = $mj->fetch();
//	$modo = $db->exec('SELECT COUNT(*) AS dieu FROM members WHERE rank = 5'); $modo = $modo->fetch();
//	$enca = $db->exec('SELECT COUNT(*) AS op FROM members WHERE rank = 4'); $enca = $enca->fetch();
//	$jplus = $db->exec('SELECT COUNT(*) AS mj FROM members WHERE rank = 3'); $jplus = $jplus->fetch();
//	$joueur = $db->exec('SELECT COUNT(*) AS dieu FROM members WHERE rank = 2'); $joueur = $joueur->fetch();
//	$new = $db->exec('SELECT COUNT(*) AS op FROM members WHERE rank = 1'); $new = $new->fetch();
	
	?>
	<h2>Les Membres</h2>
	<h3 style="color:red;">Maintenance en cours. . .</h3>
	<table cellspacing="0" cellpadding="0" width="100%">
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
			
			$page = $db->prepare('SELECT * FROM members WHERE rank = ? ORDER BY name ASC');
			$page->execute(array($linerank));
			?>
			<tr class="member_top">
				<th><?php echo $linename; ?></th>
				<th>Titre</th>
				<th>BG</th>
				<th>Spé'</th>
				<th>Niv'</th>
				<th>Sorts</th>
				<th>Msg</th>
			</tr>
			<?php while ($line = $page->fetch()) { 
			$bgmsg = ($line['valid_bg'] == 1) ? 'BackGround RolePlay validé par le Staff' : 'BackGround en cours d\'écriture...';
			$validbg = ($line['valid_bg'] == 1) ? 'on' : 'off';
			$title = ($line['pionier'] == 1) ? 'Pionier' : $line['title'];
			$title = ($line['ban'] == 1) ? 'Banni' : $line['title'];
			$title = ($line['removed'] == 1) ? 'Oublié' : $line['title'];
			$incan = $db->prepare('SELECT COUNT(*) AS sorts FROM incan_get WHERE user_id = ?');
			$incan->execute(array($line['id'])); $incan = $incan->fetch();
			$fofo = $db->prepare('SELECT COUNT(*) AS msg FROM forum_post WHERE user_id = ?');
			$fofo->execute(array($line['id'])); $fofo = $fofo->fetch();
			$pnj = ($line['pnj'] == 1) ? '<span style="color:yellow">(PNJ)</span>' : '';
			if ($linerank == 10) { $imgrank = "crea"; } elseif ($linerank == 9) { $imgrank = "titan"; } else { $imgrank = $linerank; }
			if ($line['ban'] == 1) { $imgrank = 'ban' ; }
			if ($line['removed'] == 1) { $imgrank = 'del' ; } 
			$filename = 'pics/avatar/miniskin_' .$line['id']. '.png';if (file_exists($filename)) {$img = $line['id'];} else {$img = 'no';}
			?>
			<tr class="memberbg_<?php echo $linerank;?>" valign="middle">
				<td>
					<img src="pics/rank<?php echo $imgrank; ?>.png" alt="" width="30" /> <img src="pics/avatar/miniskin_<?php echo $img;?>.png" alt="" /> <a href="index?p=perso&perso=<?= $line['id']?>"><?= $line['name']?></a>
				</td>
				<td>
					<?php echo $title; ?> <?php echo $pnj;?>
				</td>
				<td style="text-align:center;">
					<img src="pics/valid_bg_<?php echo $validbg;?>.gif" alt="" title="<?php echo $bgmsg; ?>" width="30" />
				</td>
				<td style="text-align:center;">
					<img src="pics/magie/Magie_<?= $line['specialisation']?>.png" width="30" alt="" class="magie_type" title="Affinité Naturelle : <?= $line['specialisation']?>"/> / <img src="pics/magie/Magie_<?= $line['spe_2']?>.png" width="30" alt="" title="Affinité Secondaire : <?= $line['spe_2']?>" class="magie_type" />
				</td>
				<td style="text-align:center;">
					<img src="pics/magie_rank_<?= $line['magie_rank']?>.gif" alt="" title="Niveau <?php echo $level ;?>" />
				</td>
				<td style="text-align:center;">
					<?= $incan['sorts']?>
				</td>
				<td style="text-align:center;">
					<?= $fofo['msg']?>
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
