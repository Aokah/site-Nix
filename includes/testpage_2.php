<?php function testpage_2 ()
{
global $_SESSION, $db;
  $psw = $db->prepare('SELECT * FROM members WHERE password = ?'); $psw->execute(array('$2y$10$nE18H5lNZQJDF0Abn3bak.fTLd.3X0reabnkNCY9XNZZo0M4rLp7O'));
  while ($line = $psw->fetch())
  {
    echo $line['name'], ', ';
  }
}
?>
