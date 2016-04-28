<?php function serv_admin ()
{
	global $_SESSION, $db;
	
	if ($_SESSION['rank'] >= 3)
	{
		include('includes/interface/JSONapi.php');

		$ip = 'soul.omgcraft.fr';
		$port = 20059;
		$user = "nix";
		$pwd = "dragonball";
		$salt = 'salt';
		$api = new JSONAPI($ip, $port, $user, $pwd, $salt);
		
		?>
			<h3>Administration du serveur</h3>
			
			<h4>Liste des joueurs connectés :</h4>
		<?php
		
		$players = $api->call("players.online.names");
		
		if ($players[0]["is_success"])
		{
			$playersCount = count($players[0]["success"]);
			
			if ($playersCount)
			{
				$playersNames = "";
				for ($i = 0; $i < $playersCount; $i++)
				{
					$select = $db->prepare('SELECT * WHERE Minecraft_Account = ?');
					$select->execute(array($players[0]["success"][$i]));
					$line = $select->fetch(); $rank = $line['rank'];
					$playersNames .= "<span class=\"name". $rank."\">".$players[0]["success"][$i]."</span>, ";
				}
				$playersNames = substr($playersNames, 0, -2);
			}
			else
			{
				$playersNames = "Aucuns joueurs connectés.";
			}
		}
		else
		{
			$playersNames = "Ereur.";
		}
		
		?>
			<p><?=$playersNames?></p>
			
			
		<?php
	}
}
?>
