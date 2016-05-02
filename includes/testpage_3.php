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
		if ($PlayerNames)
		{
			$mc = ($PlayerNames['success']);
			
		}
		else
		{
			echo '<p>Aucun joueur n\'est connecté.</p>';
		}
	//	echo "<a"
		//$api->call("sendCommand", array("say test en JSONAPI"));

}
?>
