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

	if (isset($_GET['viewavis']))
	{
		$perso = intval($_GET['viewavis']);
		    $avis = $db->prepare('SELECT h.id, h.sender_id, h.sender_rank, h.avis, h.target_id, m.id m_id, m.title, m.name
		    FROM hrpavis h
		    RIGHT JOIN members m
		    ON m.id = h.sender_id
		    WHERE target_id = ?
		    ORDER BY h.id ASC');
		    $avis->execute(array($perso));
		    
		    ?><table cellspacing="0" cellpadding="0" align="center">
			<tbody>
				<tr>
					<td width="50px">
						<img alt=" " src="/pics/ico/magiepapertop.png">
					</td>
				</tr>
				<tr>
					<td>
						<table width="640px" background="/pics/ico/magiepapercenter.png" style="padding:5%; text-align:center;">
							<tbody>
								<tr>
									<th>Nom</th>
									<th>Titre</th>
									<th>Avis</th>
								</tr>
							<?php while ($line = $avis->fetch())
							{
							$value = ($line['sender_rank'] > 4) ? '2' : '1' ;
							$method = ($line['avis'] == 1) ? '+' : '-'; 
							?>
								<tr>
									<td>
										<a href="index?p=perso&viewavis=<?=$line['m_id']?>"><?= $line['name']?></a>
									</td>
									<td>
										<?= $line['title']?>
									</td>
									<td>
										<?php echo $method,$value ?>
									</td>
								</tr>
							<?php }
							$select = $db->prepare('SELECT COUNT(*) AS plus FROM hrpavis WHERE target_id = ? AND avis = 1 AND sender_rank <= 4');
							$select->execute(array($perso)); $line = $select->fetch();
							$select1 = $db->prepare('SELECT COUNT(*) AS plusstaff FROM hrpavis WHERE target_id = ? AND avis = 1 AND sender_rank > 4');
							$select1->execute(array($perso)); $line1 = $select1->fetch();
							$select2 = $db->prepare('SELECT COUNT(*) AS moins FROM hrpavis WHERE target_id = ? AND avis = 0 AND sender_rank <= 4');
							$select2->execute(array($perso)); $line2 = $select2->fetch();
							$select3 = $db->prepare('SELECT COUNT(*) AS moinsstaff FROM hrpavis WHERE target_id = ? AND avis = 0 AND sender_rank > 4');
							$select3->execute(array($perso)); $line3 = $select3->fetch();
							$countj = $line['plus'] - $line2['moins'];
							$plus = $line1['plusstaff'] * 2; $moins = $line3['moinsstaff'] * 2;
							$counts = $plus - $moins; $count = $countj + $counts;
							?>
								<tr>
									<th>Total :</th><td><?php echo $count;?></td>
								</tr>
							</tbody>
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
		      <p>
		        <a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage dont les avis sont notifiés ci-dessus.
		      </p>
		      <p>
		        <a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.
		      </p>
		    <?php
	}
	elseif (isset($_GET['perso']))
	{
		if ($_SESSION['rank'] < 6)
		{
		$perso = intval($_GET['perso']);
		$page = $db->prepare('SELECT * FROM members WHERE id= ? AND rank < 8');
		$page->execute(array($perso));
		}
		else
		{
		$perso = intval($_GET['perso']);
		$page = $db->prepare('SELECT * FROM members WHERE id= ?');
		$page->execute(array($perso));
		}
		if ($line = $page->fetch()) {
		
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
										<input type="number" name="e-magie" min="0" step="1" value="<?= $line['E_magique']?>" max="<?php echo $maxmagie; ?>"></code> <?php } else { ?>
										<?php echo $overmagie; }?>
									</td>
									<td>
										Energie Vitale :
									</td>
									<td>
										<input type="number" name="e-vie" min="0" step="1"  value="<?= $line['E_vitale']?>" max="200"></code>
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
				$update = $db->prepare('UPDATE members SET invisible = 1 WHERE id = ?');
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
				$update = $db->prepare('UPDATE members SET valid_bg = 1, valider_id = ? WHERE id = ?');
				$update->execute(array($_SESSION['id'], $perso));
				echo '<p>BackGround RolePlay validé !</p>';?>
				<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
				<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
				<?php
				}
				else { echo '<p>Non non non ! On ne triche pas ! ;-) !</p>'; }
			}
			elseif ($_GET['action'] == "avisok")
			{
				$select = $db->prepare('SELECT * FROM hrpavis WHERE sender_id = ? AND target_id = ?');
				$select->execute(array($_SESSION['id'], $perso));
				if ($line = $select->fetch());
				{
					$update = $db->prepare("INSERT INTO hrpavis VALUES('', ?, ?, 1, ?)");
					$update->execute(array($_SESSION['id'], $_SESSION['rank'], $perso));
					echo 'Avis HRP positif pris en compte !';
					?>
					<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
					<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
					<?php
				}
			//	else
			//	{
			//		$update = $db->prepare("UPDATE hrpavis SET sender_rank = ?, avis = 1 WHERE target_id= ? AND sender_id = ?");
			//		$update->execute(array($_SESSION['rank'], $perso, $_SESSION['id']));
			//		echo 'Avis HRP positif pris en compte !';
			//		?>
			<!--		<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
					<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
			-->		<?php
			//	}
			}
			elseif ($_GET['action'] == "avisko")
			{
				$select = $db->prepare('SELECT COUNT(*) AS avis FROM hrpavis WHERE sender_id = ?');
				$select->execute(array($_SESSION['id'])); $line = $select->fetch();
				if ($line['avis'] == 0);
				{
					$update = $db->prepare("INSERT INTO hrpavis VALUES('', ?, ?, 0, ?)");
					$update->execute(array($_SESSION['id'], $_SESSION['rank'], $perso));
					echo 'Avis HRP négatif pris en compte !';
					?>
					<p><a href="index?p=perso&perso=<?php echo $perso;?>">Cliquez ici</a> pour retourner à la fiche personnage modifiée.</p>
					<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
					<?php
				}
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
		if ($line['ban'] == 1) { $grade = "ban"; } if ($line['removed'] == 1) { $grade = "del";}
		$title = $line['title'];
		if ($line['pionier'] == 1) { $title = "Pionier"; }
		if ($line['ban'] == 1) { $title = "Banni"; }
		if ($line['removed'] == 1 ) {$title = "Oublié" ;}
		
		$dignitaire = ($line['dignitaire'] == 1) ? '<span style="color:red">(Dignitaire)</span>' : '';
		
		//Affichage des PMs
		if ($line['magie_rank'] >= 0) {	if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 4)  { $tmagie = 0 ; } if ($line['E_magique'] >=5 AND $line['E_magique'] <= 10) { $tmagie = 10 ;}	if ($line['E_magique'] >=10 AND $line['E_magique'] <= 14) { $tmagie = 20 ;}
						if ($line['E_magique'] >=15 AND $line['E_magique'] <= 19) { $tmagie = 30 ; } if ($line['E_magique'] >=20 AND $line['E_magique'] <= 24) { $tmagie = 40 ; } if ($line['E_magique'] >=25 AND $line['E_magique'] <= 29) { $tmagie = 50 ; }
						if ($line['E_magique'] >=30 AND $line['E_magique'] <= 34) { $tmagie = 60 ; } if ($line['E_magique'] >=35 AND $line['E_magique'] <= 39) { $tmagie = 70 ; } if ($line['E_magique'] >=40 AND $line['E_magique'] <= 44) { $tmagie = 80 ; }
						if ($line['E_magique'] >=45 AND $line['E_magique'] <= 49) { $tmagie = 90 ; } if ($line['E_magique'] == 50) { $tmagie = 100 ; }if ($line['E_magique'] > 50)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 1) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 9) { $tmagie = 0 ; } if ($line['E_magique'] >=10 AND $line['E_magique'] <= 19) { $tmagie = 10 ; } if ($line['E_magique'] >=20 AND $line['E_magique'] <= 29) { $tmagie = 20 ; }
						if ($line['E_magique'] >=30 AND $line['E_magique'] <= 39) { $tmagie = 30 ;} if ($line['E_magique'] >=40 AND $line['E_magique'] <= 49) { $tmagie = 40 ; } if ($line['E_magique'] >=50 AND $line['E_magique'] <= 59) { $tmagie = 50 ; }
						if ($line['E_magique'] >=60 AND $line['E_magique'] <= 69) { $tmagie = 60 ; } if ($line['E_magique'] >=70 AND $line['E_magique'] <= 79) { $tmagie = 70 ; } if ($line['E_magique'] >=80 AND $line['E_magique'] <= 89)  { $tmagie = 80 ; }
						if ($line['E_magique'] >=90 AND $line['E_magique'] <= 99) { $tmagie = 90 ; } if ($line['E_magique'] == 100) { $tmagie = 100 ;} if ($line['E_magique'] > 100)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 2) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 14) { $tmagie = 0 ; } if ($line['E_magique'] >=15 AND $line['E_magique'] <= 29) 	{ $tmagie = 10 ; } if ($line['E_magique'] >=30 AND $line['E_magique'] <= 44)  { $tmagie = 20 ; }
						if ($line['E_magique'] >=45 AND $line['E_magique'] <= 59) { $tmagie = 30 ; } if ($line['E_magique'] >=60 AND $line['E_magique'] <= 74) { $tmagie = 40 ; } if ($line['E_magique'] >=75 AND $line['E_magique'] <= 89) { $tmagie = 50 ; }
						if ($line['E_magique'] >=90 AND $line['E_magique'] <= 104) { $tmagie = 60 ; } if ($line['E_magique'] >=105 AND $line['E_magique'] <= 119) { $tmagie = 70 ; } if ($line['E_magique'] >=120 AND $line['E_magique'] <= 134) { $tmagie = 80 ; }
						if ($line['E_magique'] >=135 AND $line['E_magique'] <= 149) { $tmagie = 90 ; } if ($line['E_magique'] == 150)  { $tmagie = 100 ; }if ($line['E_magique'] > 150)  { $tmagie = "over" ; }		}
					if ($line['magie_rank'] == 3) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 19) { $tmagie = 0 ; } if ($line['E_magique'] >= 20 AND $line['E_magique'] <= 39) { $tmagie = 10 ; } if ($line['E_magique'] >= 40 AND $line['E_magique'] <= 59) { $tmagie = 20 ; }
						if ($line['E_magique'] >= 60 AND $line['E_magique'] <= 79) { $tmagie = 30 ; } if ($line['E_magique'] >= 80 AND $line['E_magique'] <= 99) { $tmagie = 40 ; } if ($line['E_magique'] >= 100 AND $line['E_magique'] <= 119) { $tmagie = 50 ; }
						if ($line['E_magique'] >= 120 AND $line['E_magique'] <= 139) { $tmagie = 60 ; } if ($line['E_magique'] >= 140 AND $line['E_magique'] <= 159) { $tmagie = 70 ; } if ($line['E_magique'] >= 160 AND $line['E_magique'] <= 179) { $tmagie = 80 ; }
						if ($line['E_magique'] >= 180 AND $line['E_magique'] <= 199) { $tmagie = 90 ; } if ($line['E_magique'] == 200) { $tmagie = 100; }if ($line['E_magique'] > 200) { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 4) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 29) { $tmagie = 0 ;} if ($line['E_magique'] >= 30 AND $line['E_magique'] <= 59)  { $tmagie = 10 ;} if ($line['E_magique'] >= 60 AND $line['E_magique'] <= 89) { $tmagie = 20 ;}
						if ($line['E_magique'] >= 90 AND $line['E_magique'] <= 119) { $tmagie = 30 ;} if ($line['E_magique'] >= 120 AND $line['E_magique'] <= 149) { $tmagie = 40 ;} if ($line['E_magique'] >= 150 AND $line['E_magique'] <= 179) { $tmagie = 50 ;}
						if ($line['E_magique'] >= 180 AND $line['E_magique'] <= 209) { $tmagie = 60 ;} if ($line['E_magique'] >= 210 AND $line['E_magique'] <= 239) { $tmagie = 70 ;} if ($line['E_magique'] >= 240 AND $line['E_magique'] <= 269) { $tmagie = 80 ;}
						if ($line['E_magique'] >= 270 AND $line['E_magique'] <= 299) { $tmagie = 90 ;} if ($line['E_magique'] == 300)  { $tmagie = 100 ; } if ($line['E_magique'] > 300)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 5) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 39) { $tmagie = 0 ; } if ($line['E_magique'] >= 40 AND $line['E_magique'] <= 79) { $tmagie = 10 ; } if ($line['E_magique'] >= 80 AND $line['E_magique'] <= 119) { $tmagie = 20 ; }
						if ($line['E_magique'] >= 120 AND $line['E_magique'] <= 159) { $tmagie = 30 ; } if ($line['E_magique'] >= 160 AND $line['E_magique'] <= 199) { $tmagie = 40 ; } if ($line['E_magique'] >= 200 AND $line['E_magique'] <= 239) { $tmagie = 50 ; }
						if ($line['E_magique'] >= 240 AND $line['E_magique'] <= 279) { $tmagie = 60 ; } if ($line['E_magique'] >= 280 AND $line['E_magique'] <= 319) { $tmagie = 70 ; } if ($line['E_magique'] >= 320 AND $line['E_magique'] <= 359) { $tmagie = 80 ; }
						if ($line['E_magique'] >= 360 AND $line['E_magique'] <= 399) { $tmagie = 90 ; }if ($line['E_magique'] == 400) { $tmagie = 100 ;	} if ($line['E_magique'] > 400)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 6) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 49) { $tmagie = 0 ; } if ($line['E_magique'] >= 50 AND $line['E_magique'] <= 99) { $tmagie = 10 ; } if ($line['E_magique'] >= 100 AND $line['E_magique'] <= 149) { $tmagie = 20 ; }
						if ($line['E_magique'] >= 150 AND $line['E_magique'] <= 199) { $tmagie = 30 ; } if ($line['E_magique'] >= 200 AND $line['E_magique'] <= 249) { $tmagie = 40 ; } if ($line['E_magique'] >= 250 AND $line['E_magique'] <= 299) { $tmagie = 50 ; }
						if ($line['E_magique'] >= 300 AND $line['E_magique'] <= 349) { $tmagie = 60 ; } if ($line['E_magique'] >= 350 AND $line['E_magique'] <= 399) { $tmagie = 70 ; } if ($line['E_magique'] >= 400 AND $line['E_magique'] <= 449) { $tmagie = 80 ; }
						if ($line['E_magique'] >= 450 AND $line['E_magique'] <= 499) { $tmagie = 90 ; } if ($line['E_magique'] == 500) { $tmagie = 100 ; } if ($line['E_magique'] > 500) { $tmagie = "over" ; }	}
					if ($line['magie_rank'] >= 7) { $tmagie = 'inf';}
					
				//Affichage des PV
					if ($line['E_vitale'] >= 0  AND $line['E_vitale'] <= 19) 	{	$tvie = 0 ;	}
					if ($line['E_vitale'] >= 20 AND $line['E_vitale'] <= 39) 	{	$tvie = 10 ;	}
					if ($line['E_vitale'] >= 40 AND $line['E_vitale'] <= 59) 	{	$tvie = 20 ;	}
					if ($line['E_vitale'] >= 60 AND $line['E_vitale'] <= 79) 	{	$tvie = 30 ;	}
					if ($line['E_vitale'] >= 80 AND $line['E_vitale'] <= 99) 	{	$tvie = 40 ;	}
					if ($line['E_vitale'] >= 100 AND $line['E_vitale'] <= 119) 	{	$tvie = 50 ;	}
					if ($line['E_vitale'] >= 120 AND $line['E_vitale'] <= 139)	{	$tvie = 60 ;	}
					if ($line['E_vitale'] >= 140 AND $line['E_vitale'] <= 159) 	{	$tvie = 70 ;	}
					if ($line['E_vitale'] >= 160 AND $line['E_vitale'] <= 179) 	{	$tvie = 80 ;	}
					if ($line['E_vitale'] >= 180 AND $line['E_vitale'] <= 199) 	{	$tvie = 90 ;	}
					if ($line['E_vitale'] == 200) 	{	$tvie = 100 ;	}
				$pmcount = ($line['magie_rank'] > 7) ? 'PMs Illimité !' : ''.$line['E_magique'].' PMs restants !' ;
	?>
	<h2 class="name<?= $line['rank']?><?php echo $tech; echo $pionier;?>"><?php echo $title;?> <?= $line['name']?></h2>
	
	<table cellspacing="5" cellpadding="5"  align="center">
		<tbody>
			<tr>
				<td valign="top" width="50%">
					<table width="640px" cellspacing="5" cellpadding="5" class="pnjtable" align="center">
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
									<p>Titre : <img src="pics/rank<?php echo $grade;?>.png" alt="" width="25" /> <?php echo $title;?> <?php echo $dignitaire;?></p>
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
				<?php if ($_SESSION['rank'] < 6 ) { $span = "2"; } else { $span = "3"; } ?>
				<td valign="top" width="50%" rowspan="<?php echo $span; ?>">
					<table width="640px" cellspacing="5" cellpading="5" class="pnjtable" align="center">
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
								<td colspan="2">
									Qualité de jeu : <a href="index?p=perso&viewavis=<?php echo $perso;?>">[\\\\]</a>
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
					<table width="640px" cellspacing="5" cellpadding="5" class="pnjtable" align="center">
						<tbody>
							<tr>
								<td style="text-align:center;">
									<img src="pics/magie/EM_<? echo $tmagie ?>.png" width="95%" title="<?php echo $pmcount; ?>" alt="" />
								</td>
								<td style="text-align:center;">
									<img src="pics/magie/EV_<? echo $tvie ?>.png" width="95%" title="<?= $line['E_vitale']?> PV restants !" alt="" />
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
					<table width="640px" cellspacing="5" cellpading="5" class="pnjtable" align="center">
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
									<?php echo $vanish; ?> <?php if ($line['invisible'] == 1) { ?><a href="index?p=perso&perso=<?php echo $perso; ?>&action=vanishoff" title="Désactiver l'invisibilité du compte" style="color:red;">[OFF]</a><?php } else {
										?><a href="index?p=pers&perso=<?php echo $perso; ?>&action=vanishon" title="Activer l'invisibilité du compte" style="color:green;">[ON]</a><?php } ?>
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
					<table cellspacing="0" cellpadding="0" align="center">
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
												<?php if ($_SESSION['rank'] >= 5 AND $line['valid_bg'] == 0 AND $_SESSION['id'] != $line['id']) { ?>
												<p style="padding-left:10%; padding-right:10%;">
													<a href="index?p=perso&perso=<?php echo $perso;?>&action=validbg" class="validerbg">
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
					<table cellspacing="0" cellpadding="0"  align="center">
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
					<table cellspacing="0" cellpadding="0"  align="center">
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
	} else 
	{
	?>
	<h2>Compte vérouillé</h2>
	<p>Vous ne pouvez pas visionner les pages des PNJs de rang trop élevés.</p>
	<?php
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
			<form action='index?p=perso&valid=bg' method="POST">
				<textarea name="editbg"><?= $line['background']?></textarea>
				<input type="submit" name=save_bg value="Terminer" />
			</form>
			<?php
			}
			elseif ($_GET['modif'] == "notesp")
			{
			?>
			<h3>Edition des Notes Personnelles</h3>
			<form action='index?p=perso&valid=notesp' method="POST">
				<textarea name="editnotes"><?= $line['notes_perso'] ?></textarea>
				<input type="submit" name=save_notes value="Terminer" />
			</form>
			<?php	
			}
			elseif ($_GET['modif'] == "jdesc")
			{
			?>
			<h3>Edition de la Description du Joueur</h3>
			<form action='index?p=perso&valid=jdesc' method="POST">
				<textarea name="edithrp"><?= $line['bg_hrp'] ?></textarea>
				<input type="submit" name=save_hrp value="Terminer" />
			</form>
			<?php	
			}
			else { echo '<p>Tu n\'essaieraies pas de chercher là où tu ne devrais pas aller ? :P</p>'; }
		}
		}
	elseif (isset($_GET['valid']))
		{
			if ($_GET['valid'] == "bg")
			{
				if (isset($_POST['save_bg']))
				{
					$editbg = (htmlentities($_POST['editbg']));
					$update = $db->prepare('UPDATE members SET background = ?, valid_bg = 0 WHERE id = ?');
					$update->execute(array($editbg, $_SESSION['id']));
					?>
					<p>Modifications du BackGround effectuées !</p>
					<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
					<?php
				}
			}
			elseif ($_GET['valid'] == "jdesc")
			{
				if (isset($_POST['save_hrp']))
				{
					$edithrp = (htmlentities($_POST['edithrp']));
					$update = $db->prepare('UPDATE members SET bg_hrp = ? WHERE id = ?');
					$update->execute(array($edithrp, $_SESSION['id']));
					?>
					<p>Modifications de la description joueur effectuées !</p>
					<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
					<?php
				}
				
			}
			elseif ($_GET['valid'] == "notesp")
			{
				if (isset($_POST['save_notes']))
				{
					$editnotes = (htmlentities($_POST['editnotes']));
					$update = $db->prepare('UPDATE members SET notes_perso = ? WHERE id = ?');
					$update->execute(array($editnotes, $_SESSION['id']));
					?>
					<p>Modifications des notes personnelles effectuées !</p>
					<p><a href="index?p=perso">Cliquez ici</a> pour retourner à votre fiche personnage.</p>
					<?php
				}
			}
			else { echo '<p>Euh... Non ? On fouille pas le site voyons~ .</p>'; }
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
						<p>Créature reptilienne, les Erneliens ont reçu depuis l'aube de leur peuple une affinité nette avec la magie, peuple discret et sage, ces êtres ont su s'adapter aux différentes conditions cilimatiques, 
						privilégiant toutefois les régions humides et fraiches afin que leurs écailles ne se fragilisent pas, la chaleur les rends cassante, ils possèdent également une ossature légèrement plus épaisse mais étrangement, 
						plus fragile, à vous de découvrir pourquoi.</p>
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
						<p>Créatures bestiales et sauvages, les Orques restent par toout temps des chasseurs et des bêtes dominantes, 
						habitués aux climats doux ou tropicaux, ces monstres de muscles ont délaissé presque totalement la Magie pour se concentrer sur la chasse, 
						un Orque Mage est quelque chose d'extrêmement rare et d'extrêmement mal vu par ses confrères.</p>
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
						<p>Ces monstres de puissances dont personne ne peut avec certitude dater leur première apparition, résistant à toute chaleur, pouvant même nager dans la lave, 
						beaucoup d'avantages physique, mais une faiblesse énorme et évidente : l'eau et le froid. 
						Veillez à toujours avoir une source de chaluer avec vous et d'éviter les trop gros gels.</p>
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
					<table width="100%" align="center">
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
				<table align="center" cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
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
		$dignitaire = ($line['dignitaire'] == 1) ? '<span style="color:red">(Dignitaire)</span>' : '';
		$filename = 'pics/pnj/pnj_' .$line['id']. '.png';if (file_exists($filename)) {$img = $line['id'];} else {$img = 'no';}
		if ($line['technician'] == 0 AND $line['removed'] == 0 AND $line['ban'] == 0 AND $line['rank'] < 9) { $grade = $line['rank']; }
		if ($line['rank'] == 9) { $grade = "titan";} if ($line['rank'] == 10) { $grade = "crea"; }
		if ($line['technician'] == 1) { $tech = "-T"; $techmode = "Retirer"; $grade = "tech"; } else { $techmode = "Attribuer";}  if ($line['pionier'] == 1) { $pionier = '-P'; }
		if ($line['ban'] == 1) { $grade = "ban"; } if ($line['removed'] == 1) { $grade = "del";}
		$title = $line['title'];
		if ($line['pionier'] == 1) { $title = "Pionier"; }
		if ($line['ban'] == 1) { $title = "Banni"; }
		if ($line['removed'] == 1 ) {$title = "Oublié" ;}
		
		//Affichage des PMs
		if ($line['magie_rank'] >= 0) {	if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 4)  { $tmagie = 0 ; } if ($line['E_magique'] >=5 AND $line['E_magique'] <= 10) { $tmagie = 10 ;}	if ($line['E_magique'] >=10 AND $line['E_magique'] <= 14) { $tmagie = 20 ;}
						if ($line['E_magique'] >=15 AND $line['E_magique'] <= 19) { $tmagie = 30 ; } if ($line['E_magique'] >=20 AND $line['E_magique'] <= 24) { $tmagie = 40 ; } if ($line['E_magique'] >=25 AND $line['E_magique'] <= 29) { $tmagie = 50 ; }
						if ($line['E_magique'] >=30 AND $line['E_magique'] <= 34) { $tmagie = 60 ; } if ($line['E_magique'] >=35 AND $line['E_magique'] <= 39) { $tmagie = 70 ; } if ($line['E_magique'] >=40 AND $line['E_magique'] <= 44) { $tmagie = 80 ; }
						if ($line['E_magique'] >=45 AND $line['E_magique'] <= 49) { $tmagie = 90 ; } if ($line['E_magique'] == 50) { $tmagie = 100 ; }if ($line['E_magique'] > 50)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 1) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 9) { $tmagie = 0 ; } if ($line['E_magique'] >=10 AND $line['E_magique'] <= 19) { $tmagie = 10 ; } if ($line['E_magique'] >=20 AND $line['E_magique'] <= 29) { $tmagie = 20 ; }
						if ($line['E_magique'] >=30 AND $line['E_magique'] <= 39) { $tmagie = 30 ;} if ($line['E_magique'] >=40 AND $line['E_magique'] <= 49) { $tmagie = 40 ; } if ($line['E_magique'] >=50 AND $line['E_magique'] <= 59) { $tmagie = 50 ; }
						if ($line['E_magique'] >=60 AND $line['E_magique'] <= 69) { $tmagie = 60 ; } if ($line['E_magique'] >=70 AND $line['E_magique'] <= 79) { $tmagie = 70 ; } if ($line['E_magique'] >=80 AND $line['E_magique'] <= 89)  { $tmagie = 80 ; }
						if ($line['E_magique'] >=90 AND $line['E_magique'] <= 99) { $tmagie = 90 ; } if ($line['E_magique'] == 100) { $tmagie = 100 ;} if ($line['E_magique'] > 100)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 2) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 14) { $tmagie = 0 ; } if ($line['E_magique'] >=15 AND $line['E_magique'] <= 29) 	{ $tmagie = 10 ; } if ($line['E_magique'] >=30 AND $line['E_magique'] <= 44)  { $tmagie = 20 ; }
						if ($line['E_magique'] >=45 AND $line['E_magique'] <= 59) { $tmagie = 30 ; } if ($line['E_magique'] >=60 AND $line['E_magique'] <= 74) { $tmagie = 40 ; } if ($line['E_magique'] >=75 AND $line['E_magique'] <= 89) { $tmagie = 50 ; }
						if ($line['E_magique'] >=90 AND $line['E_magique'] <= 104) { $tmagie = 60 ; } if ($line['E_magique'] >=105 AND $line['E_magique'] <= 119) { $tmagie = 70 ; } if ($line['E_magique'] >=120 AND $line['E_magique'] <= 134) { $tmagie = 80 ; }
						if ($line['E_magique'] >=135 AND $line['E_magique'] <= 149) { $tmagie = 90 ; } if ($line['E_magique'] == 150)  { $tmagie = 100 ; }if ($line['E_magique'] > 150)  { $tmagie = "over" ; }		}
					if ($line['magie_rank'] == 3) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 19) { $tmagie = 0 ; } if ($line['E_magique'] >= 20 AND $line['E_magique'] <= 39) { $tmagie = 10 ; } if ($line['E_magique'] >= 40 AND $line['E_magique'] <= 59) { $tmagie = 20 ; }
						if ($line['E_magique'] >= 60 AND $line['E_magique'] <= 79) { $tmagie = 30 ; } if ($line['E_magique'] >= 80 AND $line['E_magique'] <= 99) { $tmagie = 40 ; } if ($line['E_magique'] >= 100 AND $line['E_magique'] <= 119) { $tmagie = 50 ; }
						if ($line['E_magique'] >= 120 AND $line['E_magique'] <= 139) { $tmagie = 60 ; } if ($line['E_magique'] >= 140 AND $line['E_magique'] <= 159) { $tmagie = 70 ; } if ($line['E_magique'] >= 160 AND $line['E_magique'] <= 179) { $tmagie = 80 ; }
						if ($line['E_magique'] >= 180 AND $line['E_magique'] <= 199) { $tmagie = 90 ; } if ($line['E_magique'] == 200) { $tmagie = 100; }if ($line['E_magique'] > 200) { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 4) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 29) { $tmagie = 0 ;} if ($line['E_magique'] >= 30 AND $line['E_magique'] <= 59)  { $tmagie = 10 ;} if ($line['E_magique'] >= 60 AND $line['E_magique'] <= 89) { $tmagie = 20 ;}
						if ($line['E_magique'] >= 90 AND $line['E_magique'] <= 119) { $tmagie = 30 ;} if ($line['E_magique'] >= 120 AND $line['E_magique'] <= 149) { $tmagie = 40 ;} if ($line['E_magique'] >= 150 AND $line['E_magique'] <= 179) { $tmagie = 50 ;}
						if ($line['E_magique'] >= 180 AND $line['E_magique'] <= 209) { $tmagie = 60 ;} if ($line['E_magique'] >= 210 AND $line['E_magique'] <= 239) { $tmagie = 70 ;} if ($line['E_magique'] >= 240 AND $line['E_magique'] <= 269) { $tmagie = 80 ;}
						if ($line['E_magique'] >= 270 AND $line['E_magique'] <= 299) { $tmagie = 90 ;} if ($line['E_magique'] == 300)  { $tmagie = 100 ; } if ($line['E_magique'] > 300)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 5) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 39) { $tmagie = 0 ; } if ($line['E_magique'] >= 40 AND $line['E_magique'] <= 79) { $tmagie = 10 ; } if ($line['E_magique'] >= 80 AND $line['E_magique'] <= 119) { $tmagie = 20 ; }
						if ($line['E_magique'] >= 120 AND $line['E_magique'] <= 159) { $tmagie = 30 ; } if ($line['E_magique'] >= 160 AND $line['E_magique'] <= 199) { $tmagie = 40 ; } if ($line['E_magique'] >= 200 AND $line['E_magique'] <= 239) { $tmagie = 50 ; }
						if ($line['E_magique'] >= 240 AND $line['E_magique'] <= 279) { $tmagie = 60 ; } if ($line['E_magique'] >= 280 AND $line['E_magique'] <= 319) { $tmagie = 70 ; } if ($line['E_magique'] >= 320 AND $line['E_magique'] <= 359) { $tmagie = 80 ; }
						if ($line['E_magique'] >= 360 AND $line['E_magique'] <= 399) { $tmagie = 90 ; }if ($line['E_magique'] == 400) { $tmagie = 100 ;	} if ($line['E_magique'] > 400)  { $tmagie = "over" ; }	}
					if ($line['magie_rank'] == 6) { if ($line['E_magique'] >= 0  AND $line['E_magique'] <= 49) { $tmagie = 0 ; } if ($line['E_magique'] >= 50 AND $line['E_magique'] <= 99) { $tmagie = 10 ; } if ($line['E_magique'] >= 100 AND $line['E_magique'] <= 149) { $tmagie = 20 ; }
						if ($line['E_magique'] >= 150 AND $line['E_magique'] <= 199) { $tmagie = 30 ; } if ($line['E_magique'] >= 200 AND $line['E_magique'] <= 249) { $tmagie = 40 ; } if ($line['E_magique'] >= 250 AND $line['E_magique'] <= 299) { $tmagie = 50 ; }
						if ($line['E_magique'] >= 300 AND $line['E_magique'] <= 349) { $tmagie = 60 ; } if ($line['E_magique'] >= 350 AND $line['E_magique'] <= 399) { $tmagie = 70 ; } if ($line['E_magique'] >= 400 AND $line['E_magique'] <= 449) { $tmagie = 80 ; }
						if ($line['E_magique'] >= 450 AND $line['E_magique'] <= 499) { $tmagie = 90 ; } if ($line['E_magique'] == 500) { $tmagie = 100 ; } if ($line['E_magique'] > 500) { $tmagie = "over" ; }	}
					if ($line['magie_rank'] >= 7) { $tmagie = 'inf';}
					
				//Affichage des PV
					if ($line['E_vitale'] >= 0  AND $line['E_vitale'] <= 19) 	{	$tvie = 0 ;	}
					if ($line['E_vitale'] >= 20 AND $line['E_vitale'] <= 39) 	{	$tvie = 10 ;	}
					if ($line['E_vitale'] >= 40 AND $line['E_vitale'] <= 59) 	{	$tvie = 20 ;	}
					if ($line['E_vitale'] >= 60 AND $line['E_vitale'] <= 79) 	{	$tvie = 30 ;	}
					if ($line['E_vitale'] >= 80 AND $line['E_vitale'] <= 99) 	{	$tvie = 40 ;	}
					if ($line['E_vitale'] >= 100 AND $line['E_vitale'] <= 119) 	{	$tvie = 50 ;	}
					if ($line['E_vitale'] >= 120 AND $line['E_vitale'] <= 139)	{	$tvie = 60 ;	}
					if ($line['E_vitale'] >= 140 AND $line['E_vitale'] <= 159) 	{	$tvie = 70 ;	}
					if ($line['E_vitale'] >= 160 AND $line['E_vitale'] <= 179) 	{	$tvie = 80 ;	}
					if ($line['E_vitale'] >= 180 AND $line['E_vitale'] <= 199) 	{	$tvie = 90 ;	}
					if ($line['E_vitale'] == 200) 	{	$tvie = 100 ;	}
				$pmcount = ($line['magie_rank'] > 7) ? 'PMs Illimité !' : ''.$line['E_magique'].' PMs restants !' ;
	?>	
	
	
	<table cellspacing="5" cellpadding="5" align="center">
		<tbody>
			<tr>
				<td valign="top" width="50%">
					<table align="center" width="640px" cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
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
									<p>Titre : <img src="pics/rank<?php echo $grade;?>.png" alt="" width="25" /> <?php echo $title;?> <?php echo $dignitaire;?></p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<?php if ($_SESSION['rank'] < 6 ) { $span = "2"; } else { $span = "3"; } ?>
				<td valign="top" width="50%" rowspan="<?php echo $span; ?>">
					<table align="center" width="640px" cellspacing="5" cellpading="5" class="pnjtable">
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
								<td colspan="2">
									Qualité de jeu : <a href="index?p=perso&viewavis=<?= $_SESSION['id'] ?>">[\\\\]</a>
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
					<table align="center" width="640px" cellspacing="5" cellpadding="5" class="pnjtable" >
						<tbody>
							<tr>
								<td style="text-align:center;">
									<img src="pics/magie/EM_<? echo $tmagie ?>.png" width="95%" title="<?php echo $pmcount; ?>" alt="" />
								</td>
								<td style="text-align:center;">
									<img src="pics/magie/EV_<? echo $tvie ?>.png" width="95%" title="<?= $line['E_vitale']?> PV restants !" alt="" />
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<?php if ($_SESSION['rank'] >= 5) { ?>
			<tr>
				<td>
					<table align="center" width="640px" cellspacing="5" cellpading="5" class="pnjtable">
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
					<table align="center" cellspacing="0" cellpadding="0" >
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
					<table align="center" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td width="50px">
									<img alt=" " src="/pics/ico/magiepapertop.png">
								</td>
							</tr>
							<tr>
								<td>
									<table  width="640px" background="/pics/ico/magiepapercenter.png">
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
					<table align="center" cellspacing="0" cellpadding="0">
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
				case "Ernelien": $titlerace = "Ernelien"; $racedesc = "Créature reptilienne, les Erneliens ont reçu depuis l'aube de leur peuple une affinité nette avec la magie, peuple discret et sage, ces êtres ont su s'adapter aux différentes conditions cilimatiques, privilégiant toutefois les régions humides et fraiches afin que leurs écailles ne se fragilisent pas, la chaleur les rends cassante, ils possèdent également une ossature légèrement plus épaisse mais étrangement, plus fragile, à vous de découvrir pourquoi."; break;
				case "Humain" : $titlerace = "Humain"; $racedesc = "Très généralement remortels, les humains sont des personnes constituées d'os, de muscle, d'organes et de peau. Ils vivent généralement en communauté pour mieux survivre et savent s'adapter aux intempéries. Malgré le fait qu'ils soient une même race, plusieurs peuples aux coutumes différentes existent."; break;
				case "Nain": $titlerace = "Nain"; $racedesc = "Ces êtres sont un quart de fois plus petits que les hommes normaux. Ils sont généralement installés dans la région des Feldspaths, car les cavernes leurs ont permis de faire un tas de mine, et leur marché de forge prospère chez les autres races."; break;
				case "Onyx": $titlerace = "Onyx"; $racedesc = "Race très peu connues, étant donné la rareté de ces personnes qui naissent du Ciel. Les Onyx sont semblables aux humains sauf qu'au lieu d'avoir un nez, ils respirent par les pores de leur peau, qui est aussi noire que leurs yeux sont luisants. Les Onyx sont très généralement des personnes pacifiques et peu violentes, ce qui est surtout dû à leurs faible constitution, les rendant plus fragiles que des humains."; break;
				case "Orque": $titlerace = "Orque"; $racedesc = "Créatures bestiales et sauvages, les Orques restent par toout temps des chasseurs et des bêtes dominantes, habitués aux climats doux ou tropicaux, ces monstres de muscles ont délaissé presque totalement la Magie pour se concentrer sur la chasse, un Orque Mage est quelque chose d'extrêmement rare et d'extrêmement mal vu par ses confrères."; break;
				case "Stromnole": $titlerace = "Stromnole"; $racedesc = "Ces monstres de puissances dont personne ne peut avec certitude dater leur première apparition, résistant à toute chaleur, pouvant même nager dans la lave, beaucoup d'avantages physique, mais une faiblesse énorme et évidente : l'eau et le froid. Veillez à toujours avoir une source de chaluer avec vous et d'éviter les trop gros gels."; break;
				case "Zaknafein" : $titlerace = "Zaknafein"; $racedesc = "Êtres humanoïdes hypersensibles aux rayons UV, les Zaknafein ont su rester dans les diverses histoires commes des personnes de haute responsabilité depuis la nuit des temps, toujours à chercher un moyen d'éviter les conflits et d'un sens de la diplomatie pointu, jouer ce personnage reviendra à jouer un personnage calme et réfléchis."; break;
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
					<table align="center" cellspacing="5">
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
