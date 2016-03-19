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
							$prenom = $line['name']; $nom = "?"; $qualite = "?"; $title = $line['title'];
							$defauts = "?"; $sd = "Non définis"; $caractere = "?";
							switch ($_POST['race']) {
								case 0 : $race = $line['race']; break; case 1: $race = "Elfe"; break; case 1: $race = "Elfe"; break; case 2: $race = "Ernelien"; break;
								case 3: $race = "Humain"; break; case 4: $race = "Hybride"; break; case 5: $race = "Inconnue"; break; case 6: $race = "Nain"; break;
								case 7: $race = "Onyx"; break; case 8: $race = "Orque"; break; case 9: $race = "Spéciale"; break; case 10: $race = "Stromnole"; break;
								case 11: $race = "Titanoïde"; break; case 12: $race = "Zaknafein"; break;}
							
							if (!empty($_POST['titre'])) { $title = htmlentities($_POST['titre']); }
							if (!empty($_POST['prenom'])) { $prenom = htmlentities($_POST['prenom']); }
							if (!empty($_POST['nom'])) { $nom = htmlentities($_POST['nom']); }
							if (!empty($_POST['qualite'])) { $qualite = htmlentities($_POST['qualite']); }
							if (!empty($_POST['defauts'])) { $defauts = htmlentities($_POST['defauts']); }
							if (!empty($_POST['sd'])) { $sd = htmlentities($_POST['sd']); }
							if (!empty($_POST['caractere'])) { $caractere = htmlentities($_POST['caractere']); }
							$update = $db->prepare('UPDATE members SET name = ?, nom = ?, race = ?, title = ?, qualites = ?, defauts = ?, sd = ?, caractere = ? WHERE id = ?');
							$update->execute(array($prenom, $nom, $race, $title, $qualite, $defauts, $sd, $caractere, $perso));
							echo '<p>Modifications des informations personnelles effectuées avec succès</p>';
								?>
								<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
								<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
								<?php
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
								?>
								<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
								<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
								<?php
							}
							else { echo '<p>Tara tata ta ! On force pas le système ici !</p>'; }
						}
						elseif(isset($_POST['valid']))
						{
							if ($_SESSION['rank'] >= 5) {
								switch ($_POST['spe_1']) {
									case 0: $spe_1 = $line['specialisation']; break; case 1 : $spe_1 = "Air"; break;
									case 2 : $spe_1 = "Arcane"; break; case 3 : $spe_1 = "Chaos"; break; case 4 : $spe_1 = "Eau"; break;
									case 5 : $spe_1 = "Energie"; break; case 6 : $spe_1 = "Feu"; break; case 7 : $spe_1 = "Glace"; break;
									case 8 : $spe_1 = "Inconnue"; break; case 9 : $spe_1 = "Lumière"; break; case 10 : $spe_1 = "Métal"; break;
									case 11 : $spe_1 = "Nature"; break; case 12 : $spe_1 = "Ombre"; break; case 13 : $spe_1 = "Psy"; break;
									case 14 : $spe_1 = "Spécial"; break; case 15 : $spe_1 = "Terre"; break;
								}
								switch ($_POST['spe_2']) {
									case 0: $spe_2 = $line['spe_2']; break; case 1 : $spe_2 = "Air"; break;
									case 2 : $spe_2 = "Arcane"; break; case 3 : $spe_2 = "Chaos"; break; case 4 : $spe_2 = "Eau"; break;
									case 5 : $spe_2 = "Energie"; break; case 6 : $spe_2 = "Feu"; break; case 7 : $spe_2 = "Glace"; break;
									case 8 : $spe_2 = "Inconnue"; break; case 9 : $spe_2 = "Lumière"; break; case 10 : $spe_2 = "Métal"; break;
									case 11 : $spe_2 = "Nature"; break; case 12 : $spe_2 = "Ombre"; break; case 13 : $spe_2 = "Psy"; break;
									case 14 : $spe_2 = "Spécial"; break; case 15 : $spe_2 = "Terre"; break;
								}
								$update = $db->prepare('UPDATE members SET E_Magique = ?, E_Vitale = ?, specialisation = ?, spe_2 = ? WHERE id = ?');
								$update->execute(array($_POST['e-magie'], $_POST['e-vie'], $spe_1, $spe_2, $perso));
								echo '<p>Modifications des informations magiques effectuées avec succès</p>';
								?>
								<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
								<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
								<?php
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
										<label>Race :</label>
											<select name="race" type="text">
												<option value="0">--Option par défaut--</option>
												<option value="1">Elfe</option>
												<option value="2">Ernelien</option>
												<option value="3">Humain</option>
												<option value="4">Hybride (Animal)</option>
												<option value="5">Inconnue</option>
												<option value="6">Nain</option>
												<option value="7">Onyx</option>
												<option value="8">Orque</option>
												<option value="9">Spécial</option>
												<option value="10">Stromnole</option>
												<option value="11">Titanoide</option>
												<option value="12">Zaknafein</option>
											</select>
									</td>
									<td>
										<label>Titre :</label> <input type="text" name="titre" value="<?= $line['title']?>" />
									</td>
								</tr>
								<tr>
									<td>
										Personalité :
									</td>
									<td>
										<label for="qualite">Qualité :</label>  <textarea id="qualite" name="qualite"><?= $line['qualites']?></textarea>
									</td>
									<td>
										<label for="defauts">Défauts :</label> <textarea id="defauts" name="defauts"><?= $line['defauts']?></textarea>
									</td>
									<td>
										<label for="sd">Signes Distinctifs :</label> <textarea id="sd" name="sd"><?= $line['sd']?></textarea>
									</td>
									<td>
										<label for="caractere">Caractère :</label> <textarea id="caractere" name="caractere"><?= $line['caractere']?></textarea>
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
										<label for="spe_1">Spécialisation primaire :</label>
											<select name="spe_1" type="text">
												<option value="0">--Option par défaut--</option>
												<option value="1">Air</option>
												<option value="2">Arcane</option>
												<option value="3">Chaos</option>
												<option value="4">Eau</option>
												<option value="5">Energie</option>
												<option value="6">Feu</option>
												<option value="7">Glace</option>
												<option value="8">Inconnue</option>
												<option value="9">Lumière</option>
												<option value="10">Métal</option>
												<option value="11">Nature</option>
												<option value="12">Ombre</option>
												<option value="13">Psy</option>
												<option value="14">Spécial</option>
												<option value="15">Terre</option>
											</select>
									</td>
									<td>
										<label for=""race"spe_2">Spécialisation secondaire :</label>
											<select name="spe_2" type="text">
												<option value="0">--Option par défaut--</option>
												<option value="1">Air</option>
												<option value="2">Arcane</option>
												<option value="3">Chaos</option>
												<option value="4">Eau</option>
												<option value="5">Energie</option>
												<option value="6">Feu</option>
												<option value="7">Glace</option>
												<option value="8">Inconnue</option>
												<option value="9">Lumière</option>
												<option value="10">Métal</option>
												<option value="11">Nature</option>
												<option value="12">Ombre</option>
												<option value="13">Psy</option>
												<option value="14">Spécial</option>
												<option value="15">Terre</option>
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
					if ($line['rank'] < 10) {
				$update = $db->prepare('UPDATE members SET rank = ? WHERE id = ?');
				$update->execute(array( $line['rank'] +1, $perso));
				$nom = $line['name'];
				$msg = "Félicitations à $nom pour sa montée en grade !";
				$shirka = $db->prepare("INSERT INTO chatbox VALUES('', NOW(), 92, 0, '', ?)");
				$shirka->execute(array($msg));
				$add = $db->prepare('INSERT INTO hist_grada (upper_id, method, upped_id, up_date) VALUES (?, 1, ?, NOW() )');
				$add->execute(array($_SESSION['id'], $perso));
				echo '<p>Le personnage a bien été promu.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php	
					}
				else { echo '<p>Tu veux monter en grade un joueur au-dessus des limites, fuat arrêter de rêver un jour ! :D</p>'; }
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'downgrade')
			{
				if ($_SESSION['rank'] >= 5) {
					if ($line['rank'] > 1) {
				$update = $db->prepare('UPDATE members SET rank = ? WHERE id = ?');
				$update->execute(array( $line['rank'] -1, $perso));
				$add = $db->prepare('INSERT INTO hist_grada (upper_id, method, upped_id, up_date) VALUES (?, 0, ?, NOW() )');
				$add->execute(array($_SESSION['id'], $perso));
				echo '<p>Le personnage a bien été dégradé.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Tu veux dégrader un joueur en-dessous des limites, fuat arrêter de rêver un jour ! :D</p>'; }
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'dignitaire')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET rank = ?, dignitaire = 1 WHERE id = ?');
				$update->execute(array( $line['rank'] -1, $perso));
				$add = $db->prepare('INSERT INTO hist_grada (upper_id, method, upped_id, up_date) VALUES (?, 0, ?, NOW() )');
				$add->execute(array($_SESSION['id'], $perso));
				echo '<p>Le personnage a bien été dégradé.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'return')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET rank = ?, dignitaire = 0 WHERE id = ?');
				$update->execute(array( $line['rank'] +1, $perso));
				$nom = $line['name'];
				$msg = "Félicitations à $nom pour sa montée en grade !";
				$shirka = $db->prepare("INSERT INTO chatbox VALUES('', NOW(), 92, 0, '', ?)");
				$shirka->execute(array($msg));
				$add = $db->prepare('INSERT INTO hist_grada (upper_id, method, upped_id, up_date) VALUES (?, 1, ?, NOW() )');
				$add->execute(array($_SESSION['id'], $perso));
				echo '<p>Le personnage a bien été promu.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'end')
			{
				if ($_SESSION['rank'] >= 5) {
					$update = $db->prepare('UPDATE members SET rank = 8, magie_rank = 6 WHERE id = ?');
					$update->execute(array($perso));
					echo '<p>Le personnage a fini le jeu.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'avert')
			{
				if ($_SESSION['rank'] >= 5) {
				echo '<p>Fonction en cours de développment.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'tech')
			{
				if ($_SESSION['rank'] >= 5) {
					if ($line['technician'] == 0) {
				$update = $db->prepare('UPDATE members SET technician = 1 WHERE id = ?');
				$update->execute(array($perso));
				echo '<p>Attribution des pouvoirs de techniciens effectuée !</p>'; }
				else {
				$update = $db->prepare('UPDATE members SET technician = 0 WHERE id = ?');
				$update->execute(array($perso));
				echo '<p>Retrait des pouvoirs de techniciens effectuée !</p>'; }
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'ban')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET ban = 1 WHERE id= ?');
				$update->execute(array($perso));
				echo '<p>Joueur banni.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'magieok')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET magieok = 1 WHERE id= ?');
				$update->execute(array($perso));
				echo '<p>Magie maitrisée.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'magieko')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET magieok = 0 WHERE id= ?');
				$update->execute(array($perso));
				echo '<p>Magie perdue.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'pardon')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET ban = 0 WHERE id= ?');
				$update->execute(array($perso));
				echo '<p>Joueur débanni.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'delete')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET removed = 1 WHERE id= ?');
				$update->execute(array($perso));
				echo '<p>Compte supprimé.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'restore')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET removed = 0 WHERE id= ?');
				$update->execute(array($perso));
				echo '<p>Compte restauré.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'magieup')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET magie_rank = ? WHERE id = ?');
				$update->execute(array( $line['magie_rank'] +1, $perso));
				$nom = $line['name'];
				$msg = "Tuduung~~ ! $nom gagne un niveau !";
				$shirka = $db->prepare("INSERT INTO chatbox VALUES('', NOW(), 92, 0, '', ?)");
				$shirka->execute(array($msg));
				echo "<p>Le personnage gagne un niveau !</p>";
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'magiedown')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET magie_rank = ? WHERE id = ?');
				$update->execute(array( $line['magie_rank'] -1, $perso));
				echo "<p>Le personnage perd un niveau !</p>";
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'vanishoff')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET invisible = 0 WHERE id = ?');
				$update->execute(array($perso));
				echo '<p>Personnage apparent ausur le listing !</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif($_GET['action'] == 'vanishon')
			{
				if ($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET invisible = 0 WHERE id = ?');
				$update->execute(array($perso));
				echo '<p>Personnage masqué du listing.</p>';
				?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif ($_GET['action'] == "validbg")
			{
				if($_SESSION['rank'] >= 5) {
				$update = $db->prepare('UPDATE members SET valid_bg = 0, valider_id = ? WHERE id = ?');
				$update->execute(array($_SESSION['id'], $perso));
				echo '<p>BackGround RolePlay validé !</p>';?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
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
		$filename = 'pics/persoimg/perso_' .$line['id']. '.png';if (file_exists($filename)) {$img = $line['id'];} else {$img = 'no';}
		$filename = 'pics/avatar/skin_' .$line['id']. '.png';if (file_exists($filename)) {$avatar = $line['id'];} else {$avatar = 'no';}
		if ($line['technician'] == 0 AND $line['removed'] == 0 AND $line['ban'] == 0 AND $line['rank'] < 9) { $grade = $line['rank']; }
		if ($line['rank'] == 9) { $grade = "titan";} if ($line['rank'] == 10) { $grade = "crea"; }
		if ($line['technician'] == 1) { $tech = "-T"; $techmode = "Retirer"; $grade = "tech"; } else { $techmode = "Attribuer";}  if ($line['pionier'] == 1) { $pionier = '-P'; }
		if ($line['ban'] == 1) { $grade = "ban";} if ($line['removed'] == 1) { $grade = "del";}
		if ($line['pionier'] == 1) { $title = "Pionier"; } else { $title = $line['title']; }
	?>
	<h2 class="name<?= $line['rank']?><?php echo $tech; echo $pionier;?>"><?php echo $title;?> <?= $line['name']?></h2>
	
	<table cellspacing="5" cellpadding="5">
		<tbody>
			<tr>
				<td valign="top" width="50%">
					<table cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td style="border-radius: 10px;" rowspan="4" width="200px">
									<img src="pics/persoimg/perso_<?php echo $img; ?>.png" alt="" width="200px" />
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
									<p>Titre : <img src="pics/rank<?php echo $grade;?>.png" alt="" width="25" /> <?php echo $title;?></p>
								</td>
							</tr>
							<tr>
								<td colspan="4" style="border: 0px grey solid; background-color: grey; color: grey; text-align:justify;">
									<?php if ($line['rank'] == 2 OR $line['rank'] == 3) { if($_SESSION['rank'] > $line['rank']+1) { ?>
									<a title="Monter le joueur en grade" href="index?p=perso&perso=<?php echo $perso; ?>&action=upgrade" style="color:lime;">[+]</a>	
									<?php } } 
									elseif ($line['rank'] >= 4 AND $line['rank'] <= 10 AND $line['valid_bg'] == 1 AND $_SESSION['rank'] > $line['rank']+1) {?>
									<a title="Monter le joueur en grade" href="index?p=perso&perso=<?php echo $perso; ?>&action=upgrade" style="color:lime;">[+]</a>
									<?php } 
									if ($_SESSION['rank'] > $line['rank'] AND $line['rank'] > 2 AND $_SESSION['rank'] >= 5) { ?>
									<a title="Dégrader le joueur" href="index?p=perso&perso=<?php echo $perso; ?>&action=downgrade" style="color:red;">[-]</a>
									<?php } 
									if ($_SESSION['rank'] > $line['rank'] AND $line['rank'] >= 5 AND $line['dignitaire'] == 0) { ?>
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
									<a title="Supprimer le bannissement du compte" href="index?p=perso&perso=<?php echo $perso; ?>&action=pardon" style="color:lime;">[P]</a>
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
									<img src="pics/avatar/skin_<?php echo $avatar;?>.png" alt="" width="100" />
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
									Elément primaire : <img src="pics/magie/Magie_<?= $line['specialisation']?>.png" alt="" class="magie" width="25px" /> <?= $line['specialisation']?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Elément secondaire : <img src="pics/magie/Magie_<?= $line['spe_2']?>.png" alt="" class="magie" width="25px" /> <?= $line['spe_2']?>
								</td>
							</tr>
							<tr>
								<td>
									Niveau magique :
								</td>
								<td style="text-align:center;" colspan="2">
									<?php if ($_SESSION['rank'] >= 5) { 
									if ($line['magie_rank'] >= 0 AND $line['magie_rank'] < 8 ) { ?>
									 <a href="index?p=perso&perso=<? echo $perso;?>&action=magieup" title="Monter le niveau magique" style="color:green;">
									 	[UP]
									 </a>
									 <?php }
									 if ($line['magie_rank'] > 1 AND $line['magie_rank'] < 9 ) { ?>
									  <a href="index?p=perso&perso=<? echo $perso;?>&action=magiedown" title="Descendre le niveau magique" style="color:red;">
									 	[DOWN]
									 </a>
									 <?php } } ?>
									 <img src="pics/magie_rank_<?= $line['magie_rank']?>.gif" alt="" /> <? echo $magie; ?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Qualités : <?= $line['qualites']?>
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
										[Modifier les informations]
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
										[Modifier les informations]
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
									<?php echo $vanish; ?> <?php if ($line['invisible'] == 1) { ?><a href="index?p=perso&action=vanishoff" title="Désactiver l'invisibilité du compte" style="color:red;">[OFF]</a><?php } else {
										?><a href="index?p=perso&action=vanishon" title="Activer l'invisibilité du compte" style="color:green;">[ON]</a><?php } ?>
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
										[Modifier les informations]
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
				<td valign="top" rowspan="1">
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
												<p style="padding-left:10%; padding-right:10%;">
												<?php if ($line['valid_bg'] == 1) { ?>
												<img src="pics/ico/tick.png" alt="" class="validbg" width="100" title="Background Roleplay vérifié par le Staff" />
												<?php } ?>
													<? echo $bg; ?>
												</p>
												<?php if ($_SESSION['rank'] >= 5 AND $line['valid_bg'] == 0) { ?>
												<p style="padding-left:10%; padding-right:10%;">
													<a href="index?p=perso&perso=<?php echo $perso;?>&action=validbg" style="color:red;">
														[Valider le BG]
													</a>
												</p>
												<?php } ?>
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
												<p style="padding-left:10%; padding-right:10%;">
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
												<p style="padding-left:10%; padding-right:10%;">
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
	elseif (isset($_GET['edit']))
		{
			if ($_GET['edit'] == "race")
			{
			?>
			<h3>Changement de race</h3>
			<?php
				if (isset($_GET['r'])) 
				{
					if ($_GET['r'] == "elfe")
					{
					?>
						<h3>Les Elfes</h3>
						<p>Similaires aux humains, les Elfes se caractérisent par leurs oreilles plus grandes que les oreilles humaines et leur rapport très proche envers la nature, qui est très souvent leur habitat naturel.</p>
						<p>
							<a href="index?p=perso&edit=race&choose=elfe">
								[Choisir cette race.]
							</a>
						</p>
					<?php
					}
					elseif ($_GET['r'] == "ernelien")
					{
					?>
						<h3>Les Erneliens</h3>
						<p>Peu de choses sont connus des humains sur cette race bien étrange, mais pourtant l'esclavagisme est omniprésent, même en Nix. Les Erneliens sont une étranges communautés, Ils sont vert et ont une peau rigide, qui est semblable à des os, 
						ils ont des os qui sortent de leurs coudes, de leurs genoux, ils ont des longues griffes, des dents acérés, et même des cornes, mais malheureusement, leurs corps est trop fragiles pour se battre, ils ne supportent pas les trops grosses température, 
						ni les trop basses, ils ne peuvent supporter les endroits secs, et ont en plus un besoin d'humidité pour respirer et pour que la peau ne dessèche pas.</p>
						<p>
							<a href="index?p=perso&edit=race&choose=ernelien">
								[Choisir cette race.]
							</a>
						</p>
					<?php	
					}
					elseif ($_GET['r'] == "humain")
					{
					?>
						<h3>Les Humains</h3>
						<p>Très généralement remortels, les humains sont des personnes constituées d'os, de muscle, d'organes et de peau. Ils vivent généralement en communauté pour mieux survivre et savent s'adapter aux intempéries. 
						Malgré le fait qu'ils soient une même race, plusieurs peuples aux coutumes différentes existent.</p>
						<p>
							<a href="index?p=perso&edit=race&choose=humain">
								[Choisir cette race.]
							</a>
						</p>
					<?php	
					}
					elseif ($_GET['r'] == "nain")
					{
					?>
						<h3>Les Nains</h3>
						<p>Ces êtres sont un quart de fois plus petits que les hommes normaux. Ils sont généralement installés dans la région des Feldspaths, car les cavernes leurs ont permis de faire un tas de mine, et leur marché de forge prospère chez les autres races.</p>
						<p>
							<a href="index?p=perso&edit=race&choose=nain">
								[Choisir cette race.]
							</a>
						</p>
					<?php	
					}
					elseif ($_GET['r'] == "onyx")
					{
					?>
						<h3>Les Onyxs</h3>
						<p>Race très peu connues, étant donné la rareté de ces personnes qui naissent du Ciel. Les Onyx sont semblables aux humains sauf qu'au lieu d'avoir un nez, ils respirent par les pores de leur peau, qui est aussi noire que leurs yeux sont luisants. 
						Les Onyx sont très généralement des personnes pacifiques et peu violentes, ce qui est surtout dû à leurs faible constitution, les rendant plus fragiles que des humains.</p>
						<p>
							<a href="index?p=perso&edit=race&choose=onyx">
								[Choisir cette race.]
							</a>
						</p>
					<?php	
					}
					elseif ($_GET['r'] == "orque")
					{
					?>
						<h3>Les Orques</h3>
						<p>Les Orques vivent reclus dans Orsiclame, une région fermés et dictatoriale, et ne veulent pas conquérir le monde. Ils protègent quelque chose qu'ils gardent jalousement,
						mais il reste encore à découvrir quoi car ces guerriers redoutables ne laisseront personne entrer.</p>
						<p>
							<a href="index?p=perso&edit=race&choose=orque">
								[Choisir cette race.]
							</a>
						</p>
					<?php	
					}
					elseif ($_GET['r'] == "stromnole")
					{
					?>
						<h3>Les Stromnoles</h3>
						<p>Une contrée mystérieuse et inhabitée s'est reveillé. Il s'agit du Volcan Stromnoli longtemps endormi, qui laissa il y a cent ans de cela, une grosse éruption, agrandissant ses contours de par le magma, et créant même des petites îles. 
						Mais ce qui est le plus remarquable c'est surtout les Stronnoles. Des créatures humanoïdes rouges, semblant résister à la lave et à la chaleur. Elles ont fait surfaces après l'éruption du Stromnoli, beaucoup étudient cette race jusque là inconnues. 
						Il faudra faire des recherches pour en savoir plus sur cette race extrêmement discrète.</p>
						<p>
							<a href="index?p=perso&edit=race&choose=stromnole">
								[Choisir cette race.]
							</a>
						</p>
					<?php	
					}
					else
					{
						echo '<p>Non non non. Il n\'y a rien à voir ici. :P</p>';
					}
				}
				elseif ($_GET['choose'])
					{
						if($_GET['choose'] == "elfe")
						{
							$update = $db->prepare('UPDATE members SET race = "Elfe" WHERE id = ?');
							$update->execute(array($_SESSION['id']));
						?>
						<p>Race définie ! <a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
						<?php
						}
						elseif($_GET['choose'] == "ernelien")
						{
							$update = $db->prepare('UPDATE members SET race = "Ernelien" WHERE id = ?');
							$update->execute(array($_SESSION['id']));
						?>
						<p>Race définie ! <a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
						<?php	
						}
						elseif($_GET['choose'] == "humain")
						{
							$update = $db->prepare('UPDATE members SET race = "Humain" WHERE id = ?');
							$update->execute(array($_SESSION['id']));
						?>
						<p>Race définie ! <a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
						<?php	
						}
						elseif($_GET['choose'] == "nain")
						{
							$update = $db->prepare('UPDATE members SET race = "Nain" WHERE id = ?');
							$update->execute(array($_SESSION['id']));
						?>
						<p>Race définie ! <a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
						<?php	
						}
						elseif($_GET['choose'] == "onyx")
						{
							$update = $db->prepare('UPDATE members SET race = "Onyx" WHERE id = ?');
							$update->execute(array($_SESSION['id']));
						?>
						<p>Race définie ! <a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
						<?php	
						}
						elseif($_GET['choose'] == "orque")
						{
							$update = $db->prepare('UPDATE members SET race = "Orque" WHERE id = ?');
							$update->execute(array($_SESSION['id']));
						?>
						<p>Race définie ! <a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
						<?php	
						}
						elseif($_GET['choose'] == "stromnole")
						{
							$update = $db->prepare('UPDATE members SET race = "Stromnole" WHERE id = ?');
							$update->execute(array($_SESSION['id']));
						?>
						<p>Race définie ! <a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
						<?php	
						}
						else
						{
							echo '<p>Ehm... Non, c\'est pas par là la création de race ! :)</p>';
						}
					}
				else
				{
			?>
				<p>Cliquez sur l'une des images disponibles pour afficher la description dela race.</p>
					<table width="100%">
						<tbody>
							<tr>
								<th>Elfe</th>
								<th>Ernelien</th>
								<th>Humain</th>
								<th>Nain</th>
								<th>Onyx</th>
								<th>Orque</th>
								<th>Stromnole</th>
							</tr>
							<tr>
								<td>
									<a href="index?p=perso&edit=race&r=elfe">
										<img src="pics/img_Elfe.png" alt="" width="150px" title="Cliquez pour voir les informations." />
									</a>
								</td>
								<td>
									<a href="index?p=perso&edit=race&r=ernelien">
										<img src="pics/img_Ernelien.png" alt="" width="150px" title="Cliquez pour voir les informations." />
									</a>
								</td>									
								<td>
									<a href="index?p=perso&edit=race&r=humain">
										<img src="pics/img_Humain.png" alt="" width="150px" title="Cliquez pour voir les informations." />
									</a>
								</td>										
								<td>
									<a href="index?p=perso&edit=race&r=nain">
										<img src="pics/img_Nain.png" alt="" width="150px" title="Cliquez pour voir les informations." />
									</a>
								</td>
								<td>										
									<a href="index?p=perso&edit=race&r=onyx">
										<img src="pics/img_Onyx.png" alt="" width="150px" title="Cliquez pour voir les informations." />
									</a>
								</td>
								<td>
									<a href="index?p=perso&edit=race&r=orque">
										<img src="pics/img_Orque.png" alt="" width="150px" title="Cliquez pour voir les informations." />
									</a>
								</td>
								<td>
									<a href="index?p=perso&edit=race&r=stromnole">
									<img src="pics/img_Stromnole.png" alt="" width="150px" title="Cliquez pour voir les informations." />
								</a>
								</td>
							</tr>
						</tbody>
					</table>
							
				
			<?php	}
			}
			elseif ($_GET['edit'] == "infos")
			{
				$perso = $db->prepare('SELECT * FROM members WHERE id= ?');
				$perso->execute(array($_SESSION['id']));
				if ($line = $perso->fetch()) {
			?>
			<form action="index?p=perso&edit=save" method="POST">
				<table cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
					<tbody>
						<tr>
							<td width="33%" style="border: 0px grey solid; background-color: grey; color: grey;">
								<p> </p>
							</td>
							<td colspan="2">
								<label>Nom :</label> <input type="text" name="nom" value="<?= $line['nom']?>" />
							</td>
						</tr>
						<tr>
							<td>
								<label for="qualite">Qualité :</label>  <textarea id="qualite" name="qualite"><?= $line['qualites']?></textarea>
							</td>
							<td>
								<label for="defauts">Défauts :</label> <textarea id="defauts" name="defauts"><?= $line['defauts']?></textarea>
							</td>
							<td>
								<label for="sd">Signes Distinctifs :</label> <textarea id="sd" name="sd"><?= $line['sd']?></textarea>
							</td>
							<td>
								<label for="caractere">Caractère :</label> <textarea id="caractere" name="caractere"><?= $line['caractere']?></textarea>
							</td>
						</tr>
					</tbody>
				</table>
				<input name="valider" type="submit" value="Terminer" />
			</form>
			<?php	} else { echo '<p>Une erreur s\'est produite.</p>'; }
			}
			elseif ($_GET['edit'] == "save")
			{
				if (isset($_POST['valider']))
				{
					$nom = "?"; $qualite = "?"; $defauts = "?"; $sd = "Non définis"; $caractere = "?";
					
					if (!empty($_POST['nom'])) { $nom = htmlentities($_POST['nom']); }
					if (!empty($_POST['qualite'])) { $qualite = htmlentities($_POST['qualite']); }
					if (!empty($_POST['defauts'])) { $defauts = htmlentities($_POST['defauts']); }
					if (!empty($_POST['sd'])) { $sd = htmlentities($_POST['sd']); }
					if (!empty($_POST['caractere'])) { $caractere = htmlentities($_POST['caractere']); }
					$update = $db->prepare('UPDATE members SET nom = ?, qualites = ?, defauts = ?, sd = ?, caractere = ? WHERE id = ?');
					$update->execute(array( $nom, $qualite, $defauts, $sd, $caractere, $_SESSION['id']));
					echo '<p>Modifications effectuées avec succès</p>';
					?>
					<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
			<?php	
				} else { echo '<p>Il ma	nque pas des informations là ? Ou alors tu fouilles le site. :P</p>' ;}
			}
			else
			{
				echo '<p>Bien tenté, mais ici il n`\'y a rien à voir. :)</p>';
			}
		}
	else
		{
		if (isset($_POST['save_bg'])) {
			$editbg = (htmlentities($_POST['editbg']));
			$update = $db->prepare('UPDATE members SET background = ?, valid_bg = 0 WHERE id = ?');
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
		if ($line['technician'] == 1) { $grade = "tech"; }
		if ($line['ban'] == 1) { $grade = "ban";} if ($line['removed'] == 1) { $grade = "del";}
		if ($line['pionier'] == 1) { $title = "Pionier"; } else { $title = $line['title']; }
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
									<p>Titre : <img src="pics/rank<?php echo $grade;?>.png" alt="" width="25" /> <?php echo $title;?></p>
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
									Elément primaire : <img src="pics/magie/Magie_<?= $line['specialisation']?>.png" alt="" class="magie" width="25px" /> <?= $line['specialisation']?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Elément secondaire : <img src="pics/magie/Magie_<?= $line['spe_2']?>.png" alt="" class="magie" width="25px" /> <?= $line['spe_2']?>
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
									Qualités : <?= $line['qualites']?>
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
				<td valign="top" rowspan="1">
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
												<p style="padding-left:10%; padding-right:10%;">
													<?php if ($line['valid_bg'] == 1) { ?>
												<img src="pics/ico/tick.png" alt="" class="validbg" width="100" title="Background Roleplay vérifié par le Staff" />
													<?php } ?>
													<? echo $bg; ?>
													<br /><br />
													<a href="index?p=perso&modif=bg">
														[Modifier votre Background.]
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
												<p style="padding-left:10%; padding-right:10%;">
													<? echo $hrp; ?>
													<br /><br />
													<a href="index?p=perso&modif=jdesc">
														[Modifier votre description HRP.]
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
												<p style="padding-left:10%; padding-right:10%;">
													<? echo $notes; ?>
													<br /><br />
													<a href="index?p=perso&modif=notesp">
														[Modifier vos notes.]
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
			<?php
			
			switch ($line['race']) 
				{
				case "Elfe" : $titlerace = "Elfe"; $racedesc = "Similaires aux humains, les Elfes se caractérisent par leurs oreilles plus grandes que les oreilles humaines et leur rapport très proche envers la nature, qui est très souvent leur habitat naturel."; break;
				case "Ernelien": $titlerace = "Ernelien"; $racedesc = "Peu de choses sont connus des humains sur cette race bien étrange, mais pourtant l'esclavagisme est omniprésent, même en Nix. Les Erneliens sont une étranges communautés, Ils sont vert et ont une peau rigide, qui est semblable à des os, ils ont des os qui sortent de leurs coudes, de leurs genoux, ils ont des longues griffes, des dents acérés, et même des cornes, mais malheureusement, leurs corps est trop fragiles pour se battre, ils ne supportent pas les trops grosses température, ni les trop basses, ils ne peuvent supporter les endroits secs, et ont en plus un besoin d'humidité pour respirer et pour que la peau ne dessèche pas."; break;
				case "Humain" : $titlerace = "Humain"; $racedesc = "Très généralement remortels, les humains sont des personnes constituées d'os, de muscle, d'organes et de peau. Ils vivent généralement en communauté pour mieux survivre et savent s'adapter aux intempéries. Malgré le fait qu'ils soient une même race, plusieurs peuples aux coutumes différentes existent."; break;
				case "Nain": $titlerace = "Nain"; $racedesc = "Ces êtres sont un quart de fois plus petits que les hommes normaux. Ils sont généralement installés dans la région des Feldspaths, car les cavernes leurs ont permis de faire un tas de mine, et leur marché de forge prospère chez les autres races."; break;
				case "Onyx": $titlerace = "Onyx"; $racedesc = "Race très peu connues, étant donné la rareté de ces personnes qui naissent du Ciel. Les Onyx sont semblables aux humains sauf qu'au lieu d'avoir un nez, ils respirent par les pores de leur peau, qui est aussi noire que leurs yeux sont luisants. Les Onyx sont très généralement des personnes pacifiques et peu violentes, ce qui est surtout dû à leurs faible constitution, les rendant plus fragiles que des humains."; break;
				case "Orque": $titlerace = "Orque"; $racedesc = "Les Orques vivent reclus dans Orsiclame, une région fermés et dictatoriale, et ne veulent pas conquérir le monde. Ils protègent quelque chose qu'ils gardent jalousement, mais il reste encore à découvrir quoi car ces guerriers redoutables ne laisseront personne entrer."; break;
				case "Stromnole": $titlerace = "Stromnole"; $racedesc = "Une contrée mystérieuse et inhabitée s'est reveillé. Il s'agit du Volcan Stromnoli longtemps endormi, qui laissa il y a cent ans de cela, une grosse éruption, agrandissant ses contours de par le magma, et créant même des petites îles. Mais ce qui est le plus remarquable c'est surtout les Stronnoles. Des créatures humanoïdes rouges, semblant résister à la lave et à la chaleur. Elles ont fait surfaces après l'éruption du Stromnoli, beaucoup étudient cette race jusque là inconnues. Il faudra faire des recherches pour en savoir plus sur cette race extrêmement discrète."; break;
				case "Zaknafein" : $titlerace = "Zaknafein"; $racedesc = "Très semblables aux humains, les Zaknafeins sont des bipèdes humanoïdes avec une peau pâle et une sensibilité à la lumière bien supérieure aux Humains, ce qui rend leur évolution compliquée en lieu ensoleillé, personne n'est encore à ce jour capable de dire d'où une race telle que la leur trouve son origine."; break;
				case "Hybride" : $titlerace = "Hybride"; $racedesc = "Etrange spécimens que sont les Hybrides, comme leur nom l'indique, ils sont le resultat du mélange de deux espèces qui n'étaient pas fait pour se rencontrer, leur apparence peu des fois repousser. Ils conservent généralement les défauts et les qualités de leur race d'origine, mais ceci ne sera évidemment pas sans contre-coût !"; break;
				}
			?>
			<tr>
				<td colspan="2">
					<h3>La race de votre personnage :</h3>
					<?php if ($line['race'] == "Inconnue") {
					?>
					<p>Vous n'avez pas encore choisi de race. Rendez-vous <a href="index?p=perso&edit=race">ici</a> pour en choisir une !</p>
					<?php
					}
					elseif ($line['race'] == "Spéciale")
					{
					?>
						<p>Vous possédez une race hors catégorie, vous ne possez donc aucune information la concernant hors mis celles qui vous ont été confirmées par un Maitre du Jeu.</p>
					<?php
					}
					else
					{
					?>
					<h4><?php echo $titlerace; ?></h4>
					<table cellspacing="5">
						<tbody>
							<tr>
								<td>
									<img src="pics/img_<?= $line['race']?>.png" alt="" style="float:left;" />
								</td>
								<td>
									<p><?php echo $racedesc; ?></p>
									<p>
										<a href="index?p=perso&edit=race">Cliquez ici</a> pour changer de race.
									</p>
								</td>
							</tr>
						</tbody>
					</table>
					<?php } ?>
				</td>
			</tr>
			<?php if ($line['valid_bg'] == 1) {
				
				$valider = $db->prepare('SELECT name, id, title FROM members WHERE id = ?');
				$valider->execute(array($line['valider_id']));
				if ($bgline = $valider->fetch())
				{
				?>
			<tr>
				<td colspan="2">
					<h3>Validation du Background</h3>
					<p style="color:red; font-style: bold;">
						Votre background porte actuellement la validation de <?= $bgline['title']?> <?=$bgline['name']?>, si vous le modifiez, il perdra sa validité.<br />
						Il faudra donc le faire vérifier à nouveau par un Maître du Jeu.
					</p>
				</td>
			</tr>
			<?php } } 
			?>
			<tr>
				<td colspan="3">
					<h3>Progression</h3> 
					<p>Un schéma de votre progression possible au sein du serveur sera bientôt disponible.</p>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<h3>Vos informations personnelles RP</h3>
					<p><a href="index?p=perso&edit=infos">Cliquez ici</a> pour éditer les informations personnelles de votre personnage.</p>
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
