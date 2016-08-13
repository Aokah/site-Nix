<?php function testpage_2 ()
{
	
	include('includes/interface/JSONapi.php');
		$ip = 'soul.omgcraft.fr';
		$port = 20059;
		$user = "nix";
		$pwd = "dragonball";
		$salt = 'salt';
		$api = new JSONAPI($ip, $port, $user, $pwd, $salt);
	
	$mc = "Nikho_Gabriel";
	
		$players = $api->call("this.getPlayerExact(0)", array($mc));
		
		if ($players["is_success"])
		{
			echo "Trouvé !";
		}
		else
		{
			echo 'Non trouvé';
		}
	/*
	$string = 'execute @@ ~ ~ ~ weather rain';
	$patterns = array();
	$patterns[0] = '/@@/';
	$replacements = array();
	$replacements[0] = "$mc";
	$command1 = preg_replace($patterns, $replacements, $string);
	$api->call("runConsoleCommand", array("$command1"));
	
	$type = 4;
	switch ($type)
	{
		case 1: $string = 'execute @@ ~ ~ ~ particle cloud ~ ~1 ~ 1 2 1 0.1 200 force'; break;
		case 2: $string = 'execute @@ ~ ~ ~ particle enchantmenttable ~ ~1 ~ 0.8 1 0.8 1 300 force'; break;
		case 3: $string = 'execute @@ ~ ~ ~ particle townaura ~ ~1 ~ 0.5 0.5 0.5 0.001 300 force'; break;
		case 4: $string = 'execute @@ ~ ~ ~ particle dripWater ~ ~1 ~ 1 1 1 0.1 300 force'; break;
		case 5: $string = 'no'; break;
		case 6: $string = 'execute @@ ~ ~ ~ particle flame ~ ~1 ~ 1 1.5 1 0.01 100 force'; break;
		case 7: $string = 'execute @@ ~ ~ ~ particle snowshovel ~ ~1 ~ 1 1.5 1 0.01 200 force'; break;
		case 8: $string = 'execute @@ ~ ~ ~ particle endRod ~ ~1 ~ 1 1 1 0.01 100 force'; break;
		case 9: $string = 'execute @@ ~ ~ ~ particle lava ~ ~1 ~ 1 1.5 1 0.1 100 force'; break;
		case 10: $string = 'execute @@ ~ ~ ~ particle happyVillager ~ ~1 ~ 1 1.5 1 0.01 200 force'; break;
		case 11: $string = 'execute @@ ~ ~ ~ particle smoke ~ ~1 ~ 0.5 1 0.5 0.001 200 force'; break;
		case 12: $string = 'execute @@ ~ ~ ~ particle magicCrit ~ ~1 ~ 1 1.5 1 0.1 150 force'; break;
		case 13: $string = 'execute @@ ~ ~ ~ particle crit ~ ~1 ~ 1 1.5 1 0.01 200 force'; break;
		case 14: $string = 'execute @@ ~ ~ ~ particle dripLava ~ ~1 ~ 1 1.5 1 0.1 100 force'; break;
		case 15: $string = 'execute @@ ~ ~ ~ particle instantSpell ~ ~1 ~ 1 1.5 1 0.01 200 force'; break;
		case 16: $string = 'no'; break;
		case 17: $string = 'execute @@ ~ ~ ~ particle dragonbreath ~ ~1 ~ 1 1 1 0.01 100 force'; break;
	}
	if ($string != 'no')
	{
		$patterns = array();
		$patterns[0] = '/@@/';
		$replacements = array();
		$replacements[0] = "$mc";
		$command3 = preg_replace($patterns, $replacements, $string);
		$api->call("runConsoleCommand", array("$command3"));	
	}
	
	$string = 'execute @@ ~ ~ ~ tellraw @a ["",{"text":"[","color":"white"},{"text":"Console","color":"gray"},{"text":"]","color":"white"},{"text":" ** Le temps devient soudainement pluvieux ! **","color":"aqua"}]';
	$patterns = array();
	$patterns[0] = '/@@/';
	$replacements = array();
	$replacements[0] = "$mc";
	$command2 = preg_replace($patterns, $replacements, $string);
	$api->call("runConsoleCommand", array("$command2"));
	
	$string = 'execute @@ ~ ~ ~ tellraw @p ["",{"text":"[","color":"green"},{"text":"Console","color":"gray"},{"text":"]","color":"green"},{"text":" ** Vos ressources magiques diminuent en conséquence. **","color":"aqua"}]';
	$patterns = array();
	$patterns[0] = '/@@/';
	$replacements = array();
	$replacements[0] = "$mc";
	$command4 = preg_replace($patterns, $replacements, $string);
	$api->call("runConsoleCommand", array("$command4"));
	*/
}
?>
