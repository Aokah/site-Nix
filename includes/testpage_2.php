<?php function testpage_2 ()
{
global $_SESSION, $db;
  $select = $db->prepare('SELECT * FROM trophee_get WHERE user_id = ?');
  $select->execute(array($_SESSION['id']));
  echo $_SESSION['id'];
  while ($line = $select->fetch())
  { echo $line['trophee_id'];
    $select2 = $db->prepare('SELECT * FROM trophee_list WHERE id = ?');
    $select2->execute(array($line['trophee_id']));
    while ($line2 = $select2->fetch())
    {
    ?>
    <img src="pics/trophee/trophee_<?= $select2['id']?>.png" alt="" width="40%" />
    <?php
    }
  }
}
?>
