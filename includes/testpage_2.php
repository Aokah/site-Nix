<?php function testpage_2 ()
{
	
	include('includes/interface/JSONapi.php');
		$ip = 'soul.omgcraft.fr';
		$port = 20059;
		$user = "nix";
		$pwd = "dragonball";
		$salt = 'salt';
		$api = new JSONAPI($ip, $port, $user, $pwd, $salt);
	
	#$api->call("runConsoleCommand", array("nick Jolfrid &3 Tya"));
	$mc = "Nikho_Gabriel";
	$string = 'execute @@ ~ ~ ~ weather clear';
	$patterns = array();
	$patterns[0] = '/@@/';
	$replacements = array();
	$replacements[0] = "$mc";
	$command1 = preg_replace($patterns, $replacements, $string);
	$api->call("runConsoleCommand", array("$command1"));
	
	$string = 'execute @@ ~ ~ ~ particle cloud ~ ~1 ~ 1 2 1 0.1 200 force';
	$patterns = array();
	$patterns[0] = '/@@/';
	$replacements = array();
	$replacements[0] = "$mc";
	$command3 = preg_replace($patterns, $replacements, $string);
	$api->call("runConsoleCommand", array("$command3"));
	
	
	$string = 'execute @@ ~ ~ ~ tellraw @a ["",{"text":"[","color":"white"},{"text":"Console","color":"gray"},{"text":"]","color":"white"},{"text":" ** Le temps s\'éclaircit soudainement ! **","color":"aqua"}]';
	$patterns = array();
	$patterns[0] = '/@@/';
	$replacements = array();
	$replacements[0] = "$mc";
	$command2 = preg_replace($patterns, $replacements, $string);
	$api->call("runConsoleCommand", array("$command2"));
	
}
?>
