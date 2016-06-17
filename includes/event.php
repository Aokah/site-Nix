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
      	
      	if (isset($_GET['modif']))
      	{
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
				        		<option value="0">-- Option par défaut --</option>
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
				        <tr>
				        	<td colspan="4">
				        		<textarea name="content"><?=$line['content']?></textarea>
				        	</td>
				        </tr>
			        	</tbody>
			        </table>
		      	</form>
		<?php
		}
      	}
      	elseif (isset($_GET['addto']))
      	{
      		
      	}
      	else
      	{
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
		        <tr>
		        	<td colspan="4">
		        		<p><?= $text?></p>
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
