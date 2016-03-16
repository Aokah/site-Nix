<?php function pnj_list ()
{
  global $db, $_SESSION, $_GET, $_POST;
  
  if ($_SESSION['connected']) { 

	if ($_SESSION['rank'] >= 6) {
		
	  if (isset($_GET['pnj']))
	  {
    		$pnj = intval($_GET['pnj']);
		$answer = $db->prepare('SELECT * FROM pnj_list AS p WHERE p.id = ?');
		$answer->execute(array($pnj));
		if ($line = $answer->fetch())
		{
			$filename = 'pics/pnj/pnj_' .$line['id']. '.png';if (file_exists($filename)) {$img = $line['id'];} else {$img = 'no';}
			if ($line['role'] == 0) { $color = "#0066FF"; $role = "Moindre";  }
			elseif ($line['role'] == 1) { $color = "#00FF00"; $role = "Mineure";  }
			elseif ($line['role'] == 2) { $color = "#FFCC00"; $role = "Intermédiaire";  }
			elseif ($line['role'] == 3) { $color = "#CC3300"; $role = "Majeure";  }
			elseif ($line['role'] == 4) { $color = "#FF0000"; $role = "Primaire";  }
			else { $color = "#808080"; $role = "Inconnu";  }
			$bg = preg_replace('#\n#', '<br />', $line['bg']);
?>
	<h3 style="color:<? echo $color?>; text-shadow: 2px 2px 2px #000000;">PNJ <?= $line['prenom']?></h3>
	<form action="index.php?p=pnj_list&a=edit" method="POST">
	<input type="hidden" name ="id" value="<? echo $pnj;?>" />
	<input type="submit" name="modifier" value="Modifier" style="color:blue;" />
	</form>
	
	<table class="pnjtable"  cellspacing="10px">
		<tbody>
				<tr>
					<td rowspan="4" width="150px" height="150px" style="border-radius: 10px;"><img width="180px" height="180px" src="pics/pnj/pnj_<?echo $img?>.png" /></td>	<td height="20px" style="border: 0px grey solid; background-color: grey;"> <p></p></td>
				</tr>
				<tr>
					<td width="60px" style="border: 0px grey solid; background-color: grey; color: grey;"><p></p></td> 	<td height="20px">Prénom : <?= $line['prenom']?> </td> <td height="20px">Nom : <?= $line['nom']?> </td><td width="89px" style="border: 0px grey solid; background-color: grey;"> <p></p></td>
				</tr>
				<tr>
					<td style="border: 0px grey solid; background-color: grey;"><p></p></td> <td width="80px" height="20px">Origine : <?= $line['origine']?> </td> <td width="80px" height="20px">Race : <?= $line['race']?> </td><td style="border: 0px grey solid; background-color: grey;"> <p></p></td>
				</tr>
				<tr>
					<td height="20px" style="border: 0px grey solid; background-color: grey;"> <p></p></td>
				</tr>
				<tr>
					<td>Taille : <?= $line['taille']?> </td> <td rowspan="2"><p>Signes distinctifs :</p> <?= $line['sd']?></td>
				</tr>
				<tr>
					<td>Poids :<?= $line['poids']?> </td>
					<td>Importance : <?php echo $role ?></td>
				</tr>
				<tr>
					<td>Elément : <?= $line['element']?> </td> <td colspan="3">Event d'apparition : <?= $line['event']?></td>
				</tr>
				<tr>
					<td><p>Qualités :</p><p><?= $line['qualite']?></p></td>
																<td style="vertical-align: top;" colspan="4" rowspan="5" width="100%" ><p>Histoire : </p>
																<p><?= $line['bg']?><p> </td>
				</tr>
				<tr>
					<td><p>Défaults :</p><p><?= $line['default']?></p></td>
				</tr>
				
				<tr>
					<td><p>Caractère :</p> <p><?= $line['caractere']?></p></td>
				</tr>
				<tr>
					<td><p>Equipement :</p>
					<p><?= $line['equipement']?></p></td>
				</tr>
		</tbody>
	</table>
	<?php  } else { echo  "<p>Une erreur s'est produite ou le PNJ n'existe pas.</p>"; }
  	}
  	elseif (isset($_GET['a']))
  	{
  			if ($_GET ['a'] == 'edit')
  			{
  				$id = $_POST['id'] ;
  				$answer = $db->prepare('SELECT * FROM pnj_list AS p WHERE p.id = ?');
				$answer->execute(array($id));
				if ($line = $answer->fetch())
				{
  				$filename = 'pics/pnj/pnj_' .$line['id']. '.png';if (file_exists($filename)) {$img = $line['id'];} else {$img = 'no';}
  				if ($line['role'] == 0) { $color = "#0066FF"; $role = "Moindre";  }
				elseif ($line['role'] == 1) { $color = "#00FF00"; $role = "Mineure";  }
				elseif ($line['role'] == 2) { $color = "#FFCC00"; $role = "Intermédiaire";  }
				elseif ($line['role'] == 3) { $color = "#CC3300"; $role = "Majeure";  }
				elseif ($line['role'] == 4) { $color = "#FF0000"; $role = "Primaire";  }
				else { $color = "#808080"; $role = "Inconnu";  }
				$bg = preg_replace('#\n#', '<br />', $line['bg']);
			?>	
		<h3 style="color:<? echo $color?>; text-shadow: 2px 2px 2px #000000;">PNJ <?= $line['prenom']?></h3>
			<table class="pnjtable"  cellspacing="10px">
				<tbody>
					<form action="index.php?p=pnj_list&a=valid" method="POST">
						<input type="hidden" name="id" value"<?php echo $id;?>" />
						<tr>
							<td rowspan="4" width="150px" height="150px" style="border-radius: 10px;"> <input type="hidden" value="<?= $line['id']?>" name="p_id" />
							<img width="150px" height="150px" src="pics/pnj/pnj_<?echo $img?>.png" /></td>	<td height="20px" style="border: 0px grey solid; background-color: grey;"> <p></p></td>
						</tr>
						<tr>
							<td width="60px" style="border: 0px grey solid; background-color: grey; color: grey;"><p></p></td> 	<td height="20px">Prénom : <input name="prenom" value="<?= $line['prenom']?>" type="text"/> </td> <td height="20px">Nom : <input name="nom" value="<?= $line['nom']?>" type="text"/> </td><td width="89px" style="border: 0px grey solid; background-color: grey;"> <p></p></td>
						</tr>
						<tr>
							<td style="border: 0px grey solid; background-color: grey;"><p></p></td> <td width="80px" height="20px">Origine :<input name="origine" value="<?= $line['origine']?>" type="text"/> </td> <td width="80px" height="20px">Race : <input name="race" value="<?= $line['race']?>" type="text"/> </td><td style="border: 0px grey solid; background-color: grey;"> <p></p></td>
						</tr>
						<tr>
							<td height="20px" style="border: 0px grey solid; background-color: grey;"> <p></p></td>
						</tr>
						<tr>
							<td>Taille : <input name="taille" value="<?= $line['taille']?>" type="text"/> </td> <td rowspan="2"><p>Signes distinctifs :</p><textarea style="width: 149px; height: 45px;" name="sd" ><?= $line['sd']?></textarea></td>
						</tr>
						<tr>
							<td>Poids :<input name="poids" value="<?= $line['poids']?>" type="text"/> </td>
							<td>Importance : <input name="role" value="<?= $line['role']?>" type="number" min=0 max=4 step=1/></td>
						</tr>
						<tr>
							<td>Elément : <input name="element" value="<?= $line['element']?>" type="text"/> </td> <td colspan="3">Event d'apparition : <input name="event" value="<?= $line['event']?>" type="text"/></td>
						</tr>
						<tr>
							<td><p>Qualités :</p><p><input name="qualite" value="<?= $line['qualite']?>" type="text"/></p></td>
																		<td style="vertical-align: top;" colspan="4" rowspan="5" width="100%" ><p>Histoire : </p>
																		<p><textarea style="width: 616px; height: 282px;" name="bg" ><?= $line['bg']?></textarea></p></td>
						</tr>
						<tr>
							<td><p>Défaults :</p><p><input name="default" value="<?= $line['default']?>" type="text"/></p></td>
						</tr>
						
						<tr>
							<td><p>Caractère :</p> <p><input name="caractere" value="<?= $line['caractere']?>" type="text"/></p></td>
						</tr>
						<tr>
							<td><p>Equipement :</p>
							<p><input name="equipement" value="<?= $line['equipement']?>" type="text"/></p></td>
						</tr>
						<tr>
						<input name="end" type="submit" value="Terminer">
						</tr>
					</form>
				</tbody>
			</table>
	<?php		}
  			}
  			elseif  ($_GET['a'] == 'valid')
  			{
  				echo $_POST['id'];
  				$id = $_POST['id'] ;
  				$prenom = "Inconnu";	$nom = "?";	$origine = "Inconnue";	$race = "Inconnue" ;
  				$taille = "?";		$poids = "?";	$sd = "Aucun";		$element = "?";
  				$qualité = "?";		$defaut = "?";	$event = "Inconnu";	$caractère = "?";
  				$equipement = "Inconnu";		$bg = "Non défini";	$role = htmlentities($_POST['role']);
  				if(!empty($_POST['prenom'])) { $prenom = htmlentities($_POST['prenom']); }
  				if(!empty($_POST['nom'])) { $nom = htmlentities($_POST['nom']); }
  				if(!empty($_POST['origine'])) { $origine = htmlentities($_POST['origine']); }
  				if(!empty($_POST['race'])) { $race = htmlentities($_POST['race']); }
  				if(!empty($_POST['taille'])) { $taille = htmlentities($_POST['taille']); }
  				if(!empty($_POST['poids'])) { $poids = htmlentities($_POST['poids']); }
  				if(!empty($_POST['sd'])) { $sd = htmlentities($_POST['sd']); }
  				if(!empty($_POST['element'])) { $element = htmlentities($_POST['element']); }
  				if(!empty($_POST['qualite'])) { $qualite = htmlentities($_POST['qualite']); }
  				if(!empty($_POST['defaut'])) { $defaut = htmlentities($_POST['defaut']); }
  				if(!empty($_POST['event'])) { $event = htmlentities($_POST['event']); }
  				if(!empty($_POST['caractere'])) { $caractere = htmlentities($_POST['caractere']); }
  				if(!empty($_POST['equipement'])) { $equipement = htmlentities($_POST['equipement']); }
  				if(!empty($_POST['bg'])) { $bg = htmlentities($_POST['bg']); }
  				
  				if (isset($_POST['end']))
  					{
  						$edit = $db->prepare('UPDATE pnj_list SET role = ?, prenom = ?, nom = ?, origine = ?, race = ?, taille = ?,
  						poids = ?, sd=  ?, element = ?, qualite = ?, defaut = ?, event = ?, caractere = ?, equipement = ?, bg = ?, WHERE id = ?');
  						$edit->execute(array($role, $prenom, $nom, $origine, $race, $taille, $poids, $sd, $element, $qualite,
  						$defaut, $event, $caractere, $equipement, $bg, $id));
  						?>
  						<p>Votre page a bien été modifiée !</p> 
  						<p><a href = "index?p=pnj_list&pnj=<?php echo $id; ?>">Cliquez ici</a> Pour accéder à la page.</p>
  						<p><a href="index?p=pnj_list">Cliquez ici</a> pour retourner à la Liste des Personnages Non Joueurs</p>
  						<?php
  					}
  				elseif (isset($_POST['envoi']))
  					{
  						$add = $db->prepare("INSERT INTO pnj_list VALUES(' ',?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?");
  						$add->execute(array($role, $prenom, $nom, $origine, $race, $taille, $poids, $sd, $element, $qualite,
  						$defaut, $event, $caractere, $equipement, $bg));
  						?>
  						<p>Votre apge a bien été créée ! Vous pouvez la consulter dès maintenant.</p>
  						<p><a href="index?p=pnj_list">Cliquez ici</a> pour retourner à la Liste des Personnages Non Joueurs</p>
  						<?php
  					}
  				}
  				else  { echo '<p>Une erreur s\'est produite</p>'; }
  	}
  	else 
  	{
  		$answer0 = $db->query("SELECT * FROM pnj_list WHERE role = 0 ORDER BY role DESC, prenom ASC");
		$answer1 = $db->query("SELECT * FROM pnj_list WHERE role = 1 ORDER BY role DESC, prenom ASC");
		$answer2 = $db->query("SELECT * FROM pnj_list WHERE role = 2 ORDER BY role DESC, prenom ASC");
		$answer3 = $db->query("SELECT * FROM pnj_list WHERE role = 3 ORDER BY role DESC, prenom ASC");
		$answer4 = $db->query("SELECT * FROM pnj_list WHERE role = 4 ORDER BY role DESC, prenom ASC");
	?>
		<h3>Liste de PNJ</h3>
	<p>Liste des PNJs officiels de Nix</p>
	<p><a href="index.php?p=pnj_list&action=createpage">Créer une nouvelle fiche</a></p>
	
	<table id="members">
		<tbody>
			<th>PNJs Moindres</th>
			<th>PNJs Mineurs</th>
			<th>PNJs Intermédiaires</th>
			<th>PNJs Majeurs</th>
			<th>PNJs Primaires</th>
			<tr style="v-align: top;">
			<td><ul> <?	while ($line = $answer0->fetch()) 	{	?>
			<li>
			<a style="color:#0066FF; text-shadow: 2px 2px 2px #000000;" href="index.php?p=pnj_list&pnj=<?= $line['id']?>"><?= $line['prenom']?></a>
			</li> <?} ?>
			</ul></td>
			<td><ul>
			<? while ($line = $answer1->fetch()) 	{	?><li>
			<a style="color:#00FF00; text-shadow: 2px 2px 2px #000000;" href="index.php?p=pnj_list&pnj=<?= $line['id']?>"><?= $line['prenom']?></a>
			</li><? } ?>
			</ul></td>
			<td><ul>
			<? while ($line = $answer2->fetch()) 	{	?><li>
			<a style="color:#FFCC00; text-shadow: 2px 2px 2px #000000;" href="index.php?p=pnj_list&pnj=<?= $line['id']?>"><?= $line['prenom']?></a>
			</li> <? } ?>
			</ul></td>
			<td><ul>
			 <? while ($line = $answer3->fetch()) 	{	?><li>
			<a style="color:#CC3300; text-shadow: 2px 2px 2px #000000;" href="index.php?p=pnj_list&pnj=<?= $line['id']?>"><?= $line['prenom']?></a>
			</li><? } ?> 
			</ul></td>
			<td><ul>
			<? while ($line = $answer4->fetch()) 	{	?><li>
			<a style="color:#FF0000; text-shadow: 2px 2px 2px #000000;" href="index.php?p=pnj_list&pnj=<?= $line['id']?>"><?= $line['prenom']?></a>
			</li><? } ?>
			</ul></td>
			</tr>
		</tbody>
	</table>
	<?php
  	}
	}
  	else { echo '<p>Vous n\'avez pas le grade suffisant pour visionner cette page</p>'; }
  	}
  	else { '<p>Vous devez être connecté pour visionner cette page.</p>'; }
}
?>
