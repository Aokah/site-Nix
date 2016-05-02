<?php function testpage_3 ()
{
	global $db;
	
	include('includes/interface/JSONapi.php');
		$ip = 'soul.omgcraft.fr';
		$port = 20059;
		$user = "nix";
		$pwd = "dragonball";
		$salt = 'salt';
		$api = new JSONAPI($ip, $port, $user, $pwd, $salt);
		
		$PlayerNames = $api->call("getPlayerNames");
		if ($PlayerNames['sucess'])
		{
			$mc = ($PlayerNames['success']);
		}
		else
		{
			echo 'Aucun joueur n\'est connecté';
		}

}
?>
