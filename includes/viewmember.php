<?php function viewmember ()
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
		$perso = intval($_GET['perso']);
		echo 'vision personage';
	}
	else
	{
	?>
	<h2>Mon personnage</h2>
	<?php
		$perso = $db->prepare('SELECT * FROM members WHERE id= ?');
		$perso->execute(array($_SESSION['id']));
		
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
									<p>Titre : <img src="pics/rank<?= $line['rank']?>.png" alt="" width="25" /> <?= $_SESSION['title']?></p>
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
								<td>
									Caractère :
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
								<td>
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
								<td>
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
								<td>
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
								<td>
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
								<td>
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
								<td>
									<img alt="" src="/pics/ico/notespersobottom.png">
								</td>
							</tr>
							
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<?php } else { echo '<p>Une erreur s\'est produite.</p>'; }
	
	}
	
	
}
?>
