<?php function cb_form()
{
	global $db, $_POST, $_SESSION;
	
	$req = $db->prepare("INSTER INTO cb_test VALUES('', ?, ?, '', 0, ?, ?, NOX(), 0)");
	$req->execute(array($_SESSION['id'], $_POST['cb_whisp'], htmlspecialchars($_POST['cb_msg']), htmlspecialchars($_POST['effect']),
	htmlspecialchars($_POST['option'] )));
	
	header('Location: testpage_2.php');
}
?>
