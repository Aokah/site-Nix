<?php function cb_form()
{
	global $db, $_POST, $_SESSION;
	if (isset($_POST['send_cb']) AND isset($_POST['cb_msg']))
	{
		if (isset($_POST['cb_whisp']))
		{
			$presel = $db->prepare('SELECT id, name FROM members WHERE name = ?'); $presel->execute(array($to));
			$line = $presel->fetch();
			$to = $line['id'];
			$to = $_POST['cb_whisp'];
		}
		else
		{
			$to = "0";
		}
		$effect = (isset($_POST['effect']))? $_POST['effect'] : " ";
		$option = (isset($_POST['option']))? $_POST['option'] : " ";
		$req = $db->prepare("INSERT INTO cb_test VALUES('', ?, ?, '', 0, ?, ?,  ?,  NOW(), 0)");
		$req->execute(array($_SESSION['id'], $to , htmlspecialchars($_POST['cb_msg']), htmlspecialchars($effect),
		htmlspecialchars($option)));
	}
	
}
?>
