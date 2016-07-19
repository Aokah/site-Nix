<?php function magie_admin ()
{
	global $db, $_SESSION;

	$answer = $db->query("SELECT COUNT(*) AS number FROM incan_list");
	$line = $answer->fetch();
	$answer->closeCursor();

	if ($_SESSION["connected"]) {
		
	if ($_SESSION["rank"] >= 4) { ?>

	<h2>Liste des sorts et d'incantations</h2>
	
	<?php
			$answer = $db->query("SELECT * FROM incan_list ORDER BY level DESC , type ASC, name ASC");
	?>
		
		<table>

			<th>Formule</th>
			<th>Description</th>
			<th>Energie nécessaire</th>
			<th>Commande</th>
			<th>Classe</th>
			<th>Type</th>
		
				
		<?php

	while ($line = $answer->fetch())
	{
							switch ($line['level']) { case 8: $level = "X"; break;	case 7:  $level = "S"; break; case 6:  $level = "A"; break; case 5:  $level = "B"; break; case 4:  $level = "C"; break; case 3:  $level = "D"; break; 
								case 2:  $level = "E"; break; case 1:  $level = "F"; break;}
							switch ($line['type']) {
								 case 14: $type = "Chaleur" ; break;  case 15: $type = "Espace" ; break;  case 16: $type = "Ordre" ; break;  case 17: $type = "Void" ; break;
								case 13: $type	= "Terre" ; break; case 12: $type = "Psy" ; break; case 11: $type = "Ombre" ; break; case 10:  $type = "Nature" ; break; case 9:  $type = "Métal" ; break;
								case 8: $type = "Lumière" ; break; case 7: $type = "Glace" ; break; case 6: $type = "Feu" ; break; case 5: $type = "Energie" ; break;
								case 4: $type = "Eau" ; break; case 3: $type = "Chaos" ; break; case 2: $type = "Arcane" ; break; case 1: $type = "Air" ; break; default: $type = "Inconnue" ; break; }

		
		?>
		
			<tr>
				<td><?= $line['name']?></td>
				<td><?= $line['desc']?></td>
				<td><img src="pics/magie/xp.png" alt="XP" class="magie_type" /> <?= $line['cost']?></td>
				<td><?= $line['command']?></td>
				<td><img class="magie" src="pics/magie/Magie_<?php echo $level ?>.png" alt="Niveau <?php echo $level ?>" title="Niveau <?php echo $level ?>" /></td>
				<td><img class="magie_type" src="pics/magie/Magie_<?php echo $type ?>.png" width="49" alt="Type <?php echo $type ?>" title="<?php echo $type ?>"/></td>
			</tr>
	<?php
	}
	?> 
			
		</table>
		
		<h2>Pages de prières aux entités</h2>
		<?php 
			$name = "Thorgeir";
			$title = "Gardien";
			$name = mb_strtolower($name);
			$codename = substr($name, 0, 4);
			switch ($title)
			{
				default : $titlecode = "xx"; break; case 2: $titlecode = "di"; break;
				case 1: $titlecode = "ti"; break; case 3 : $titlecode = "ga"; break;
				case 4 : $titlecode = "de"; break;
			}
			$code = 'p'. $titlecode.''. $codename .'';
			echo $name, ' ', $code;
		?>
			<h4>Création d'une nouvelle prière</h4>
			<form action="index?p=magie_admin" method="POST">
				<table style="text-align:center;">
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
							<td>
								<div align="center">
									<textarea name="text-fr" placeholder="Prière en Français"></textarea>
								</div>
							</td>
							<td>
								<div align="center">
									<textarea name="text-gala" placeholder="Prière en Latin"></textarea>
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
			<h4>Thorgeir</h4>
			<p><img src="http://www.rpnix.com/pics/Image_pgthor.gif" alt="Prière à Thorgeir" /><br />
			Traduction : Thorgeir tatium quantum curator orbis, audient vocem tuam et veni fidelem nobis <br />
			(fr) Thorgeir, représentant du respect, protecteur du Monde, entends l'appel de tes fidèles et viens à nous</p>
			
			<h4>Zitsi</h4>
			<p><img src="http://www.rpnix.com/pics/Image_pdzit.gif" alt="Prière à Zitsi" /><br />
			Traduction : Zitsi superbus tribu duce nos honoris tui nobiscum fidélibus tuis! <br />
			(fr) Zitsi, fier guide de notre tribue, fais nous l'honneur de ta présence à nous, tes plus fidèles serviteurs !</p>
			
			<h4>Saramino</h4>
			<p><img src="http://www.rpnix.com/pics/Image_pdsara.gif" alt="Prière à Saramino" /><br />
			Traduction : Domine Deus noster chaos mundi gloria nostra coram nobis et respondit inferioribus vocationis ! <br />
			(fr) Ô dieu du chaos et de notre monde, fais-nous l'honneur de ta présence sur notre bas-monde et réponds à notre appel !</p>
			
			
	<? } ?>	<?php if ($_SESSION["rank"] < 5) { ?>
		<p>Vous n'avez pas le grade suffisant pour voir cette page.</p>
	<? } 
}
		else
		{?> <p>Vous devez être connecté pour voir cette page</p> <? }
	
	?>
	
<?php
}
?>
