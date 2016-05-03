<?php function testpage_2 ()
{
global $_SESSION, $db;
$psw = $db->prepare('SELECT password, id FROM members WHERE id = ?'); $psw->execute(array($_SESSION['id'])); 

if ($line = $psw->fetch())
{
  if (password_verify('dragonball76', $line['password']))
  {
    echo 'yes';
  }
  else
  {
    echo 'no';
  }
}
}
?>
