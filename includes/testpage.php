<?php function testpage ()
{

global $_POST,$_GET, $db;
?>
  <h2>Groupes et Guildes</h2>
  <p>Ici seront regroupées les informations basiques concernant les guildes et les groupes du site</p>
  <?php
  $select = $db->query('SELECT id, name, vanish, guild FROM group_name WHERE vanish = 0 ORDER BY guild DESC, name ASC');
  
  while ($line = $select->fetch())
  {
    $sel = $db->prepare('SELECT gm.id, gm.user_id, gm.group_id, gm.user_rank, m.id, m.name, m.rank, m.title
    FROM group_members gm
    RIGHT JOIN members m ON gm.user_id = m.id
    WHERE gm.group_id = ?
    ORDER BY gm.user_rank DESC, m.rank DESC, m.name ASC');
    $sel->execute(array($line['id']));
  ?>
  <h3><?= $line['name']?></h3>
  <img src="pics/guild_<?= $line['id']?>.png" atl="" class="guild" />
  <ul>
    <?php
    while ($line2 = $sel->fetch())
    {
      if ($line2['rank'] == 9) { $rank = "titan"; } elseif ($line2['rank'] == 10) { $rank = "crea";} else { $rank = $line2['rank'];}
      ?>
      <li>
        <img src="pics/rank<?= $rank?>.png" alt="" class="magie_type" width="25" /> <?= $line2['title'], ' ', $line2['name']?>
      </li>
      <?php
    }
    ?>
  </ul>
  <?php
  }
  ?>
<?php
}
?>
