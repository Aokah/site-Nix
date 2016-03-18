<?php function perso ()
{
	global $db, $_POST, $_GET, $_SESSION;

	include('includes/interface/JSONapi.php');



		$ip = 'soul.omgcraft.fr';

		$port = 20059;

		$user = "nix";

		$pwd = "dragonball";

		$salt = 'salt';

		$api = new JSONAPI($ip, $port, $user, $pwd, $salt);

	if (isset($_GET['perso']))
	{
		if (isset($_GET['modif']))
		{
			$perso = intval($_GET['perso']);
			$page = $db->prepare('SELECT * FROM members WHERE id= ?');
			$page->execute(array($perso));
			
			if ($line = $page->fetch()) {
				if($_GET['modif'] == "save")
					{
						if(isset($_POST['confirm']))
						{
							if ($_SESSION['rank'] >= 5) {
							$prenom = $line['name']; $nom = "?"; $race = htmlentities($_POST['race']); $qualite = "?";
							$defauts = "?"; $sd = "Non définis"; $caractere = "?"; $titre = $line['title'];
							if ($race = "defaut") { $race = $line['race']; }
							
							if (!empty($_POST['titre'])) { $titre = htmlentities($_POST['titre']); }
							if (!empty($_POST['prenom'])) { $prenom = htmlentities($_POST['prenom']); }
							if (!empty($_POST['nom'])) { $nom = htmlentities($_POST['nom']); }
							if (!empty($_POST['qualite'])) { $qualite = htmlentities($_POST['qualite']); }
							if (!empty($_POST['defauts'])) { $defauts = htmlentities($_POST['defauts']); }
							if (!empty($_POST['sd'])) { $sd = htmlentities($_POST['sd']); }
							if (!empty($_POST['caractere'])) { $caractere = htmlentities($_POST['caractere']); }
							$update = $db->prepare('UPDATE members SET name = ?, nom = ?, race = ?, title= ?, qualites = ?, defauts = ?, sd = ?, caractere = ? WHERE id = ?');
							$update->execute(array($prenom, $nom, $race,$titre, $qualite, $defauts, $sd, $caractere, $perso));
							echo '<p>Modifications des informations personnelles effectuées avec succès</p>';
							}
							else { echo '<p>Tara tata ta ! On force pas le système ici !</p>'; }
						}
						elseif(isset($_POST['terminer']))
						{
							if ($_SESSION['rank'] >= 5) {
								
								$pseudo = $line['Minecraft_Account']; $email = $line['email']; $staffnote = "none";
								if (!empty($_POST['pseudo'])) { $pseudo = htmlentities($_POST['pseudo']); }
								if(!empty($_POST['email'])) { $email = $_POST['email']; }
								if(!empty($_POST['staffnote'])) { $staffnote = htmlentities($_POST['staffnote']); }
								
								$update = $db->prepare('UPDATE members SET Minecraft_Account = ?, email = ?, staffnote = ? WHERE id = ?');
								$update->execute(array($pseudo, $email, $staffnote, $perso));
								echo '<p>Modifications des informations administratives effectuées avec succès</p>';
							}
							else { echo '<p>Tara tata ta ! On force pas le système ici !</p>'; }
						}
						elseif(isset($_POST['valid']))
						{
							if ($_SESSION['rank'] >= 5) {
								
								$update = $db->prepare('UPDATE members SET E_Magique = ?, E_Vitale = ?, specialisation = ?, spe_2 = ? WHERE id = ?');
								$update->execute(array($_POST['e-magie'], $_POST['e-vie'], $_POST['spe_1'], $_POST['spe_2'], $perso));
								echo '<p>Modifications des informations magiques effectuées avec succès</p>';
							}
							else { echo '<p>Tara tata ta ! On force pas le système ici !</p>'; }
						}
						else { echo '<p>Une erreur s\'est produite.</p>'; }
					}
					
				elseif($_GET['modif'] == 'info')
				{
				?>
					<h3>Modification des informations personnelles du personnage</h3>
					<form action="index?p=perso&perso=<?php echo $perso;?>&modif=save" method="POST">
						<table cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
							<tbody>
								<tr>
									<td>
										Identité :
									</td>
									<td>
										<label for="prenom">Prénom :</label> <input type="text" id="prenom" name="prenom" value="<?= $line['name']?>" />
									</td>
									<td>
										<label for="nom">Nom :</label> <input type="text" id="nom" name="nom" value="<?= $line['nom']?>" />
									</td>
									<td>
										<label for="race">Race :</label>
											<select name="race" type="text">
												<option value="defaut">--Option par défaut--</option>
												<option value="Elfe">Elfe</option>
												<option value="Ernelien">Ernelien</option>
												<option value="Humain">Humain</option>
												<option value="Hybride">Hybride (Animal)</option>
												<option value="Inconnue">Inconnue</option>
												<option value="Nain">Nain</option>
												<option value="Onyx">Onyx</option>
												<option value="Orque">Orque</option>
												<option value="Spécial">Spécial</option>
												<option value="Stromnole">Stromnole</option>
												<option value="Titanoide">Titanoïde</option>
											</select>
									</td>
									<td>
										<label>Titre :</label> <input type="text" name"titre" value="<?= $line['title']?>" />
									</td>
								</tr>
								<tr>
									<td>
										Personalité :
									</td>
									<td>
										<label for="qualite">Qualité :</label>  <input type="text" id="qualite" name="qualite" value="<?= $line['qualites']?>" />
									</td>
									<td>
										<label for="defauts">Défauts :</label> <input type="text" id="defauts" name="defauts" value="<?= $line['defauts']?>" />
									</td>
									<td>
										<label for="sd">Signes Distinctifs :</label> <input type="text" id="sd" name="sd" value="<?= $line['sd']?>" />
									</td>
									<td>
										<label for="caractere">Caractère :</label> <input type="text" id="caractere" name="caractere" value="<?= $line['caractere']?>" />
									</td>
								</tr>
							</tbody>
						</table>
						<input type="submit" name="confirm" value="Valider" />
					</form>
				<?php
				}
				elseif($_GET['modif'] == 'admin')
				{
				?>
					<h3>Modification des informations administratives du personnage</h3>
					<form action="index?p=perso&perso=<?php echo $perso;?>&modif=save" method="POST">
						<table cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
							<tbody>
								<tr>
									<td>
										<label for="pseudo">
											Pseudo Minecraft :
										</label>
										<input type="text" id"pseudo" name="pseudo" value="<?= $line['Minecraft_Account']?>" />
									</td>
									<td>
										<label for="email">
											E-mail :
										</label>
										<input type="email" id"email" name="email" value="<?= $line['email']?>" />
									</td>
									<td>
										<input type="submit" name="terminer" />
									</td>
								</tr>
								<tr>
									<td>
										<label>
											Note du Staff :
										</label>
										<textarea name='staffnote'><?= $line['staffnote']?></textarea>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				<?php
				}
				elseif($_GET['modif'] == 'magie')
				{
					switch ($line['magie_rank']) { case 0: $maxmagie = 50; break;	case 1: $maxmagie = 100; break;	case 2: $maxmagie = 150; break;
					case 3: $maxmagie = 200; break;	case 4: $maxmagie = 300; break;	case 5: $maxmagie = 400; break;	case 6: $maxmagie = 500; break; }
					if ($line['E_magique'] >= 7) { $overmagie = 'Inutile de modifier l\'énergie d\'un personnage aux poubvoirs illimités !'; }
				?>
					<h3>Modification des informations magiques du personnage</h3>
					<form action="index?p=perso&perso=<?php echo $perso;?>&modif=save" method="POST">
						<table cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
							<tbody>
								<tr>
									<td>
										Energie Magique :
									</td>
									<td>
										<?php if ($line['magie_rank'] < 7) { ?>
										<input type="number" name"e-magie" min="0" step="1" value="<?= $line['E_magique']?>" max="<?php echo $maxmagie; ?>"></code> <?php } else { ?>
										<?php echo $overmagie; }?>
									</td>
									<td>
										Energie Vitale :
									</td>
									<td>
										<input type="number" name"e-vie" min="0" step="1"  value="<?= $line['E_vitale']?>" max="200"></code>
									</td>
									<td>
										<input type="submit" name="valid" />
									</td>
								</tr>
								<tr>
									<td>
										<label for="race">Spécialisation primaire :</label>
											<select name="spe_1" type="text">
												<option value="defaut">--Option par défaut--</option>
												<option value="Air">Air</option>
												<option value="Arcane">Arcane</option>
												<option value="Chaos">Chaos</option>
												<option value="Eau">Eau</option>
												<option value="Energie">Energie</option>
												<option value="Feu">Feu</option>
												<option value="Glace">Glace</option>
												<option value="Inconnue">Inconnue</option>
												<option value="Lumiere">Lumière</option>
												<option value="Metal">Métal</option>
												<option value="Nature">Nature</option>
												<option value="Ombre">Ombre</option>
												<option value="Psy">Psy</option>
												<option value="Spécial">Spécial</option>
												<option value="Terre">Terre</option>
											</select>
									</td>
									<td>
										<label for="race">Spécialisation secondaire :</label>
											<select name="spe_2" type="text">
												<option value="defaut">--Option par défaut--</option>
												<option value="Air">Air</option>
												<option value="Arcane">Arcane</option>
												<option value="Chaos">Chaos</option>
												<option value="Eau">Eau</option>
												<option value="Energie">Energie</option>
												<option value="Feu">Feu</option>
												<option value="Glace">Glace</option>
												<option value="Inconnue">Inconnue</option>
												<option value="Lumiere">Lumière</option>
												<option value="Metal">Métal</option>
												<option value="Nature">Nature</option>
												<option value="Ombre">Ombre</option>
												<option value="Psy">Psy</option>
												<option value="Spécial">Spécial</option>
												<option value="Terre">Terre</option>
											</select>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				<?php
				}
				else { echo '<p>Hop hop hop ! Où tu va ? :D</p>'; }
			}
		}
		elseif (isset($_GET['action']))
		{
			$perso = intval($_GET['perso']);
			$page = $db->prepare('SELECT * FROM members WHERE id= ?');
			$page->execute(array($perso));
			
			if ($line = $page->fetch()) {
			if($_GET['action'] == 'upgrade')
			{
				if ($_SESSION['rank'] >= 5) {
				$rank = $line['rank'] + 1;
				$update = $db->prepare('UPDATE members SET rank = ? WHERE id = ?');
				$update->execute(array( $rank, $perso));
				$add = $db->prepare('INSERT INTO hist_grada (upper_id, method, upped_id, up_date) VALUES (?, 1, ?, NOW() )');
				$add->execute(array($_SESSION['id'], $perso));
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'downgrade')
			{
				if ($_SESSION['rank'] >= 5) {
				$rank = $line['rank'] - 1;
				$update = $db->prepare('UPDATE members SET rank = ? WHERE id = ?');
				$update->execute(array( $rank, $perso));
				$add = $db->prepare('INSERT INTO hist_grada (upper_id, method, upped_id, up_date) VALUES (?, 0, ?, NOW() )');
				$add->execute(array($_SESSION['id'], $perso));
				echo '<p>Le personnage a bien été dégradé.</p>';
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'dignitaire')
			{
				if ($_SESSION['rank'] >= 5) {
				$rank = $line['rank'] - 1;
				$update = $db->prepare('UPDATE members SET rank = ?, dignitaire = 1 WHERE id = ?');
				$update->execute(array( $rank, $perso));
				$add = $db->prepare('INSERT INTO hist_grada (upper_id, method, upped_id, up_date) VALUES (?, 0, ?, NOW() )');
				$add->execute(array($_SESSION['id'], $perso));
				echo '<p>Le personnage a bien été dégradé.</p>';
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'return')
			{
				if ($_SESSION['rank'] >= 5) {
				$rank = $line['rank'] + 1;
				$update = $db->prepare('UPDATE members SET rank = ?, dignitaire = 0 WHERE id = ?');
				$update->execute(array( $rank, $perso));
				
				$add = $db->prepare('INSERT INTO hist_grada (upper_id, method, upped_id, up_date) VALUES (?, 1, ?, NOW() )');
				$add->execute(array($_SESSION['id'], $perso));
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'end')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'avert')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'tech')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'ban')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'pardon')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'delete')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'restore')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'magieup')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'magiedown')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'vanishoff')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'vanishon')
			{
				if ($_SESSION['rank'] >= 5) {
				
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			else { echo '<p>Hop hop hop ! Où tu va ? :D</p>';}
			}
			else { echo '<p>Une erreur s\'est produite.</p>';}
		}
		else
		{
		$perso = intval($_GET['perso']);
		$page = $db->prepare('SELECT * FROM members WHERE id= ?');
		$page->execute(array($perso));
		
		if ($line = $page->fetch()) {
		$magieok = 'Non acquise';
		if ($line['magieok'] == 1) { $magietest = true; }
		if ($magietest) { $magieok = 'Acquise'; }
		$bg = preg_replace('#\n#', '<br />', $line['background']);
		$bg = ($bg != 'none') ? $bg : 'En attente ...';
		$notestaff = preg_replace('#\n#', '<br />', $line['staffnote']);
		$notestaff = ($notestaff != 'none') ? $notestaff : 'En attente ...';
		$hrp = preg_replace('#\n#', '<br />', $line['bg_hrp']);
		$hrp = ($hrp != 'none') ? $hrp : 'En attente ...';
		$notes = preg_replace('#\n#', '<br />', $line['notes_perso']);
		$notes = ($notes != 'none') ? $notes : 'En attente ...';
		
		switch ($line['magie_rank']) {
			case 0: $magie = "Profane"; break;	case 1: $magie = "Adepte"; break;	case 2: $magie = "Apprenti Magicien"; break;
			case 3: $magie = "Magicien"; break;	case 4: $magie = "Mage"; break;		case 5: $magie = "Archimage"; break;
			case 6: $magie = "Sage"; break;		case 7: $magie = "Divin"; break;	case 8: $magie = "Titanèsque"; break;
			case 9: $magie = "Pouvoir Suprême"; break;
		}
		$vanish = ($line['invisible'] == 1) ? 'Activée' : 'Désactivée';
		$filename = 'pics/pnj/pnj_' .$line['id']. '.png';if (file_exists($filename)) {$img = $line['id'];} else {$img = 'no';}
		if ($line['technician'] == 1) { $tech = "-T"; $techmode = "Retirer"; } else { $techmode = "Attribuer";}  if ($line['pionier'] == 1) { $pionier = '-P'; }
	?>
	<h2 class="name<?= $line['rank']?><?php echo $tech; echo $pionier;?>"><?= $line['title']?> <?= $line['name']?></h2>
	
	<table cellspacing="5" cellpadding="5">
		<tbody>
			<tr>
				<td valign="top" width="50%">
					<table cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td style="border-radius: 10px;" rowspan="4" width="200px">
									<img src="pics/persoimg/perso_<?= $line['id']?>.png" alt="" width="200px" />
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p>Nom : <?= $line['name']?></p>
								</td>
							</tr>
								
							<tr>
								<td colspan="2">
									<p>Magie : <? echo $magieok; ?></p>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p>Titre : <img src="pics/rank<?= $line['rank']?>.png" alt="" width="25" /> <?= $line['title']?></p>
								</td>
							</tr>
							<tr>
								<td colspan="4" style="border: 0px grey solid; background-color: grey; color: grey; text-align:justify;">
									<?php if ($line['rank'] == 2 OR $line['rank'] == 3) { if($_SESSION['rank'] > $line['rank']+1) { ?>
									<a title="Monter le joueur en grade" href="index?p=perso&perso=<?php echo $perso; ?>&action=upgrade" style="color:green;">[+]</a>	
									<?php } } 
									elseif ($line['rank'] >= 4 AND $line['rank'] <= 10 AND $line['valid_bg'] == 1 AND $_SESSION['rank'] > $line['rank']+1) {?>
									<a title="Monter le joueur en grade" href="index?p=perso&perso=<?php echo $perso; ?>&action=upgrade" style="color:green;">[+]</a>
									<?php } 
									if ($_SESSION['rank'] > $line['rank'] AND $line['rank'] >= 2) { ?>
									<a title="Dégrader le joueur" href="index?p=perso&perso=<?php echo $perso; ?>&action=downgrade" style="color:red;">[-]</a>
									<?php } 
									if ($_SESSION['rank'] > $line['rank'] AND $line['rank'] >= 5 AND $line['dignitaire'] == 1) { ?>
									<a title="Dégrader le joueur en tant qu'Ex-Staffeux" href="index?p=perso&perso=<?php echo $perso; ?>&action=dignitaire" style="color:orange;">[D]</a> 
									<?php } 
									if ($_SESSION['rank'] > $line['rank'] AND $line['dignitaire'] == 1) {?>
									<a title="Faire revenir le compte dans le Staff" href="index?p=perso&perso=<?php echo $perso; ?>&action=return" style="color:lime;">[R]</a> 
									<?php } 
									if ($_SESSION['rank'] >= 6 AND $line['rank'] >=2 AND $line['rank'] <= 7) { ?>
									<a title="Faire finir le jeu au joueur" href="index?p=perso&perso=<?php echo $perso; ?>&action=end" style="color:yellow;">[F]</a> 
									<?php }
									if ($_SESSION['rank'] >= 4 AND $_SESSION['rank'] > $line['rank']) { ?>
									<a title="Coller un avertissement au joueur" href="index?p=perso&perso=<?php echo $perso; ?>&action=avert" style="color:red;">[A]</a> 
									<?php }
									if ($_SESSION['rank'] >= 7) { ?>
									<a title="<? echo $techmode; ?> la fonction de Technicien" href="index?p=perso&perso=<?php echo $perso; ?>&action=tech" style="color:aqua;">[T]</a> 
									<?php } 
									if ($_SESSION['rank'] >= 5 AND $_SESSION['rank'] > $line['rank'] AND $line['ban'] == 0) { ?>
									<a title="Bannir le compte" href="index?p=perso&perso=<?php echo $perso; ?>&action=ban" style="color:red;">[B]</a> 
									<?php }
									if ($_SESSION['rank'] >= 5 AND $_SESSION['rank'] > $line['rank'] AND $line['ban'] == 1) { ?>
									<a title="Supprimer le bannissement du compte" href="index?p=perso&perso=<?php echo $perso; ?>&action=pardon" style="color:green;">[P]</a>
									<?php } if ($_SESSION['name'] == "Eftarthadeth" OR $_SESSION['name'] == "Nikho") { 
									if ($line['removed'] == 0) {?>
									<a title="Supprimer le compte" href="index?p=perso&perso=<?php echo $perso; ?>&action=delete" style="color:red;">[X]</a>
									<?php } else { ?>
									<a title="Restaurer le compte" href="index?p=perso&perso=<?php echo $perso; ?>&action=restore" style="color:blue;">[X]</a> 
									<?php } } ?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td valign="top" width="50%" rowspan="3">
					<table cellspacing="5" cellpading="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td width="33%" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
								<td style="text-align:center;">
									<img src="pics/avatar/skin_<?= $line['id']?>.png" alt="" width="100" />
								</td>
								<td width="33%" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
							</tr>
							<tr>
								<td>
									Identité :
								</td>
								<td>
									<?= $line['name']?>
								</td>
								<td>
									<?= $line['nom']?>
								</td>
							</tr>
							<tr>
								
								<td>
									Race : <?= $line['race']?>
								</td>
								<td style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Elément primaire : <?= $line['specialisation']?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Elément secondaire : <?= $line['spe_2']?>
								</td>
							</tr>
							<tr>
								<td>
									Niveau magique :
								</td>
								<td style="text-align:center;" colspan="2">
									<?php if ($_SESSION['rank'] >= 5) { ?>
									 <a href="index?p=perso&perso=<? echo $perso;?>&action=magieup" title="Monter le niveau magique" style="color:green;">
									 	[UP]
									 </a>
									  <a href="index?p=perso&perso=<? echo $perso;?>&action=magiedown" title="Descendre le niveau magique" style="color:red;">
									 	[DOWN]
									 </a>
									 <?php } ?>
									 <img src="pics/magie_rank_<?= $line['magie_rank']?>.gif" alt="" /> <? echo $magie; ?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Qualités : <?= $line['qualite']?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Défauts : <?= $line['defauts']?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Caractère : <?= $line['caractere']?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Signes distinctifs : <?= $line['sd']?>
								</td>
							</tr>
							<tr>
								<td style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
								<td style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
								<td style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
							</tr>
							<?php if ($_SESSION['rank'] >= 5) { ?>
							<tr>
								<td colspan="3" style="border: 0px grey solid; background-color: grey; color: grey;">
									<a href="index?p=perso&perso=<?php echo $perso; ?>&modif=info">
										Modifier les informations
									</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td>
									Energie Magique
								</td>
								<td>
									Energie Vitale
								</td>
							</tr>
							<?php if ($_SESSION['rank'] >= 5) { ?>
							<tr>
								<td colspan="2" style="border: 0px grey solid; background-color: grey; color: grey;">
									<a href="index?p=perso&perso=<?php echo $perso; ?>&modif=magie">
										Modifier les informations
									</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</td>
			</tr>
			<?php if ($_SESSION['rank'] >= 5) { ?>
			<tr>
				<td>
					<table cellspacing="5" cellpading="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td width="50%">
									Pseudo Minecraft :
								</td>
								<td width="50%">
									<?= $line['Minecraft_Account'] ?>
								</td>
							</tr>
							<tr>
								<td>
									Invisibilité :
								</td>
								<td>
									<?php echo $vanish; ?>
								</td>
							</tr>
							<tr>
								<td>
									Date d'arrivée :
								</td>
								<td>
									<?= $line['registration_date'] ?>
								</td>
							</tr>
							<tr>
								<td>
									Adresse Mail :
								</td>
								<td>
									<?= $line['email']?>
								</td>
							</tr>
							<tr>
								<td>
									Note du Staff :
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p>
									<?php echo $notestaff ;?>
									</p>
								</td>
							</tr>
							<?php if ($_SESSION['rank'] >= 5) { ?>
							<tr>
								<td colspan="2" style="border: 0px grey solid; background-color: grey; color: grey;">
									<a href="index?p=perso&perso=<?php echo $perso; ?>&modif=admin">
										Modifier les informations
									</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td valign="top">
					<table cellspacing="0" cellpadding="0" width="100%">
						<tbody>
							<tr>
								<td width="50px">
									<img alt=" " src="/pics/ico/magiepapertop.png">
								</td>
							</tr>
							<tr>
								<td>
									<table width="640px" background="/pics/ico/magiepapercenter.png">
										<tr>
											<td>
												<p style="padding:4%;">
													<? echo $bg; ?>
												</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="50px">
									<img alt="" src="/pics/ico/magiepapebottom.png">
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td valign="top">
					<table cellspacing="0" cellpadding="0" width="100%" >
						<tbody>
							<tr>
								<td width="50px">
									<img alt=" " src="/pics/ico/magiepapertop.png">
								</td>
							</tr>
							<tr>
								<td>
									<table width="640px" background="/pics/ico/magiepapercenter.png">
										<tr>
											<td>
												<p style="padding:4%;">
													<? echo $hrp; ?>
												</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="50px">
									<img alt="" src="/pics/ico/magiepapebottom.png">
								</td>
							</tr>
							
						</tbody>
					</table>
			</tr>
			<?php if ($_SESSION['rank'] >= 5) { ?>
			<tr>
				<td>
					<p> </p>
				</td>
				<td valign="top">
					<table cellspacing="0" cellpadding="0" width="100%" >
						<tbody>
							<tr>
								<td width="50px">
									<img alt=" " src="/pics/ico/notespersotop.png">
								</td>
							</tr>
							<tr>
								<td>
									<table width="640px" background="/pics/ico/notespersocenter.png">
										<tr>
											<td>
												<p style="padding:4%;">
													<? echo $notes; ?>
												</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="50px">
									<img alt="" src="/pics/ico/notespersobottom.png">
								</td>
							</tr>
							
						</tbody>
					</table>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php
	}
		}
	}
	else
	{
	?>
	<h2>Mon personnage</h2>
	<?php
		$perso = $db->prepare('SELECT * FROM members WHERE id= ?');
		$perso->execute(array($_SESSION['id']));
	if (isset($_GET['modif']))
		{
			if ($line = $perso->fetch())
			{
			if ($_GET['modif'] == "bg")
			{
			?>
			<h3>Edition du BackGround Roleplay</h3>
			<form action='index?p=perso' method="POST">
				<textarea name="editbg"><?= $line['background']?></textarea>
				<input type="submit" name=save_bg value="Terminer" />
			</form>
			<?php
			}
			elseif ($_GET['modif'] == "notesp")
			{
			?>
			<h3>Edition des Notes Personnelles</h3>
			<form action='index?p=perso' method="POST">
				<textarea name="editnotes"><?= $line['notes_perso'] ?></textarea>
				<input type="submit" name=save_notes value="Terminer" />
			</form>
			<?php	
			}
			elseif ($_GET['modif'] == "jdesc")
			{
			?>
			<h3>Edition de la Description du Joueur</h3>
			<form action='index?p=perso' method="POST">
				<textarea name="edithrp"><?= $line['bg_hrp'] ?></textarea>
				<input type="submit" name=save_hrp value="Terminer" />
			</form>
			<?php	
			}
			else { echo '<p>Tu n\'essaieraies pas de chercher là où tu ne devrais pas aller ? :P</p>'; }
		}
		}
	else
		{
		if (isset($_POST['save_bg'])) {
			$editbg = (htmlentities($_POST['editbg']));
			$update = $db->prepare('UPDATE members SET background = ? WHERE id = ?');
			$update->execute(array($editbg, $_SESSION['id']));
		}
		if (isset($_POST['save_notes'])) {
			$editnotes = (htmlentities($_POST['editnotes']));
			$update = $db->prepare('UPDATE members SET notes_perso = ? WHERE id = ?');
			$update->execute(array($editnotes, $_SESSION['id']));
		}
		if (isset($_POST['save_hrp'])) {
			$edithrp = (htmlentities($_POST['edithrp']));
			$update = $db->prepare('UPDATE members SET bg_hrp = ? WHERE id = ?');
			$update->execute(array($edithrp, $_SESSION['id']));
		}
		if ($line = $perso->fetch()) {
		$magieok = 'Non acquise';
		if ($line['magieok'] == 1) { $magietest = true; }
		if ($magietest) { $magieok = 'Acquise'; }
		$bg = preg_replace('#\n#', '<br />', $line['background']);
		$bg = ($bg != 'none') ? $bg : 'En attente ...';
		$notestaff = preg_replace('#\n#', '<br />', $line['staffnote']);
		$notestaff = ($notestaff != 'none') ? $notestaff : 'En attente ...';
		$hrp = preg_replace('#\n#', '<br />', $line['bg_hrp']);
		$hrp = ($hrp != 'none') ? $hrp : 'En attente ...';
		$notes = preg_replace('#\n#', '<br />', $line['notes_perso']);
		$notes = ($notes != 'none') ? $notes : 'En attente ...';
		
		switch ($line['magie_rank']) {
			case 0: $magie = "Profane"; break;	case 1: $magie = "Adepte"; break;	case 2: $magie = "Apprenti Magicien"; break;
			case 3: $magie = "Magicien"; break;	case 4: $magie = "Mage"; break;		case 5: $magie = "Archimage"; break;
			case 6: $magie = "Sage"; break;		case 7: $magie = "Divin"; break;	case 8: $magie = "Titanèsque"; break;
			case 9: $magie = "Pouvoir Suprême"; break;
		}
		$vanish = ($line['invisible'] == 1) ? 'Activée' : 'Désactivée';
		$filename = 'pics/pnj/pnj_' .$line['id']. '.png';if (file_exists($filename)) {$img = $line['id'];} else {$img = 'no';}
	?>
	
	
	<table cellspacing="5" cellpadding="5">
		<tbody>
			<tr>
				<td valign="top" width="50%">
					<table cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td style="border-radius: 10px;" rowspan="4" width="200px">
									<img src="pics/persoimg/perso_<?= $line['id']?>.png" alt="" width="200px" />
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p>Nom : <?= $line['name']?></p>
								</td>
							</tr>
								
							<tr>
								<td colspan="2">
									<p>Magie : <? echo $magieok; ?></p>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p>Titre : <img src="pics/rank<?= $line['rank']?>.png" alt="" width="25" /> <?= $line['title']?></p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td valign="top" width="50%" rowspan="3">
					<table cellspacing="5" cellpading="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td width="33%" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
								<td style="text-align:center;">
									<img src="pics/avatar/skin_<?= $line['id']?>.png" alt="" width="100" />
								</td>
								<td width="33%" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
							</tr>
							<tr>
								<td>
									Identité :
								</td>
								<td>
									<?= $line['name']?>
								</td>
								<td>
									Nom
								</td>
							</tr>
							<tr>
								
								<td>
									Race : <?= $line['race']?>
								</td>
								<td style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Elément primaire : <?= $line['specialisation']?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Elément secondaire : <?= $line['spe_2']?>
								</td>
							</tr>
							<tr>
								<td>
									Niveau magique :
								</td>
								<td style="text-align:center;" colspan="2">
									 <img src="pics/magie_rank_<?= $line['magie_rank']?>.gif" alt="" /> <? echo $magie; ?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Qualités :
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Défauts :
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Caractère :
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Signes distinctifs :
								</td>
							</tr>
							<tr>
								<td style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
								<td style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
								<td style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td>
									Energie Magique
								</td>
								<td>
									Energie Vitale
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<?php if ($_SESSION['rank'] >= 5) { ?>
			<tr>
				<td>
					<table cellspacing="5" cellpading="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td width="50%">
									Pseudo Minecraft :
								</td>
								<td width="50%">
									<?= $line['Minecraft_Account'] ?>
								</td>
							</tr>
							<tr>
								<td>
									Invisibilité :
								</td>
								<td>
									<?php echo $vanish; ?>
								</td>
							</tr>
							<tr>
								<td>
									Date d'arrivée :
								</td>
								<td>
									<?= $line['registration_date'] ?>
								</td>
							</tr>
							<tr>
								<td>
									Adresse Mail :
								</td>
								<td>
									<?= $line['email']?>
								</td>
							</tr>
							<tr>
								<td>
									Note du Staff :
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p>
									<?php echo $notestaff ;?>
									</p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td valign="top">
					<table cellspacing="0" cellpadding="0" width="100%">
						<tbody>
							<tr>
								<td width="50px">
									<img alt=" " src="/pics/ico/magiepapertop.png">
								</td>
							</tr>
							<tr>
								<td>
									<table width="640px" background="/pics/ico/magiepapercenter.png">
										<tr>
											<td>
												<p style="padding:4%;">
													<? echo $bg; ?>
													<br /><br />
													<a href="index?p=perso&modif=bg">
														Modifier votre Background.
													</a>
												</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="50px">
									<img alt="" src="/pics/ico/magiepapebottom.png">
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td valign="top">
					<table cellspacing="0" cellpadding="0" width="100%" >
						<tbody>
							<tr>
								<td width="50px">
									<img alt=" " src="/pics/ico/magiepapertop.png">
								</td>
							</tr>
							<tr>
								<td>
									<table width="640px" background="/pics/ico/magiepapercenter.png">
										<tr>
											<td>
												<p style="padding:4%;">
													<? echo $hrp; ?>
													<br /><br />
													<a href="index?p=perso&modif=jdesc">
														Modifier votre Background.
													</a>
												</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="50px">
									<img alt="" src="/pics/ico/magiepapebottom.png">
								</td>
							</tr>
							
						</tbody>
					</table>
			</tr>
			<tr>
				<td>
					<p> </p>
				</td>
				<td valign="top">
					<table cellspacing="0" cellpadding="0" width="100%" >
						<tbody>
							<tr>
								<td width="50px">
									<img alt=" " src="/pics/ico/notespersotop.png">
								</td>
							</tr>
							<tr>
								<td>
									<table width="640px" background="/pics/ico/notespersocenter.png">
										<tr>
											<td>
												<p style="padding:4%;">
													<? echo $notes; ?>
													<br /><br />
													<a href="index?p=perso&modif=notesp">
														Modifier votre Background.
													</a>
												</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="50px">
									<img alt="" src="/pics/ico/notespersobottom.png">
								</td>
							</tr>
							
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	}
	
	}
	
	
}
?>
