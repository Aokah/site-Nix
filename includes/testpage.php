<?php function testpage()
{
  global $db;
  $limit = 17;
  while ($limit > 0)
  {
    $select = $db->prepare('SELECT g.id g_id, user_id, skil_id, l.id, l.name, l.cost, l.type, l.infos, l.number
    FROM skil_get g
    RIGHT JOIN skil_list l ON g.skil_id = l.id
    WHERE user_id= ? AND type = ?
    ORDER BY number ASC');
    $select->execute(array($_SESSION['id'], $limit));
    $limit --;
  }
}
?>
