<?php function cb_form()
{
	global $db, $_POST, $_SESSION;
	if (isset($_POST['send_cb']) AND isset($_POST['cb_msg']))
	{
		$to = (isset($_POST['cb_whisp'])) ? $_POST['cb_whisp'] : 0;
		if (isset($_POST['cb_whisp']))
		{
			$presel = $db->prepare('SELECT id, name FROM members WHERE name = ?'); $presel->execute(array($to));
			$line = $presel->fetch();
			$to = $line['id'];
		}
		$effect = (isset($_POST['effect'])) ? $_POST['effect'] : " ";
		$option = (isset($_POST['option'])) ? $_POST['option'] : " ";
		$req = $db->prepare("INSTER INTO cb_test VALUES('', ?, ?, '', 0, ?, ?, NOX(), 0)");
		$req->execute(array($_SESSION['id'], $to , htmlspecialchars($_POST['cb_msg']), htmlspecialchars($effect),
		htmlspecialchars($option)));
	}
	
}
?>
