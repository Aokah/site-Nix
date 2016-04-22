<?php function testpage_2 ()
{
  $select = $db->prepare('SELECT * FROM trophee_get WHERE user_id = ?');
  $select->execute(array($_SESSION['id']));
  
  while ($line = $select->fetch())
  {
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
