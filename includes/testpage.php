<?php function testpage ()
{

global $_POST,$_GET, $db;
?>
  <h2>Groupes et Guildes</h2>
  <p>Ici seront regroupées les informations basiques concernant les guildes et les groupes du site</p>
  <?php
  $select = $db->prepare('SELECT gn.id, gn.name, gn.vanish, gn.guild, gm.id, gm.user_id, gm.group_id, gm.user_rank, m.id,
  m.name, m.rank, m.title
  FROM group_name gn
  RIGHT JOIN group_members gm ON gn.id = gm.group_id
  LEFT JOIN members m ON gm.user_id = m.id
  WHERE gn.id = ? AND gn.vanish = 0
  ORDER BY gn.guild DESC, gn.name ASC');
  $select->execute(array($id));
  ?>
<?php
}
?>
