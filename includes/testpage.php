<?php function testpage ()
{

global $_POST, $db, $_SESSION;

  $max = $db->query('SELECT COUNT(*) AS idmax FROM members WHERE magie_rank < 7'); $max = $max->fetch();

  echo $max['idmax'];
}
?>
