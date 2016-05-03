<?php function members ()
{
	global $db, $_SESSION, $_GET;
	
	if ($_SESSION['rank'] >= 7) { $ranklimit = 10; } elseif ($_SESSION['rank'] == 6) { $ranklimit = 9;}
	elseif ($_SESSIOON['rank'] == 5) { $ranklimit = 8; } else { $ranklimit = 7; }
	
	$op = $db->query('SELECT COUNT(*) AS op FROM members WHERE rank = 7 AND pnj = 0 AND invisible = 0'); $op = $op->fetch();
	$mj = $db->query('SELECT COUNT(*) AS mj FROM members WHERE rank = 6 AND pnj = 0 AND invisible = 0'); $mj = $mj->fetch();
	$modo = $db->query('SELECT COUNT(*) AS modo FROM members WHERE rank = 5 AND pnj = 0 AND invisible = 0'); $modo = $modo->fetch();
	$enca = $db->query('SELECT COUNT(*) AS enca FROM members WHERE rank = 4 AND pnj = 0 AND invisible = 0'); $enca = $enca->fetch();
	$jplus = $db->query('SELECT COUNT(*) AS jplus FROM members WHERE rank = 3 AND pnj = 0 AND invisible = 0'); $jplus = $jplus->fetch();
	$joueur = $db->query('SELECT COUNT(*) AS joueur FROM members WHERE rank = 2 AND pnj = 0 AND invisible = 0'); $joueur = $joueur->fetch();
	$new = $db->query('SELECT COUNT(*) AS new FROM members WHERE rank = 1 AND pnj = 0 AND invisible = 0'); $new = $new->fetch();
	$total = $db->query('SELECT COUNT(*) AS total FROM members WHERE rank > 0 AND pnj = 0 AND invisible = 0'); $total = $total->fetch();
	$opplural = ($op['op'] == 1) ? '' : 's'; $mjplural = ($mj['mj'] == 1) ? '' : 's'; $modoplural = ($modo['modo'] == 1) ? '' : 's';
	$encaplural = ($enca['enca'] == 1) ? '' : 's'; $jplusplural = ($jplus['jplus'] == 1) ? '' : 's';
	$joueurplural = ($joueur['joueur'] == 1) ? '' : 's'; $newplural = ($new['new'] == 1) ? 'Nouvel inscrit' : 'Nouveaux inscrits';
	
	// Activité globale
	$act_new = $db->query('SELECT COUNT(*) AS act_new FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 2 AND ADDDATE(last_action, INTERVAL 3 WEEK)> NOW()'); $act_new = $act_new->fetch();
	$new_all = $db->query('SELECT COUNT(*) AS new_all FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 2'); $new_all = $new_all->fetch();
	$act_jplus = $db->query('SELECT COUNT(*) AS act_jplus FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 3 AND ADDDATE(last_action, INTERVAL 3 WEEK)> NOW()'); $act_jplus = $act_jplus->fetch();
	$jplus_all = $db->query('SELECT COUNT(*) AS jplus_all FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 3'); $jplus_all = $jplus_all->fetch();
	$act_enca = $db->query('SELECT COUNT(*) AS act_enca FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 4 AND ADDDATE(last_action, INTERVAL 3 WEEK)> NOW()'); $act_enca = $act_enca->fetch();
	$enca_all = $db->query('SELECT COUNT(*) AS enca_all FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 4'); $enca_all = $enca_all->fetch();
	$act_modo = $db->query('SELECT COUNT(*) AS act_modo FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 5 AND ADDDATE(last_action, INTERVAL 3 WEEK)> NOW()'); $act_modo = $act_modo->fetch();
	$modo_all = $db->query('SELECT COUNT(*) AS modo_all FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 5'); $modo_all = $modo_all->fetch();
	$act_mj = $db->query('SELECT COUNT(*) AS act_mj FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 6 AND ADDDATE(last_action, INTERVAL 3 WEEK)> NOW()'); $act_mj = $act_mj->fetch();
	$mj_all = $db->query('SELECT COUNT(*) AS mj_all FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 6'); $mj_all = $mj_all->fetch();
	$act_op = $db->query('SELECT COUNT(*) AS act_op FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 7 AND ADDDATE(last_action, INTERVAL 3 WEEK)> NOW()'); $act_op = $act_op->fetch();
	$op_all = $db->query('SELECT COUNT(*) AS op_all FROM members WHERE invisible = 0 AND pnj = 0 AND removed = 0 AND ban = 0 AND rank = 7'); $op_all = $op_all->fetch();
	$m_active = $act_op['act_op'] + $act_mj['act_mj'] + $act_modo['act_modo'] + $act_enca['act_enca'] + $act_jplus['act_jplus'] + $act_new['act_new'];
	$m_all = $op_all['op_all'] + $mj_all['mj_all'] + $modo_all['modo_all'] + $enca_all['enca_all'] + $jplus_all['jplus_all'] + $new_all['new_all'] ;
	$m_pourcent = ( $m_active/ $m_all) * 100; $m_pourcent = number_format($m_pourcent, 2);
	
	?>
	<h2>Les Membres</h2>
	<p>Voici les <?= $total['total']?> membres inscrits sur Nix ! (comptant <?=$op['op']?> Opérateur<?php echo $opplural; ?>, 
	<?= $mj['mj']?> Maître<?php echo $mjplural;?> du Jeu, <?= $modo['modo']?> Modérateur<?php echo $modoplural;?>, <?=$enca['enca']?> Encadrant<?php echo $encaplural; ?>, 
	<?= $jplus['jplus']?> Joueur<?php echo $jplusplural;?> Investi<?php echo $jplusplural;?>, <?=$joueur['joueur']?> Joueur<?php echo $joueurplural; ?> et <?= $new['new']?> <?php echo $newplural; ?>)</p>
	<?php if ($_SESSION['rank'] >= 4) { ?>
		<p>Ce site compte près de <?= $m_active, ' membres actifs sur ', $m_all?> soit <span class="name1" style="color:white;"><?= $m_pourcent?>%</span> des membres inscrits <br />( <span class="name7"><?= 
		$act_op['act_op'], '/', $op_all['op_all']?> Opérateurs</span> <span class="name6"><?= $act_mj['act_mj'], '/', $mj_all['mj_all']?> Maîtres du Jeu</span> <span class="name5"><?= 
		$act_modo['act_modo'], '/', $modo_all['modo_all']?> Modérateurs</span> <span class="name4"><?= $act_enca['act_enca'], '/', $enca_all['enca_all']?> Encadrants</span> <span class="name3"><?= 
		$act_jplus['act_jplus'], '/', $jplus_all['jplus_all']?> Joueurs Investis</span> <span class="name2"><?= $act_new['act_new'], '/', $new_all['new_all']?> Joueurs</span> )</p>
	<?php } ?>
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
			if ($_SESSION['rank'] >= 5) { $page = $db->prepare('SELECT * FROM members WHERE rank = ? ORDER BY name ASC'); }
			else { $page = $db->prepare('SELECT * FROM members WHERE rank = ? AND pnj = 0 AND invisible = 0 AND removed = 0 AND ban = 0 ORDER BY name ASC');	}
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
				<th>HRP</th>
				<th>Activité</th>
			<?php if ($_SESSION['rank'] >= 5) { ?> <th>Inv'</th> <?php } ?>
				<th>Energie Magique/Vitale</th>
			</tr>
			<?php while ($line = $page->fetch()) { 
					if ($line['magie_rank'] == 0) {	if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 4)  { $tmagie = 0 ; } if ($line['E_magique'] >=5 AND $line['E_magique'] <= 10) { $tmagie = 10 ;}	if ($line['E_magique'] >=10 AND $line['E_magique'] <= 14) { $tmagie = 20 ;}
						if ($line['E_magique'] >=15 AND $line['E_magique'] <= 19) { $tmagie = 30 ; } if ($line['E_magique'] >=20 AND $line['E_magique'] <= 24) { $tmagie = 40 ; } if ($line['E_magique'] >=25 AND $line['E_magique'] <= 29) { $tmagie = 50 ; }
						if ($line['E_magique'] >=30 AND $line['E_magique'] <= 34) { $tmagie = 60 ; } if ($line['E_magique'] >=35 AND $line['E_magique'] <= 39) { $tmagie = 70 ; } if ($line['E_magique'] >=40 AND $line['E_magique'] <= 44) { $tmagie = 80 ; }
						if ($line['E_magique'] >=45 AND $line['E_magique'] <= 49) { $tmagie = 90 ; } if ($line['E_magique'] == 50) { $tmagie = 100 ; }if ($line['E_magique'] > 50)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 1) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 9) { $tmagie = 0 ; } if ($line['E_magique'] >=10 AND $line['E_magique'] <= 19) { $tmagie = 10 ; } if ($line['E_magique'] >=20 AND $line['E_magique'] <= 29) { $tmagie = 20 ; }
						if ($line['E_magique'] >=30 AND $line['E_magique'] <= 39) { $tmagie = 30 ;} if ($line['E_magique'] >=40 AND $line['E_magique'] <= 49) { $tmagie = 40 ; } if ($line['E_magique'] >=50 AND $line['E_magique'] <= 59) { $tmagie = 50 ; }
						if ($line['E_magique'] >=60 AND $line['E_magique'] <= 69) { $tmagie = 60 ; } if ($line['E_magique'] >=70 AND $line['E_magique'] <= 79) { $tmagie = 70 ; } if ($line['E_magique'] >=80 AND $line['E_magique'] <= 89)  { $tmagie = 80 ; }
						if ($line['E_magique'] >=90 AND $line['E_magique'] <= 99) { $tmagie = 90 ; } if ($line['E_magique'] == 100) { $tmagie = 100 ;} if ($line['E_magique'] > 100)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 2) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 14) { $tmagie = 0 ; } if ($line['E_magique'] >=15 AND $line['E_magique'] <= 29) 	{ $tmagie = 10 ; } if ($line['E_magique'] >=30 AND $line['E_magique'] <= 44)  { $tmagie = 20 ; }
						if ($line['E_magique'] >=45 AND $line['E_magique'] <= 59) { $tmagie = 30 ; } if ($line['E_magique'] >=60 AND $line['E_magique'] <= 74) { $tmagie = 40 ; } if ($line['E_magique'] >=75 AND $line['E_magique'] <= 89) { $tmagie = 50 ; }
						if ($line['E_magique'] >=90 AND $line['E_magique'] <= 104) { $tmagie = 60 ; } if ($line['E_magique'] >=105 AND $line['E_magique'] <= 119) { $tmagie = 70 ; } if ($line['E_magique'] >=120 AND $line['E_magique'] <= 134) { $tmagie = 80 ; }
						if ($line['E_magique'] >=135 AND $line['E_magique'] <= 149) { $tmagie = 90 ; } if ($line['E_magique'] == 150)  { $tmagie = 100 ; }if ($line['E_magique'] > 150)  { $tmagie = "over" ; }		}
					if ($line['magie_rank'] == 3) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 19) { $tmagie = 0 ; } if ($line['E_magique'] >= 20 AND $line['E_magique'] <= 39) { $tmagie = 10 ; } if ($line['E_magique'] >= 40 AND $line['E_magique'] <= 59) { $tmagie = 20 ; }
						if ($line['E_magique'] >= 60 AND $line['E_magique'] <= 79) { $tmagie = 30 ; } if ($line['E_magique'] >= 80 AND $line['E_magique'] <= 99) { $tmagie = 40 ; } if ($line['E_magique'] >= 100 AND $line['E_magique'] <= 119) { $tmagie = 50 ; }
						if ($line['E_magique'] >= 120 AND $line['E_magique'] <= 139) { $tmagie = 60 ; } if ($line['E_magique'] >= 140 AND $line['E_magique'] <= 159) { $tmagie = 70 ; } if ($line['E_magique'] >= 160 AND $line['E_magique'] <= 179) { $tmagie = 80 ; }
						if ($line['E_magique'] >= 180 AND $line['E_magique'] <= 199) { $tmagie = 90 ; } if ($line['E_magique'] == 200) { $tmagie = 100; }if ($line['E_magique'] > 200) { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 4) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 29) { $tmagie = 0 ;} if ($line['E_magique'] >= 30 AND $line['E_magique'] <= 59)  { $tmagie = 10 ;} if ($line['E_magique'] >= 60 AND $line['E_magique'] <= 89) { $tmagie = 20 ;}
						if ($line['E_magique'] >= 90 AND $line['E_magique'] <= 119) { $tmagie = 30 ;} if ($line['E_magique'] >= 120 AND $line['E_magique'] <= 149) { $tmagie = 40 ;} if ($line['E_magique'] >= 150 AND $line['E_magique'] <= 179) { $tmagie = 50 ;}
						if ($line['E_magique'] >= 180 AND $line['E_magique'] <= 209) { $tmagie = 60 ;} if ($line['E_magique'] >= 210 AND $line['E_magique'] <= 239) { $tmagie = 70 ;} if ($line['E_magique'] >= 240 AND $line['E_magique'] <= 269) { $tmagie = 80 ;}
						if ($line['E_magique'] >= 270 AND $line['E_magique'] <= 299) { $tmagie = 90 ;} if ($line['E_magique'] == 300)  { $tmagie = 100 ; } if ($line['E_magique'] > 300)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 5) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 39) { $tmagie = 0 ; } if ($line['E_magique'] >= 40 AND $line['E_magique'] <= 79) { $tmagie = 10 ; } if ($line['E_magique'] >= 80 AND $line['E_magique'] <= 119) { $tmagie = 20 ; }
						if ($line['E_magique'] >= 120 AND $line['E_magique'] <= 159) { $tmagie = 30 ; } if ($line['E_magique'] >= 160 AND $line['E_magique'] <= 199) { $tmagie = 40 ; } if ($line['E_magique'] >= 200 AND $line['E_magique'] <= 239) { $tmagie = 50 ; }
						if ($line['E_magique'] >= 240 AND $line['E_magique'] <= 279) { $tmagie = 60 ; } if ($line['E_magique'] >= 280 AND $line['E_magique'] <= 319) { $tmagie = 70 ; } if ($line['E_magique'] >= 320 AND $line['E_magique'] <= 359) { $tmagie = 80 ; }
						if ($line['E_magique'] >= 360 AND $line['E_magique'] <= 399) { $tmagie = 90 ; }if ($line['E_magique'] == 400) { $tmagie = 100 ;	} if ($line['E_magique'] > 400)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 6) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 49) { $tmagie = 0 ; } if ($line['E_magique'] >= 50 AND $line['E_magique'] <= 99) { $tmagie = 10 ; } if ($line['E_magique'] >= 100 AND $line['E_magique'] <= 149) { $tmagie = 20 ; }
						if ($line['E_magique'] >= 150 AND $line['E_magique'] <= 199) { $tmagie = 30 ; } if ($line['E_magique'] >= 200 AND $line['E_magique'] <= 249) { $tmagie = 40 ; } if ($line['E_magique'] >= 250 AND $line['E_magique'] <= 299) { $tmagie = 50 ; }
						if ($line['E_magique'] >= 300 AND $line['E_magique'] <= 349) { $tmagie = 60 ; } if ($line['E_magique'] >= 350 AND $line['E_magique'] <= 399) { $tmagie = 70 ; } if ($line['E_magique'] >= 400 AND $line['E_magique'] <= 449) { $tmagie = 80 ; }
						if ($line['E_magique'] >= 450 AND $line['E_magique'] <= 499) { $tmagie = 90 ; } if ($line['E_magique'] == 500) { $tmagie = 100 ; } if ($line['E_magique'] > 500) { $tmagie = "over" ; }	}
					if ($line['magie_rank'] >= 7) { $tmagie = 'inf';}
					if ($line['E_vitale'] >= 0  AND $line['E_vitale'] <= 19) 	{	$tvie = 0 ;	}
					if ($line['E_vitale'] >= 20 AND $line['E_vitale'] <= 39) 	{	$tvie = 10 ;	}
					if ($line['E_vitale'] >= 40 AND $line['E_vitale'] <= 59) 	{	$tvie = 20 ;	}
					if ($line['E_vitale'] >= 60 AND $line['E_vitale'] <= 79) 	{	$tvie = 30 ;	}
					if ($line['E_vitale'] >= 80 AND $line['E_vitale'] <= 99) 	{	$tvie = 40 ;	}
					if ($line['E_vitale'] >= 100 AND $line['E_vitale'] <= 119) 	{	$tvie = 50 ;	}
					if ($line['E_vitale'] >= 120 AND $line['E_vitale'] <= 139)	{	$tvie = 60 ;	}
					if ($line['E_vitale'] >= 140 AND $line['E_vitale'] <= 159) 	{	$tvie = 70 ;	}
					if ($line['E_vitale'] >= 160 AND $line['E_vitale'] <= 179) 	{	$tvie = 80 ;	}
					if ($line['E_vitale'] >= 180 AND $line['E_vitale'] <= 199) 	{	$tvie = 90 ;	}
					if ($line['E_vitale'] == 200) 	{	$tvie = 100 ;	}
					$pmcount = ($line['magie_rank'] > 6) ? 'PMs Illimité !' : ''.$line['E_magique'].' PMs restants !' ;
					$id = $line['id'];
					$select = $db->prepare('SELECT COUNT(*) AS plus FROM hrpavis WHERE target_id = ? AND avis = 1 AND sender_rank <= 4');
					$select->execute(array($id)); $line0 = $select->fetch();
					$select1 = $db->prepare('SELECT COUNT(*) AS plusstaff FROM hrpavis WHERE target_id = ? AND avis = 1 AND sender_rank > 4');
					$select1->execute(array($id)); $line1 = $select1->fetch();
					$select2 = $db->prepare('SELECT COUNT(*) AS moins FROM hrpavis WHERE target_id = ? AND avis = 0 AND sender_rank <= 4');
					$select2->execute(array($id)); $line2 = $select2->fetch();
					$select3 = $db->prepare('SELECT COUNT(*) AS moinsstaff FROM hrpavis WHERE target_id = ? AND avis = 0 AND sender_rank > 4');
					$select3->execute(array($id)); $line3 = $select3->fetch();
					$countj = $line0['plus'] - $line2['moins'];
					$plus = $line1['plusstaff'] * 2; $moins = $line3['moinsstaff'] * 2;
					$counts = $plus - $moins; $hrpavis = $countj + $counts;
					if ($hrpavis >= 10) { $coloravis = 10;} elseif ($hrpavis >= 20) { $coloravis = 20;} elseif ($hrpavis >= 30) { $coloravis = 30;} elseif ($hrpavis < 0) { $coloravis = "negative"; } else { $coloravis = 0; }
					
				switch ($line['magie_rank'])
				{
					case 0: $level = "Profane"; break; case 1:$level = "Adepte"; break; case 2: $level = "Apprenti Magicien"; break;
					case 3: $level = "Magicien"; break; case 4: $level = "Mage"; break; case 5: $level = "Archimage"; break;
					case 6: $level = "Sage"; break; case 7: $level = "Divin"; break; case 8: $level = "Titanèsque"; break;
					case 9: $level = "Suprême"; break;
				}
			$bgmsg = ($line['valid_bg'] == 1) ? 'BackGround RolePlay validé par le Staff' : 'BackGround en cours d\'écriture...';
			$validbg = ($line['valid_bg'] == 1) ? 'on' : 'off';
			$vanish = ($line['invisible'] == 1) ? 'on' : 'off'; $vanishtitle = ($line['invisible'] == 1) ? 'Invisible' : 'Visible';
			$title = $line['title'];
			if ($line['pionier'] == 1) { $title = "Pionier"; }
			if ($line['ban'] == 1) { $title = "Banni"; }
			if ($line['removed'] == 1 ) {$title = "Oublié" ;}
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
			$active = $db->prepare('SELECT * FROM members WHERE id = ? AND ADDDATE(last_action, INTERVAL 3 WEEK)> NOW()');
			$active->execute(array($line['id']));
			if ($active->fetch()) { $act = 'on.PNG'; $act_title = "Activité Récente"; }else { $act = "off.png"; $act_title = "Aucune activité depuis 3 semaines" ;}
			?>
			<tr class="memberbg_<?php echo $linerank;?>" valign="middle">
				<td>
					<img src="pics/rank<?php echo $imgrank; ?>.png" alt="" width="30" /> <img src="pics/avatar/miniskin_<?php echo $img;?>.png" alt="" width="30" /> <a title="Nom Minecraft : <?= $line['Minecraft_Account']?>" href="index?p=perso&perso=<?= $line['id']?>"><?= $line['name']?></a>
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
				<td style="text-align:center;">
					<span class="avis<?= $coloravis?>">[<?= $hrpavis?>]</span>
				</td>
				<td style="text-align:center;">
					<img src="pics/ico/activity_<?= $act?>" alt="" title="<?php echo $act_title;?>" width="30px" />
				</td>
			<?php if ($_SESSION['rank'] >= 5) { ?>
				<td style="text-align:center;">
					<img src="pics/vanish<?php echo $vanish; ?>.gif" width="30" alt="" title="Joueur <?php $vanishtitle; ?>" />
				</td>
			<?php } ?>
				<td style="text-align:center;">
					<img src="pics/magie/EM_<? echo $tmagie ?>.png" title="<?php echo $pmcount; ?>" alt="" /><br />
					<img src="pics/magie/EV_<? echo $tvie ?>.png" title="<?= $line['E_vitale']?> PV restants !" alt="" />
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
