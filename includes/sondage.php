<?php function sondage ()
{
	global $db, $_SESSION, $_POST, $_GET;
	?>


	<h2>Sondages d'RPNix.com</h2>

<?php if (isset($_GET['s']))
	{
		$sondage = intval($_GET['s']);
		$answer = $db->prepare('SELECT s.id AS s_id, s.sender_id AS sender, s.text, s.rank AS level, s.title AS titre, m.id AS id, m.name, m.title AS title, m.rank AS rank, m.technician, m.pionier
		FROM sondage s
		RIGHT JOIN members m ON m.id = s.sender_id
		WHERE s.id = ? ');
		$answer->execute(array($sondage));
		
		if ($line = $answer->fetch())
		{
	?>
	<h2><?= $line['titre']?></h2>
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
						<table background="/pics/ico/magiepapercenter.png">
							<tbody>
								<tr>
									<td colspan="3">Initié par : 
									<span class="name<?= $line['rank']?>"> <?= $line['title']?> <?= $line['name']?></span>
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<?= $line['text'] ?>
									</td>
								</tr>
								<tr>
									<td>
										<a>
											<img src="pics/ico/vote_on.png" title="Voter oui" alt="" />
										</a>
									</td>
									<td>
										<a>
											<img src="pics/ico/vote_no.png" title="Voter blanc" alt="" />
										</a>
									</td>
									<td>
										<a>
											<img src="pics/ico/vote_off.png" title="Voter non" alt="" />
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
	<?php	}
	else {
	echo '<p>Une erreur s\'est produite</p>' ;
	}
	}
	else
	{
?>
	
	<ul id="categories">
		<li class="forum_category">
		<p>Votes Publics</p>
		
		<table class="forum" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr class="head_table">
					<th>Intitulé</th>
					<th class="last_post">Créé par</th>
				</tr>
				<tr>
					<td class="read">
					<a href="#"> Sondage A</a>
					</td>
					<td>
					<img width="20px" src="pics/avatar/miniskin_no.png">
					<a class="name7-T" href="#"> Opérateur Etzu</a>
					<br>
					Le 26/02/2016 à 22:29
					</td>
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
