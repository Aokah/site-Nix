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
	
	<table>
		<tbody>
			<tr>
				<td>
					<table cellspacin="0" cellpadding="0" class="pnjtable">
						<tbody>
							<tr>
								<td height="150px" width="150px" style="border-radius: 10px;" rowspan="4">
									Image
								</td>
								<td>
									
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td>
					Détails
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
