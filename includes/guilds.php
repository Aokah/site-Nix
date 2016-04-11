<?php function guilds ()
{
global $_POST,$_GET, $db;


?>
  <h2>Groupes et Guildes</h2>
  <p>Ici seront regroupées les informations basiques concernant les guildes et les groupes du site</p>
  <?php
  $select = $db->query('SELECT id, name, vanish, guild FROM group_name WHERE vanish = 0 ORDER BY guild DESC, name ASC');
  if ($_SESSION['id'] < 5) {
  $select2 = $db->prepare('SELECT gn.name, gn.id, gm.user_id, gm.group_id, gm. user_id
  FROM group_name gn 
  RIGHT JOIN group_members gm ON group_id = gn.id
  WHERE user_id = ? AND user_rank > 3
  ORDER BY gn.name ASC');
  $select2->execute(array($_SESSION['id']));
  } else { $select2  = $db->query('SELECT * FROM group_name WHERE ORDER BY name ASC'); }
  if ($_SESSION['rank'])
  ?>
  <form action="index.php" method="GET">
    <input type="hidden" name="p" value="guilds" />
    Ajout d'un nouveau membre : <input type="text" name="add" />
    <select>
      <?php
      while ($option = $select2->fetch())
      {
        ?>
        <option value="<?= $option['id']?>"><?= $option['name']?></option>
        <?php
      }
      ?>
    </select>
    <input type="submit" name="end" value="Confirmer" />
  </form>
  <?php
  while ($line = $select->fetch())
  {
    $sel = $db->prepare('SELECT gm.id, gm.user_id, gm.group_id, gm.user_rank, m.id, m.name, m.rank, m.title
    FROM group_members gm
    RIGHT JOIN members m ON gm.user_id = m.id
    WHERE gm.group_id = ?
    ORDER BY gm.user_rank DESC, m.rank DESC, m.name ASC');
    $sel->execute(array($line['id']));
    $prefixe = ($line['guild'] == 1) ? 'Guilde :: ' : 'Groupe :: ';
  ?>
  <h3><?=$prefixe, $line['name']?></h3>
  <img src="pics/guild_<?= $line['id']?>.png" alt="" class="guild" />
  <ul>
    <?php
    while ($line2 = $sel->fetch())
    {
      if ($line2['rank'] == 9) { $rank = "titan"; } elseif ($line2['rank'] == 10) { $rank = "crea";} else { $rank = $line2['rank'];}
      $verif = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND user_rank > 3 AND user_rank > ?');
      $verif->execute(array($_SESSION['id'], $line2['user_rank']));
      ?>
      <li>
        [G<?= $line2['user_rank']?>] <img src="pics/rank<?= $rank?>.png" alt="" class="magie_type" width="25" /> <?= $line2['title'], ' ', $line2['name']?> <?php
        if ($_SESSION['rank'] > 5 OR $verif->fetch()) {
          ?><a href="index?p=guilds&del=<?= $line2['user_id']?>&from=<?= $line['id']?>" class="name7">[X]</a> <a href="index?p=guilds&up=<?= $line2['user_id']?>&from=<?= $line['id']?>" class="name5">[+]</a> <a href="index?p=guilds&down=<?= $line2['user_id']?>&from=<?= $line['id']?>" class="name6">[-]</a><?
        }?>
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
