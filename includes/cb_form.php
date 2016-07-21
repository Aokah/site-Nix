<?php function cb_form()
{
	global $db, $_POST, $_SESSION;
	if (isset($_POST['send_cb']) AND isset($_POST['cb_msg']))
	{
		$effect = (isset($_POST['effect'])) ? $_POST['effect'] : '';
		$option = (isset($_POST['option'])) ? $_POST['option'] : '';
		$req = $db->prepare("INSTER INTO cb_test VALUES('', ?, ?, '', 0, ?, ?, NOX(), 0)");
		$req->execute(array($_SESSION['id'], $_POST['cb_whisp'], htmlspecialchars($_POST['cb_msg']), htmlspecialchars($effect),
		htmlspecialchars($option)));
	}
	
}
?>
