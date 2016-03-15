<?php function sondage ()
{
	global $db, $_SESSION, $_POST, $_GET;
	?>


	<h2>Sondages d'RPNix.com</h2>

<?php if (isset($_GET['s']))
	{
		$sondage = intval($_GET['s']);
	$verif = $db->prepare('SELECT s.id, s.sondage_id AS sondage, s.sender_id, s.vote, m.id AS m_id
				FROM sondage_votes s
				RIGHT JOIN members m ON m.id = s.sender_id
				WHERE s.sondage_id = ? AND s.sender_id = ?');
	$verif->execute(array($sondage, $_SESSION['id']));
	if (isset($_GET['v']) && $_GET['v'] == 'pour')
	{
		if ($verif->fetch())
		{
			$vote = $db->prepare("UPDATE sondage_votes SET vote= 2 WHERE sender_id = ? AND sondage_id = ?");
			$vote->execute(array($_SESSION['id'], $sondage));
			{ ?>
				<p>Vote modifié !</p>
				<p><a href="index?p=sondage">Cliquez ici</a> Pour retourner à la liste des sondages.</p>
			<?php }
		}
		else
		{
			$vote = $db->prepare("INSERT INTO sondage_votes VALUES('', ?, 2, ?)");
			$vote->execute(array($sondage, $_SESSION['id']));
			 { ?>
				<p>A voté !</p>
				<p><a href="index?p=sondage">Cliquez ici</a> Pour retourner à la liste des sondages.</p>
			<?php }
		}
	}
	elseif (isset($_GET['v']) && $_GET['v'] == 'blanc')
	{
		if ($verif->fetch())
		{
			$vote = $db->prepare("UPDATE sondage_votes SET vote= 1 WHERE sender_id = ? AND sondage_id = ?");
			$vote->execute(array($_SESSION['id'], $sondage));
			 { ?>
				<p>Vote modifié !</p>
				<p><a href="index?p=sondage">Cliquez ici</a> Pour retourner à la liste des sondages.</p>
			<?php }
		}
		else
		{
			$vote = $db->prepare("INSERT INTO sondage_votes VALUES('', ?, 1, ?)");
			$vote->execute(array($sondage, $_SESSION['id']));
			 { ?>
			<p>A voté !</p>
			<p><a href="index?p=sondage">Cliquez ici</a> Pour retourner à la liste des sondages.</p>
			<?php }	
		}
	}
	elseif (isset($_GET['v']) && $_GET['v'] == 'contre')
	{
		if ($verif->fetch())
		{
			$vote = $db->prepare("UPDATE sondage_votes SET vote= 0 WHERE sender_id = ? AND sondage_id = ?");
			$vote->execute(array($_SESSION['id'], $sondage));
			{ ?>
				<p>Vote modifié !</p>
				<p><a href="index?p=sondage">Cliquez ici</a> Pour retourner à la liste des sondages.</p>
			<?php }
		}
		else
		{
			$vote = $db->prepare("INSERT INTO sondage_votes VALUES('', ?, 0, ?)");
			$vote->execute(array($sondage, $_SESSION['id']));
			{ ?>
				<p>A voté !</p>
				<p><a href="index?p=sondage">Cliquez ici</a> Pour retourner à la liste des sondages.</p>
			<?php }	
		}
	}
	else
	{
		$answer = $db->prepare('SELECT s.id AS s_id, s.sender_id AS sender, s.text, s.rank AS level, s.title AS titre, m.id AS id, m.name, m.title AS title, m.rank AS rank, m.technician, m.pionier
		FROM sondage s
		RIGHT JOIN members m ON m.id = s.sender_id
		WHERE s.id = ? ');
		$answer->execute(array($sondage));
		
		if ($line = $answer->fetch())
		{
			if ($_SESSION['rank'] >= $line['level'])
			{
	?>
	<h3><?= $line['titre']?></h3>
	<center>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td>
						<img src="/pics/ico/magiepapertop.png" alt=" " />
					</td>
				</tr>
				<tr>
					<td>
						<table background="/pics/ico/magiepapercenter.png" width="640px">
							<tbody>
								<tr>
									<td colspan="3" style="text-align:center;">Initié par : 
									<span class="name<?= $line['rank']?>"> <?= $line['title']?> <?= $line['name']?></span>
									</td>
								</tr>
								<tr>
									<td colspan="3" style="text-align:center;">
										<?= $line['text'] ?>
									</td>
								</tr>
								<tr>
									<td style="text-align:center;">
										<a href="index.php?p=sondage&s=<?php echo $sondage; ?>&v=pour">
											<img src="pics/ico/vote_on.png" title="Voter oui" alt="" width="50px" />
										</a>
									</td>
									<td style="text-align:center;">
										<a href="index.php?p=sondage&s=<?php echo $sondage; ?>&v=blanc">
											<img src="pics/ico/vote_no.png" title="Voter blanc" alt="" width="50px" />
										</a>
									</td>
									<td style="text-align:center;">
										<a href="index.php?p=sondage&s=<?php echo $sondage; ?>&v=contre">
											<img src="pics/ico/vote_off.png" title="Voter non" alt="" width="50px" />
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<img src="/pics/ico/magiepapebottom.png" alt="" />
					</td>
				</tr>
			</tbody>
		</table>
	</center>
	<?php if ($_SESSION['rank'] >= 6) { 
		$votes = $db->prepare('SELECT s.id, s.sender_id, s.sondage_id, s.vote, m.id AS m_id, m.name, m.title
		FROM sondage_votes s
		RIGHT JOIN members m ON m.id = s.sender_id
		WHERE s.sondage_id = ?');
		$votes->execute(array($sondage));
		$votes_pour = $db->prepare('SELECT COUNT(*) AS pour FROM sondage_votes WHERE sondage_id = ? AND vote = 2'); $votes_pour->execute(array($sondage));
		$line0 = $votes_pour->fetch();
		$votes_blanc = $db->prepare('SELECT COUNT(*) AS blanc FROM sondage_votes WHERE sondage_id = ? AND vote = 1'); $votes_blanc->execute(array($sondage));
		$line1 = $votes_blanc->fetch();
		$votes_contre = $db->prepare('SELECT COUNT(*) AS contre FROM sondage_votes WHERE sondage_id = ? AND vote = 0'); $votes_contre->execute(array($sondage));
		$line2 = $votes_contre->fetch();
	?>
	
	<h2>Votants :</h2>
	<center>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td>
						<img src="/pics/ico/magiepapertop.png" alt=" " />
					</td>
				</tr>
				<tr>
					<td>
						<table background="/pics/ico/magiepapercenter.png" width="640px">
							<tbody>
								<tr>
									<td>
										<img src="pics/ico/vote_on.png" title="Voter oui" alt="" width="50px" /> x<?= $line0['pour'] ?>
									</td>
									<td>
										<img src="pics/ico/vote_o.opng" title="Voter oui" alt="" width="50px" /> x<?= $line1['blanc'] ?>
									</td>
									<td>
										<img src="pics/ico/vote_off.png" title="Voter oui" alt="" width="50px" /> x<?= $line2['contre'] ?>
									</td>
								</tr>
								<tr>
									<td colspan="3>
										<p style="padding: 2%;">
											<?php if ($line = $votes->fetch()) {
												switch ($line['vote']) {
													case 0: $color = "red"; $title = "A voté Contre"; break;
													case 1: $color = "white"; $title = "A voté Blanc"; break;
													case 2: $color = "green"; $title = "A voté Pour"; break; }
											?>
												<span class="name1" style="color:<?php echo $color; ?>" title="<?php echo $title; ?>">
													<?= $line['title']?> <?= $line['name'] ?>
												</span>
											<?php }
										else { echo "Aucun vote n'a encore été enregistré."; } ?>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<img src="/pics/ico/magiepapebottom.png" alt="" />
					</td>
				</tr>
			</tbody>
		</table>
	</center>
		
	<?php }
	}
		else 	echo '<p>Vous n\'avez pas le grade suffisant pour voir le contenu de ce sondage.</p>' ;
		}
	else {
	echo '<p>Une erreur s\'est produite</p>' ;
	}
	} }
	else
	{
		$vide = '<p>Aucun sondage n\'est disponible pour ce grade.</p>';
?>
	
	<ul id="categories">
		<li class="forum_category">
		<p class="name2">Votes Publics</p>
		
		<?php
		$answer = $db->query('SELECT s.id AS s_id, s.sender_id AS sender, s.text, s.rank AS level, s.title AS titre, m.id AS id, m.name, m.title AS title, m.rank AS rank, m.technician, m.pionier
		FROM sondage s
		RIGHT JOIN members m ON m.id = s.sender_id
		WHERE s.rank <= 4 ');
		?>
		<table class="forum" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr class="head_table">
					<th>Intitulé</th>
					<th class="last_post">Créé par</th>
				</tr>
				<tr>
				<?php if ($line = $answer->fetch())
				{	?>
					<td class="read">
					<a href="index?p=sondage&s=<?= $line['s_id'] ?>"> <?= $line['titre']?> </a>
					</td>
					<td>
					<img width="20px" src="pics/avatar/miniskin_<?= $line['m.id']?>.png" alt="" />
					<a class="name<?= $line['rank']?>" href="index?p=perso&perso=<?= $line['m.id']?>"> <?= $line['title']?> <?= $line['name']?></a>
					<br>
					Le 26/02/2016 à 22:29
					</td>
				<?php } 
				else { echo $vide ;
				}?>
				</tr>
			</tbody>
		</table>
		</li>
		<li class="forum_category">
		<p class="name5">Votes Modérateurs</p>
		
		<?php
		$answer1 = $db->query('SELECT s.id AS s_id, s.sender_id AS sender, s.text, s.rank AS level, s.title AS titre, m.id AS id, m.name, m.title AS title, m.rank AS rank, m.technician, m.pionier
		FROM sondage s
		RIGHT JOIN members m ON m.id = s.sender_id
		WHERE s.rank = 5 ');
		?>
		<table class="forum" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr class="head_table">
					<th>Intitulé</th>
					<th class="last_post">Créé par</th>
				</tr>
				<tr>
				<?php if ($line1 = $answer1->fetch())
				{	?>
					<td class="read">
					<a href="index?p=sondage&s=<?= $line1['s_id'] ?>"> <?= $line1['titre']?></a>
					</td>
					<td>
					img width="20px" src="pics/avatar/miniskin_<?= $line1['m.id']?>.png" alt="" />
					<a class="name<?= $line1['rank']?>" href="index?p=perso&perso=<?= $line1['m.id']?>"> <?= $line1['title']?> <?= $line1['name']?></a>
					<br>
					Le 26/02/2016 à 22:29
					</td>
				<?php }
				else { echo $vide ;
				}?>
				</tr>
			</tbody>
		</table>
		</li>
		<li class="forum_category">
		<p class="name6">Votes Maitres du Jeu</p>
		
		<?php
		$answer2 = $db->query('SELECT s.id AS s_id, s.sender_id AS sender, s.text, s.rank AS level, s.title AS titre, m.id AS id, m.name, m.title AS title, m.rank AS rank, m.technician, m.pionier
		FROM sondage s
		RIGHT JOIN members m ON m.id = s.sender_id
		WHERE s.rank = 6 ');
		?>
		<table class="forum" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr class="head_table">
					<th>Intitulé</th>
					<th class="last_post">Créé par</th>
				</tr>
				<tr>
				<?php if ($line2 = $answer2->fetch())
				{	?>
					<td class="read">
					<a href="index?p=sondage&s=<?= $line2['s_id'] ?>"> <?= $line2['titre']?></a>
					</td>
					<td>
					<img width="20px" src="pics/avatar/miniskin_<?= $line2['m.id']?>.png" alt="" />
					<a class="name<?= $line2['rank']?>" href="index?p=perso&perso=<?= $line2['m.id']?>"> <?= $line2['title']?> <?= $line2['name']?></a>
					<br>
					Le 26/02/2016 à 22:29
					</td>
				<?php } 
				else { echo $vide ;
				}?>
				</tr>
			</tbody>
		</table>
		</li>
		<li class="forum_category">
		<p class="name7">Votes Opérateurs</p>
		
		<?php
		$answer3 = $db->query('SELECT s.id AS s_id, s.sender_id AS sender, s.text, s.rank AS level, s.title AS titre, m.id AS id, m.name, m.title AS title, m.rank AS rank, m.technician, m.pionier
		FROM sondage s
		RIGHT JOIN members m ON m.id = s.sender_id
		WHERE s.rank = 7 ');
		?>
		<table class="forum" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr class="head_table">
					<th>Intitulé</th>
					<th class="last_post">Créé par</th>
				</tr>
				<tr>
				<?php if ($line3 = $answer3->fetch())
				{	?>
					<td class="read">
					<a href="index?p=sondage&s=<?= $line3['s_id'] ?>"> <?= $line3['titre']?></a>
					</td>
					<td>
					<img width="20px" src="pics/avatar/miniskin_<?= $line3['m.id']?>.png" alt="" />
					<a class="name<?= $line3['rank']?>" href="index?p=perso&perso=<?= $line3['m.id']?>"> <?= $line3['title']?> <?= $line3['name']?></a>					<br>
					Le 26/02/2016 à 22:29
					</td>
				<?php }
				else { echo $vide ;
				}
				?>
				</tr>
			</tbody>
		</table>
		</li>
	</ul>
<?php
	}
?>
	
<?php


} ?>
