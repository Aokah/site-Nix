<?php function members ()
{
	global $db, $_SESSION, $_GET;
	
	if ($_SESSION['rank'] >= 7) { $ranklimit = 10; } elseif ($_SESSION['rank'] == 6) { $ranklimit = 9;}
	elseif ($_SESSIOON['rank'] == 5) { $ranklimit = 8; } else { $ranklimit = 7; }
	
	$op = $db->query('SELECT COUNT(*) AS op FROM members WHERE rank = 7 AND pnj = 0'); $op = $op->fetch();
	$mj = $db->query('SELECT COUNT(*) AS mj FROM members WHERE rank = 6 AND pnj = 0'); $mj = $mj->fetch();
	$modo = $db->query('SELECT COUNT(*) AS modo FROM members WHERE rank = 5 AND pnj = 0'); $modo = $modo->fetch();
	$enca = $db->query('SELECT COUNT(*) AS enca FROM members WHERE rank = 4 AND pnj = 0'); $enca = $enca->fetch();
	$jplus = $db->query('SELECT COUNT(*) AS jplus FROM members WHERE rank = 3 AND pnj = 0'); $jplus = $jplus->fetch();
	$joueur = $db->query('SELECT COUNT(*) AS joueur FROM members WHERE rank = 2 AND pnj = 0'); $joueur = $joueur->fetch();
	$new = $db->query('SELECT COUNT(*) AS nex FROM members WHERE rank = 1 AND pnj = 0'); $new = $new->fetch();
	$total = $db->query('SELECT COUNT(*) AS total FROM members WHERE rank > 0 AND pnj = 0'); $total = $total->fetch();
	$opplural = ($op['op'] == 1) ? '' : 's'; $mjplural = ($mj['mj'] == 1) ? '' : 's'; $modoplural = ($modo['modo'] == 1) ? '' : 's';
	$encaplural = ($enca['enca'] == 1) ? '' : 's'; $jplusplural = ($jplus['jplus'] == 1) ? '' : 's';
	$joueurplural = ($joueur['joueur'] == 1) ? '' : 's'; $newplural = ($new['new'] == 1) ? 'Nouvel inscrit' : 'Nouveaux inscrits';
	
	?>
	<h2>Les Membres</h2>
	<h3 style="color:red;">Maintenance en cours. . .</h3>
	<p>Voici les <?= $total['total']?> membres inscrits sur Nix ! (comptant <?=$op['op']?> Opérateur<?php echo $opplural; ?>, 
	<?= $mj['mj']?> Maître<?php echo $mjplural;?> du Jeu, <?= $modo['modo']?> Modérateur<?php echo $modoplural;?>, <?=$enca['enca']?> Encadrant<?php echo $encaplural; ?>, 
	<?= $jplus['jplus']?> Joueur<?php echo $jplusplural;?> Investi<?php echo $jplusplural;?>, <?=$joueur['joueur']?> Joueur<?php echo $joueurplural; ?> et <?= $new['new']?> <?php echo $newplural; ?>)</p>
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
				switch ($line['magie_rank'])
				{
					case 0: $level = "Profane"; break; case 1:$level = "Adepte"; break; case 2: $level = "Apprenti Magicien"; break;
					case 3: $level = "Magicien"; break; case 4: $level = "Mage"; break; case 5: $level = "Archimage"; break;
					case 6: $level = "Sage"; break; case 7: $level = "Divin"; break; case 8: $level = "Titanèsque"; break;
					case 9: $level = "Suprême"; break;
				}
			$bgmsg = ($line['valid_bg'] == 1) ? 'BackGround RolePlay validé par le Staff' : 'BackGround en cours d\'écriture...';
			$validbg = ($line['valid_bg'] == 1) ? 'on' : 'off';
			$title = ($line['pionier'] == 1) ? 'Pionier' : $line['title'];
			$title = ($line['ban'] == 1) ? 'Banni' : $line['title'];
			$title = ($line['removed'] == 1) ? 'Oublié' : $line['title'];
			$dignitaire = ($line['dignitaire'] == 1) ? '<span style="color:yellow">(Dignitaire)</span>' : '';
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
					<img src="pics/rank<?php echo $imgrank; ?>.png" alt="" width="30" /> <img src="pics/avatar/miniskin_<?php echo $img;?>.png" alt="" width="30" /> <a href="index?p=perso&perso=<?= $line['id']?>"><?= $line['name']?></a>
				</td>
				<td>
					<?php echo $title; ?> <?php echo $pnj;?> <?php echo $dignitaire; ?>
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
