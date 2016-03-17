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
	?>
	
	
	<table cellspacing="5" cellpadding="5">
		<tbody>
			<tr>
				<td valign="top" width="50%">
					<table cellspacing="5" cellpadding="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td style="border-radius: 10px;" rowspan="4">
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
							<tr>
								<td colspan="2">
									Energie Magique
								</td>
								<td colspan="2">
									Energie Vitale
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td valign="top" width="50%">
					<table cellspacing="5" cellpading="5" class="pnjtable" width="100%">
						<tbody>
							<tr>
								<td width="1px" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
								<td style="text-align:center;">
									<img src="pics/avatar/skin_<?= $line['id']?>.png" alt="" width="100" />
								</td>
								<td width="1px" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Identité : <?= $line['name']?> Nom
								</td>
							</tr>
							<tr>
								
								<td>
									Race : <?= $line['race']?>
								</td>
								<td>
									Origine :
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Element primaire : <?= $line['specialisation']?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Elemenn secondaire : <?= $line['spe_2']?>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									Niveau magique : <?= $line['magie_rank']?>
								</td>
							</tr>
							<tr>
								<td width="1px" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
								<td width="1px" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
								<td width="1px" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
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
												<p>
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
												<p>
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
				</td>
			</tr>
		</tbody>
	</table>
	<?php } else { echo '<p>Une erreur s\'est produite.</p>'; }
	
	}
	
	
}
?>
