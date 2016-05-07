<?php function testpage_3 ()
{
	global $db;
	
	include('includes/interface/JSONapi.php');
		$ip = '62.210.232.129 ';
		$port = 10414;
		$user = renan.a@homtail.fr;
		$pwd = muse.nirvana;
		$salt = 'salt';
		$api = new JSONAPI($ip, $port, $user, $pwd, $salt);
		
		if (isset($_GET['action']))
		{
			if ($_GET['test'])
			{
				$select = $db->prepare('SELECT id, Minecraft_Account AS mc FROM members WHERE id = ?');
				$select->execute(array($_SESSION['id'])); $line = $select->fetch();
				$test = "Laura_Dragon &2SenNenring";
				$resultat = $api->call("server.run_command", array("say test JsonAPI"));
				echo '<img src="http://skins.minecraft.net/MinecraftSkins/'.$line['mc'].'.png" alt = "" />';
			}
		}
		else
		{
			$PlayerNames = $api->call("getPlayerNames");
			if ($PlayerNames)
			{
				$mc = ($PlayerNames['success']);
				
			}
			else
			{
				echo '<p>Aucun joueur n\'est connecté.</p>';
			}
			echo '<a href="index?p=testpage_3&action=test">Test /nick</a>';	
		}
		

}
?>
