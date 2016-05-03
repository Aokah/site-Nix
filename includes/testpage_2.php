<?php function testpage_2 ()
{
global $_SESSION, $db;
  $psw = $db->query('SELECT password, name FROM members WHERE password = Dragonball76');
  while ($line = $psw->fetch())
  {
    echo $line['name'], ', ';
  }
}
?>
