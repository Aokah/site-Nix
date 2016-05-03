<?php function testpage_2 ()
{
global $_SESSION, $db;
  $psw = $db->prepare('SELECT * FROM members WHERE password = ?'); $psw->execute(array('Dragonball76'));
  while ($line = $psw->fetch())
  {
    echo $line['name'], ', ';
  }
}
?>
