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
	$mc = "Nikh_Gabriel";
	$string = 'execute @@ ~ ~ ~ weather clear';
	$patterns = array();
	$patterns[0] = '/@@/';
	$replacements = array();
	$replacements[0] = "/$mc/";
	echo preg_replace($patterns, $replacements, $string);
	
}
?>
