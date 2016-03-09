<?php function sondage ()
{
	global $db, $_SESSION, $_POST, $_GET;
	?>


	<h2>Sondages d'RPNix.com</h2>

<?php if (isset($_GET['s']))
	{
		$sondage = intval($_GET['s']);
		$answer = $db->prepare('SELECT s.id AS s_id, s.sender_id AS sender, s.text, s.rank AS level, s.title AS titre, m.id, m.name, m.rank AS rank, m.technician, m.pionier
		FROM sondage s
		RIGHT JOIN members m ON m.id = s.sender_id
		WHERE id = ? ');
		$answer->execute(array($sondage));
		
		if ($line = $answer->fetch())
		{
	?>
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
									<td>Initié par :</td>
									<td class="name<?= $line['rank']?>"> <?= $line['title']?></td>
									<tdclass="name<?= $line['rank']?>"> <?= $line['name']?></td>
								</tr>
								<tr>
									<td colspan="3">
										<?= $line['text'] ?>
									</td>
								</tr>
								<tr>
									<td>Vote Pour</td>
									<td>Vote Blanc</td>
									<td>Vote Contre</td>
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
