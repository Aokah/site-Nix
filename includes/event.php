<?php function event ()
{
global $db, $_SESSION, $_POST, $_GET;
   if ($_SESSION['connected'])
   {
     if ($_SESSION['rank'] > 4)
     {
      ?>
      <h2>Evènements Nix</h2>
      <p>Ici sont écrits en plus amples détails tout ce qui a à savoir sur tel ou tel évènement lié au serveur !</p>
      <?php
      if (isset($_GET['e']))
      {
      	$event = intval($_GET['e']);
      	$select = $db->prepare('SELECT * FROM events WHERE id = ?'); $select->execute(array($event));
      	
      	?>
      	<p><a href="index?p=event&modif=<?= $event?>" class="button">Modifier l'évènement.</a> <a href="index?p=event&addto=<?= $event?>" class="button">Ajouter un rapport à l'évènement.</a></p>
      	<table width="100%" cellspacing="0" cellpadding="5" style="border: 5px gray solid; border-radius: 10px; background-color: #DDDDDD;text-shadow: white 1px 1px 4px;">
        	<tbody>
        		<tr style="background-color:#BBBBBB;">
        			<th>Intitulé</th>
        			<th>Nature</th>
        			<th>Lancement</th>
        			<th>Lanceur</th>
        		</tr>
        		<?php
        		if ($line = $select->fetch())
		        {
      				$text = preg_replace('#\n#', '<br />', $line['content']);
      				$character = preg_replace('#\n#', '<br />', $line['characters']);
		        	switch ($line['type'])
		        	{
		        		default : $type = "Non encore défini"; break;
		        		case 1 : $type = "Event Onirique"; break;
		        		case 2 : $type = "Event Panthéon"; break;
		        		case 3 : $type = "Event Catastrophe"; break;
		        		case 4 : $type = "Event Magie" ; break;
		        		case 5 : $type = "Event Social"; break;
		        		case 6 : $type = "Event Donjon"; break;
		        		case 7 : $type = "Event Expédition"; break;
		        	}
		        	$select_ = $db->prepare('SELECT * FROM members WHERE id = ?'); $select_->execute(array($line['user_id']));
		        	$line_ = $select_->fetch();
		        	if ($line_['pionier'] == 1) { $title ="Pionier"; } elseif ($line_['ban'] == 1) { $title = "Banni"; } 
		        	elseif ($line_['remove'] == 1) { $title = "Oublié"; } else { $title = $line_['title']; }
		        	if ($line_['pionier'] == 1) { $pionier = "-P"; } if ($line_['technician'] == 1) { $tech = "-T"; }
		        ?>
		        <tr style="text-align:center;">
		        	<td><?=$line['name']?></td>
		        	<td><?=$type?></td>
		        	<td><?=$line['begin']?></td>
		        	<td class="name<?= $line_['rank'], $pionier, $tech?>"><?=$title, ' ', $line_['name']?></td>
		        </tr>
		        <tr style="background-color:#BBBBBB;">
        			<th colspan="2">Script</th>
        			<th colspan="2">PNJs connus utilisés</th>
        		</tr>
		        <tr>
		        	<td colspan="2">
		        		<p style="text-align:center;"><?= $text?></p>
		        	</td>
		        	<td colspan="2">
		        		<p style="text-align:center;"><?= $character?></p>
		        	</td>
		        </tr>
		        <?php
    			 }
    			 ?>
        	</tbody>
        </table>
        <p style="text-align:center;">Comptes-rendus de l'event</p>
        <?php
        $select2 = $db->prepare('SELECT * FROM event_report WHERE event_id = ? ORDER BY date_post DESC');
        $select2->execute(array($event));
        while ($line2 = $select2->fetch())
        {
	        $select_ = $db->prepare('SELECT * FROM members WHERE id = ?'); $select_->execute(array($line2['user_id']));
		$line_ = $select_->fetch();
		if ($line_['pionier'] == 1) { $title ="Pionier"; } elseif ($line_['ban'] == 1) { $title = "Banni"; } 
		elseif ($line_['remove'] == 1) { $title = "Oublié"; } else { $title = $line_['title']; }
		if ($line_['pionier'] == 1) { $pionier = "-P"; } if ($line_['technician'] == 1) { $tech = "-T"; }
		$rapport = preg_replace('#\n#', '<br />', $line2['rapport']);
		$date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line2['date_post']);
	        ?>
	        <table width="100%" cellspacing="0" cellpadding="5" style="border: 5px gray solid; border-radius: 10px; background-color: #DDDDDD;text-shadow: white 1px 1px 4px;">
	        	<tbody>
	        		<tr style="background-color:#BBBBBB;">
	        			<th>Animateur</th>
	        			<th>Date d'animation</th>
	        		</tr>
	        		<tr>
	        			<td style="text-align:center;" class="name<?= $line_['rank'], $pionier, $tech?>"><?=$title, ' ', $line_['name']?></td>
	        		</tr>
	        		<tr>
	        			<td style="text-align:center;"><?=$date?></td>
	        		</tr>
	        		<tr style="background-color:#BBBBBB;">
	        			<th colspan="2">Compte-rendu de l'évènmeent.</th>
	        		</tr>
	        		<tr>
	        			<td>
	        				<p style="text-align:center;"><?=$rapport?></p>
	        			</td>
	        		</tr>
	        	</tbody>
	        </table>
	      	<?php
        }
      }
      elseif (isset($_GET['modif']))
      	{
		$event = intval($_GET['modif']);
      		if (isset($_POST['valid']))
      		{
      			$content = htmlspecialchars($_POST['content']);
      			$begin = htmlspecialchars($_POST['begin']);
      			$char = htmlspecialchars($_POST['character']);
      			
      			$update = $db->prepare('UPDATE events SET content = ?, begin = ?, type = ?, characters = ? WHERE id = ?');
      			$update->execute(array($content, $begin, $_POST['type'], $char, $event));
      			echo '<p>Les changement ont bien été effectués.</p>',
      			 '<p><a href="index?p=event&e=', $event,'">Cliquez ici</a> pour retourner à l\'évènement modifié.</p>',
      			 '<p><a href=index?p=event>Cliquez ici</a> pour retourner à la page des évènemnts.</p>';
      		}
      		else
      		{
      		
		      	$select = $db->prepare('SELECT * FROM events WHERE id = ?'); $select->execute(array($event));
	      		if ($line = $select->fetch())
	      		{
			?>
			      	<form action="index?p=event&modif=<?=$event?>" method="POST">
			      		<input type="submit" name="valid" value="Terminer" />
			      		<table width="100%" cellspacing="0" cellpadding="5" style="border: 5px gray solid; border-radius: 10px; background-color: #DDDDDD;text-shadow: white 1px 1px 4px;">
			        	<tbody>
			        		<tr style="background-color:#BBBBBB;">
			        			<th>Intitulé</th>
			        			<th>Nature</th>
			        			<th>Lancement</th>
			        			<th>Lanceur</th>
			        		</tr>
			        		<?php
					        	$select_ = $db->prepare('SELECT * FROM members WHERE id = ?'); $select_->execute(array($line['user_id']));
					        	$line_ = $select_->fetch();
					        	if ($line_['pionier'] == 1) { $title ="Pionier"; } elseif ($line_['ban'] == 1) { $title = "Banni"; } 
					        	elseif ($line_['remove'] == 1) { $title = "Oublié"; } else { $title = $line_['title']; }
					        	if ($line_['pionier'] == 1) { $pionier = "-P"; } if ($line_['technician'] == 1) { $tech = "-T"; }
					        ?>
					        <tr style="text-align:center;">
					        	<td><a href="index?p=event&e=<?=$line['id']?>"><?=$line['name']?></a></td>
					        	<td><select name="type">
					        		<option value="<?= $line['type']?>">-- Option par défaut --</option>
					        		<option value="1">Event Onirique</option>
					        		<option value="2">Event Panthéon</option>
					        		<option value="3">Event Catastrophe</option>
					        		<option value="4">Event Magie</option>
					        		<option value="5">Event Social</option>
					        		<option value="6">Event Donjon</option>
					        		<option value="7">Event Expédition</option>
					        	</select></td>
					        	<td><input type="text" name="begin" value="<?=$line['begin']?>" /></td>
					        	<td class="name<?= $line_['rank'], $pionier, $tech?>"><?=$title, ' ', $line_['name']?></td>
					        </tr>
					        <tr style="background-color:#BBBBBB;">
			        			<th colspan="2">Script</th>
			        			<th colspan="2">PNJs connus utilisés</th>
			        		</tr>
					        <tr>
					        	<td colspan="2">
					        		<textarea align="center" name="content"><?=$line['content']?></textarea>
					        	</td>
					        	<td colspan="2">
					        		<textarea align="center" name="character"><?=$line['characters']?></textarea>
					        	</td>
					        </tr>
				        	</tbody>
				        </table>
			      	</form>
			<?php
			}
      		}
      	}
      	elseif (isset($_GET['addto']))
      	{	
	      	$event = intval($_GET['addto']);
	      	$select = $db->prepare('SELECT * FROM events WHERE id = ?'); $select->execute(array($event));
	      	if (isset($_POST['add']))
	      	{
	      		$rapport = htmlspecialchars($_POST['rapport']);
	      		
	      		$add = $db->prepare("INSERT INTO event_report VALUES('', ?,  NOW(), ?, ?)");
	      		$add->execute(array($event, $rapport, $_SESSION['id']));
	      		echo '<p>Le compte-rendu a bien été ajouté à l\'évent corrspondant !</p>',
      			'<p><a href="index?p=event&e=', $event,'">Cliquez ici</a> pour retourner à l\'évènement modifié.</p>',
      			'<p><a href=index?p=event>Cliquez ici</a> pour retourner à la page des évènemnts.</p>';
	      	}
	      	else
	      	{
	      	?>
	      		<h3>Rapport d'évènement</h3>
	      		<p>Notez ici le contenu de l'animation que vous avez assuré en rapport avec l'évènement.</p>
	      		<form action="index?p=event&addto=<?= $event?>" method="POST">
	      		<div width="100%" align="center"><textarea name="rapport"></textarea></div>
	      		<input type="submit" value="Envoyer" name="add" />
	      		</form>
	      	<?php
	      	}
      	}
      else
      {
        $select = $db->query('SELECT * FROM events ORDER BY name ASC');
        ?>
        <table width="100%" cellspacing="0" cellpadding="5" style="border: 5px gray solid; border-radius: 10px; background-color: #DDDDDD;text-shadow: white 1px 1px 4px;">
        	<tbody>
        		<tr style="background-color:#BBBBBB;">
        			<th>Intitulé</th>
        			<th>Nature</th>
        			<th>Lancement</th>
        			<th>Lanceur</th>
        		</tr>
        		<?php
        		while ($line = $select->fetch())
		        {
		        	switch ($line['type'])
		        	{
		        		default : $type = "Non encore défini"; break;
		        		case 1 : $type = "Event Onirique"; break;
		        		case 2 : $type = "Event Panthéon"; break;
		        		case 3 : $type = "Event Catastrophe"; break;
		        		case 4 : $type = "Event Magie" ; break;
		        		case 5 : $type = "Event Social"; break;
		        		case 6 : $type = "Event Donjon"; break;
		        		case 7 : $type = "Event Expédition"; break;
		        	}
		        	$select_ = $db->prepare('SELECT * FROM members WHERE id = ?'); $select_->execute(array($line['user_id']));
		        	$line_ = $select_->fetch();
		        	if ($line_['pionier'] == 1) { $title ="Pionier"; } elseif ($line_['ban'] == 1) { $title = "Banni"; } 
		        	elseif ($line_['remove'] == 1) { $title = "Oublié"; } else { $title = $line_['title']; }
		        	if ($line_['ppionier'] == 1) { $pionier = "-P"; } if ($line_['technician'] == 1) { $tech = "-T"; }
		        ?>
		        <tr style="text-align:center;">
		        	<td><a href="index?p=event&e=<?=$line['id']?>"><?=$line['name']?></a></td>
		        	<td><?=$type?></td>
		        	<td><?=$line['begin']?></td>
		        	<td class="name<?= $line_['rank'], $pionier, $tech?>"><?=$title, ' ', $line_['name']?></td>
		        </tr>
		        <tr>
		        	<td colspan="4">
		        		<div style="border-bottom:3px dashed black;margin-bottom:1%;margin-top:1%;"></div>
		        	</td>
		        </tr>
		        <?php
    			 }
    			 ?>
        	</tbody>
        </table>
        <?php
      }
     }
     else
     {
       echo '<p<Navré, mais vous n\'avez pas le niveau suffisant pour visionner cette page.</p>';
     }
   }
   else
   {
     echo '<p>Veuillez vous connecter pour accéder à cette page.</p>';
   }
}
?>
