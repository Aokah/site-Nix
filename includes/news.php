<?php function news($action)
{
	global $db, $_POST;

	define('rank_add_news', 6);
	define('rank_manage_news', 6);


	if ($action == 'disp')
	{
		$answer = $db->query('SELECT message FROM news ORDER BY date_post DESC LIMIT 1');
		$line = $answer->fetch();

		?>
		<p><?= $line['message']?></p>
		<?php
	}
	else if ($action == 'page')
	{
		if (isset($_POST['news']) && $_SESSION['rank'] >= rank_add_news)
		{
			$insert = $db->prepare('INSERT INTO news (date_post, author, message) VALUES (NOW(), ?, ?)');
			$insert->execute(array($_SESSION['id'], htmlspecialchars($_POST['news'])));
			shirka_say($_POST['news']);
		}
		else if (isset($_POST['shirka']) && $_SESSION['rank'] >= rank_add_news)
		{
			shirka_say($_POST['shirka']);
		}
		?>
		<h3>Actualité de Nix</h3>

		<section class="forum_category">
			<ul>
		<?php

		$answer = $db->query('SELECT n.message msg, n.date_post date, m.name name, m.id m_id, m.rank rank,m.pionier pionier,m.technician technician
					FROM news n
					INNER JOIN members m ON m.id = n.author
					ORDER BY n.date_post DESC
					LIMIT 3');
		while ($line = $answer->fetch())
		{
			$date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}):(.{2}):.{2}$#', 'Le $3/$2 à $4h$5', $line['date']);
			?>
				<li><?=$date?> par <a href="index.php?p=perso&amp;perso=<?=$line['m_id']?>" class="name<?= $line["rank"]?><? echo $tech?><? echo $pionnier?>"><?=$line['name']?></a> : <?=$line['msg']?></li>
			<?php
		}

		?>
			</ul>
		</section>
		
		<?php if ($_SESSION['rank'] >= rank_add_news) {?>
		<section>
			<p style="color:red;">Mise à jour des annonces : Shirka énonce désormais ce qui est écrit dans le champs permettant d'ajouter des annonce en en-tête du site !</p>
			<h4>Nouvelle :</h4> 

			<form method="POST" action="index.php?p=news">
				<input type="text" name="news" maxlength="255" />
				<input type="submit" value="Envoyer" />
			</form>

			<h4>Shirka :</h4>

			<form method="POST" action="index.php?p=news">
				<input type="text" name="shirka" maxlength="255" />
				<input type="submit" value="Envoyer" />
			</form>
		</section>
		
		<?php
		}
	?>
	<section><?php
		$regitered = $db->query('SELECT * FROM members WHERE pnj = 0 AND removed = 0 AND ban = 0 AND rank < 8 AND ADDDATE(registration_date, INTERVAL"01-01" YEAR_MONTH) > NOW() AND ADDDATE(registration_date, INTERVAL "1" YEAR) < NOW()');
		?>
		<h3>Déjà un an parmi nous !</h3>
		<p>Déjà un an qu'ils se sont inscrits chez nous !</p>
		<p>
		<?php
		while ($line = $regitered->fetch())
		{
			if ($line['rank'] == 10) { $rank = "crea"; } elseif ($line['rank'] == 9) { $rank = "titan"; } else { $rank = $line['rank']; }
		?>
		 <img src="pics/rank<?= $rank?>.png" alt="" width="27" class="magie" /> <a href="index?p=perso&perso=<?= $line['id']?>" valign="center" class="name<?= $line['rank']?>"><?= $line['name']?></a> 
		<?php
		}
		?>
		</p>
		</section>
		<section>
			<h3>De nouveaux venus !</h3>
			<p>Nouveaux inscrits sur Nix, souhaitez leur la bienvenue, ça fait toujours plaisir !</p>
			<p>
			<?php
			$new = $db->query('SELECT * FROM members WHERE pnj = 0 AND removed = 0 AND ban = 0 AND ADDDATE(registration_date, INTERVAL 1 WEEK)> NOW()');
			?>
			<?php
			while ($line = $new->fetch())
			{
				if ($line['rank'] == 10) { $rank = "crea"; } elseif ($line['rank'] == 9) { $rank = "titan"; } else { $rank = $line['rank']; }
			?>
			 <img src="pics/rank<?= $rank?>.png" alt="" width="27" class="magie" /> <a href="index?p=perso&perso=<?= $line['id']?>" valign="center" class="name<?= $line['rank']?>"><?= $line['name']?></a> 
			<?php
			}
		?></p>
		</section>
	<?php
	}
			
			
}
?>
