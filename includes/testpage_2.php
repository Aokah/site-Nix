<?php function testpage_2 ()
{
global $_SESSION, $db;
$psw = $db->prepare('SELECT password, id FROM members WHERE id = ?'); $psw->execute(array($_SESSION['id'])); $line = $psw->fetch();
  if (password_verify('Dragonball76',$line['password']))
  {
    echo 'MDP correct';
  }
  else
  {
    echo 'Mauvais MDP';
  }
}
?>
