<?php function testpage_2 ()
{
global $_SESSION, $db;
  if (password_verify('Dragonball76',$_SESSION['name']))
  {
    echo 'MDP correct';
  }
  else
  {
    echo 'Mauvais MDP';
  }
}
?>
