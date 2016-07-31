<?php function cb_form()
{
	global $db, $_POST, $_SESSION;
	if (isset($_POST['send_cb']) AND isset($_POST['cb_msg']) AND $_POST['cb_msg'] != "")
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
		if (isset($_POST['staffeffect']))
		{
		$effect = (isset($_POST['effect']) AND $_SESSION['rank'] >= 5)? $_POST['effect'] : " ";
		$option = (isset($_POST['option']) AND $_SESSION['rank'] >= 5)? $_POST['option'] : " ";
		}
		$req = $db->prepare("INSERT INTO cb_test VALUES('', ?, ?, '', 0, ?, ?,  ?,  NOW(), 0)");
		$req->execute(array($_SESSION['id'], $to , htmlspecialchars($_POST['cb_msg']), htmlspecialchars($effect),
		htmlspecialchars($option)));
	}
	if (isset($_GET['del']))
	{
		$id = intval($_GET['del']);
		
		$presel = $db->prepare('SELECT id, sender_id FROM cb_test WHERE id = ?'); $presel->execute(array($id));
		$presel = $presel->fetch();
		$verif = $db->prepare('SELECT id, rank FROM members WHERE id = ?'); $verif->execute(array($presel['sender_id']));
		$verif = $verif->fetch();
		
		if ($_SESSION['rank'] >= $verif['rank'])
		{
			$del =$db->prepare('UPDATE cb_test SET del = 1, deleter_id = ? WHERE id = ?');
			$del->execute(array($_SESSION['id'], $id));
		}
	}
	
}
?>
