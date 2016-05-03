<?php function testpage_2 ()
{
global $_SESSION, $db;
$psw = $db->prepare('SELECT password, id FROM members WHERE id = ?'); $psw->execute(array($_SESSION['id'])); $line = $psw->fetch();

echo (password_hash('Dragonball76',PASSWORD_DEFAULT));
}
?>
