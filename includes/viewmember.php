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
		$magieok = 'Non acquise';
		if ($_SESSION['magieok'] == 1) { $magietest = true; }
		if ($magietest) { $magieok = 'Acquise'; }
	?>
	<h2>Mon personnage</h2>
	
	<table cellspacing="5" cellpadding="5">
		<tbody>
			<tr>
				<td>
					<table cellspacing="0" cellpadding="0" class="pnjtable">
						<tbody>
							<tr>
								<td height="150px" width="150px" style="border-radius: 10px;" rowspan="4">
									Image
								</td>
								<td width="60px" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
								</td>
							</tr>
							<tr>
								<td>
									<p>Nom : <?= $_SESSION['name']?></p>
								</td>
								<td>
									<p>Titre : <img src="pics/rank<?= $_SESSION['rank']?>.png" alt="" width="25" /> <?= $_SESSION['title']?></p>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p>Magie : <? echo $magieok; ?></p>
								</td>
							</tr>
							<tr>
								<td width="60px" style="border: 0px grey solid; background-color: grey; color: grey;">
									<p> </p>
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
				<td>
					<table cellspacing="0" cellpading="0" class="pnjtable">
						<tbody>
							<tr>
								<td colspan="3">
									Miniature
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Identité : Prénom Nom
								</td>
								<td>
									Race : <?= $_SESSION['race']?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					Histoire
				</td>
				<td>
					Le joueur
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	
	
}
?>
