<?php function magie_admin ()
{
	global $db, $_SESSION;

	if ($_SESSION["connected"])
	{
		
		if ($_SESSION["rank"] >= 5)
		{ 
			
			if (isset($_POST['valid']))
			{
				$name = mb_strtolower($_POST['name']);
				$codename = substr($name, 0, 4);
				switch ($_POST['title'])
				{
					default : $titlecode = "xx"; break; case 2: $titlecode = "di"; break;
					case 1: $titlecode = "ti"; break; case 3 : $titlecode = "ga"; break;
					case 4 : $titlecode = "de"; break;
				}
				$code = 'p'. $titlecode.''. $codename .'';
				$text = htmlspecialchars($_POST['textfr']);
				$galactic = htmlspecialchars($_POST['textla']);
				
				$presel = $db->prepare('SELECT * FROM pieres WHERE code = ?');
				$presel->execute(array($code));
				
				if ($presel->fetch())
				{
					echo '<p class="name6">Erreur : L\'entité posède déjà une prière pour son poste, vérifiez si la prière n\'est pas déjà listée.</p>';
				}
				else
				{
					$add = $db->prepare("INSERT INTO pieres VALUES('', ? , ? , ? , ?)");
					$add->execute(array(htmlspecialchars($_POST['name']), $code, $text, $galactic));
					echo '<p class="name5">La prière a bien été ajoutée, n\'oubliez pas de conclure l\'ajout par la formule d\'appel à l\'entité correspondante !</p>';
				}
			}
			elseif (isset($_POST['add']))
			{
				
				$verif = $db->prepare('SELECT name FROM incan_list WHERE name = ?'); $verif->execute(array($name));
				
				if ($verif->fetch())
				{
					echo '<p class="name6">Navré, mais le sort existe déjà, vérifiez qu\'il n\'est pas déjà dans la liste ci-dessous.</p>';
				}
				elseif (isset($_POST['name']) AND isset($_POST['cost']) AND isset($_POST['description']))
				{
					$command = (isset($_POST['command'])) ? htmlspecialchars($_POST['command']) : 'none';
					$desc = htmlspecialchars($_POST['description']);
					$name = htmlspecialchars($_POST['name']);
					$name = mb_strtoupper($name);
					$norma = $_POST['cost'] / 100000000000000;
					$add = $db->prepare("INSERT INTO incan_list VALUES('',? , ? , ? , ? , ?, ? , ?)");
					$add->execute(array($name, $desc, $_POST['level'], $_POST['type'], $_POST['cost'], $norma, $command));
					echo '<p class="name5">Le sort a bel et bien été ajouté, vous pouvez désormais le consulter ci-dessous.</p>';
				}
				else
				{
					echo '<p class="name6">Navré, mais vous n\'avez pas rempli tous les champs de ce formulaire, veuillez recommencer.</p>';
				}
			}
			?>
	
		<h2>Liste des sorts et d'incantations</h2>
		
		<?php if ($_SESSION['rank'] > 6 OR $_SESSION['id'] == 132)
		{
		?>
			<form action="index?p=magie_admin" method="POST">
				<table style="text-align:center;" width="100%">
					<tbody>
						<tr>
							 <th width=50%>Formule à incorporer</th> <th>Commande éventuelle</th>
						</tr>
						<tr>
							<td>
								<input type="text" name="name" />
							</td>
							<td>
								<input type="text" name="command" />
							</td>
						</tr>
						<tr>
							<th colspan="2">Description du sort</th>
						</tr>
						<tr>
							<td colspan="2">
								<input type="text" name="description" />
							</td>
						</tr>
						<tr>
							<th>Niveau du sort</th> <th>Element du sort</th>
						</tr>
						<tr>
							<td>
								<select name="type">
									<option value="0">Type Inconnu</option>
									<option value="1">Aeromancie</option>
									<option value="7">Cryomancie</option>
									<option value="5">Electromancie</option>
									<option value="3">Entropie</option>
									<option value="16">Eurythmie</option>
									<option value="9">Ferromancie</option>
									<option value="4">Hydromancie</option>
									<option value="8">Luciomancie</option>
									<option value="11">Occultomancie</option>
									<option value="10">Phytomancie</option>
									<option value="12">Psychomancie</option>
									<option value="6">Pyromancie</option>
									<option value="13">Telluromancie</option>
									<option value="14">Thermoancie</option>
									<option value="2">Temps</option>
									<option value="15">Spatial</option>
									<option value="17">Void</option>
								</select>
							</td>
							<td>
								<select name="level">
									<option value="1">Niveau F</option>
									<option value="2">Niveau E</option>
									<option value="3">Niveau D</option>
									<option value="4">Niveau C</option>
									<option value="5">Niveau B</option>
									<option value="6">Niveau A</option>
									<option value="7">Niveau S</option>
									<option value="8">Niveau X</option>
								</select>
							</td>
						</tr>
						<tr>
							
							<td>
								<label for="cost">Coùt </label><input type="number" name="cost" id="cost" />
							</td>
							<td>
								<input type="submit" name="add" value="Ajouter"/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		<?php	
		}
				$answer = $db->query("SELECT * FROM incan_list ORDER BY level DESC , type ASC, name ASC");
		?>
			
			<table>
				<tbody>
					<tr class="member_top">
						<th>Formule</th>
						<th>Description</th>
						<th>Energie nécessaire</th>
						<th>Commande</th>
						<th>Classe</th>
						<th>Type</th>
					</tr>
					<?php
					while ($line = $answer->fetch())
					{
						switch ($line['level'])
						{
							case 8: $level = "X"; break;	case 7:  $level = "S"; break; case 6:  $level = "A"; break;
							case 5:  $level = "B"; break; case 4:  $level = "C"; break; case 3:  $level = "D"; break; 
							case 2:  $level = "E"; break; case 1:  $level = "F"; break; default : $level = "F"; break;
						}
						switch ($line['type'])
						{
							case 14: $type = "Chaleur" ; break;  case 15: $type = "Espace" ; break;  case 16: $type = "Ordre" ; break; 
							case 17: $type = "Void" ; break; case 13: $type	= "Terre" ; break; case 12: $type = "Psy" ; break;
							case 11: $type = "Ombre" ; break; case 10:  $type = "Nature" ; break; case 9:  $type = "Métal" ; break;
							case 8: $type = "Lumière" ; break; case 7: $type = "Glace" ; break; case 6: $type = "Feu" ; break;
							case 5: $type = "Energie" ; break; case 4: $type = "Eau" ; break; case 3: $type = "Chaos" ; break;
							case 2: $type = "Arcane" ; break; case 1: $type = "Air" ; break; default: $type = "Inconnue" ; break;
						}	
					?>
					<tr class="memberbg_4">
						<td><?= $line['name']?></td>
						<td><?= $line['desc']?></td>
						<td style="text-align:center;"><?= $line['cost']?></td>
						<td style="text-align:center;"><?= $line['command']?></td>
						<td style="text-align:center;"><img class="magie" src="pics/magie/Magie_<?php echo $level ?>.png" alt="Niveau <?php echo $level ?>" title="Niveau <?php echo $level ?>" /></td>
						<td style="text-align: center;"><img class="magie_type" src="pics/magie/Magie_<?php echo $type ?>.png" width="49" alt="Type <?php echo $type ?>" title="<?php echo $type ?>"/></td>
					</tr>
					<?php
					}
					?> 
				</tbody>
			</table>
			
			<h2>Pages de prières aux entités</h2>
			<?php if ($_SESSION['rank'] > 6 OR $_SESSION['id'] == 132)
			{
			?>
				<h4>Création d'une nouvelle prière</h4>
				<form action="index?p=magie_admin" method="POST">
					<table style="text-align:center;" width="100%">
						<tbody>
							<tr>
								<th>Nom de l'entité</th> <th>Poste de l'entité</th>
							</tr>
							<tr>
								<td><input type="text" name="name" /></td>
								<td><select name="title">
									<option value="1">Titan</option>
									<option value="2">Dieu</option>
									<option value="3">Gardien</option>
									<option value="4">Démon</option>
								</select></td>
							</tr>
							<tr>
								<th>Prière en Français</th> <th>Prière en Galactique</th>
							</tr>
							<tr>
								<td width="50%">
									<div align="center">
										<textarea name="textfr" placeholder="Prière en Français"></textarea>
									</div>
								</td>
								<td width="50%">
									<div align="center">
										<textarea name="textla" placeholder="Prière en Latin"></textarea>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="submit" name="valid" value="Ajouter la Prière"
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			<?php
			} 
			
			$select = $db->query('SELECT * FROM pieres ORDER by name DESC');
			while ($line = $select->fetch())
			{
			?>
				<h4>Prière à <?= $line['name']?></h4>
				<p><img src="pics/Image_<?= $line['code']?>.png" width="30%" alt="" align="center"/> <br />
				Prière traduite : <?= $line['text_fr']?> <br/>
				Prière RP : <?= $line['text_rp']?></p>
			<?php
			}
		}
		else
		{
		?>
			<p>Vous n'avez pas le grade suffisant pour voir cette page.</p>
		<?
		} 
	}
	else
	{
	?>
		<p>Vous devez être connecté pour voir cette page</p>
	<?
	}
}
?>
