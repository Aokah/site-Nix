<?php function testpage_2 ()
{
global $_SESSION, $db;
  $select = $db->prepare('SELECT * FROM trophee WHERE user_id = ?');
  $select->execute(array($_SESSION['id']));
  
  while ($line = $select->fetch())
  {
    ?>
    <img src="pics/trophee/trophee_<?= $line['trophee_id']?>.png" alt="" width="25%" />
    <?php
  }
}
?>
