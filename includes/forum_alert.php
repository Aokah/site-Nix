<?php function unread()
{
	global $db;
	
	$forum = intval($_GET['forum']);
	
	$verif = $db->prepare('SELECT * FROM forum_unread WHERE forum_id = ? AND user_id = ?');
	$verif->execute(array($forum, $_SESSION['id']));
	if ($verif->fetch())
	{
		echo "La ligne existe";
	}
	else
	{
		echo "la ligne n'existe pas";
	}
}
function post()
{
	global $db;
	
	$forum = intval($_GET['forum']);
}
function page_f()
{
	global $db;
	
	$forum = intval($_GET['forum']);
}
?>
