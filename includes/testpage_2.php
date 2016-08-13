<?php function testpage_2 ()
{
	
	include('includes/interface/JSONapi.php');
		$ip = 'soul.omgcraft.fr';
		$port = 20059;
		$user = "nix";
		$pwd = "dragonball";
		$salt = 'salt';
		$api = new JSONAPI($ip, $port, $user, $pwd, $salt);
	
	$mc = "chugo";
	$string = 'execute @@ ~ ~ ~ weather thunder';
	$patterns = array();
	$patterns[0] = '/@@/';
	$replacements = array();
	$replacements[0] = "$mc";
	$command1 = preg_replace($patterns, $replacements, $string);
	$api->call("runConsoleCommand", array("$command1"));
	
	/*$string = 'execute @@ ~ ~ ~ particle cloud ~ ~1 ~ 1 2 1 0.1 200 force';
	$patterns = array();
	$patterns[0] = '/@@/';
	$replacements = array();
	$replacements[0] = "$mc";
	$command3 = preg_replace($patterns, $replacements, $string);
	$api->call("runConsoleCommand", array("$command3"));*/
	
	
	$string = 'execute @@ ~ ~ ~ tellraw @a ["",{"text":"[","color":"white"},{"text":"Console","color":"gray"},{"text":"]","color":"white"},{"text":" ** Le temps devient soudainement orageux ! **","color":"aqua"}]';
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
	
}
?>
