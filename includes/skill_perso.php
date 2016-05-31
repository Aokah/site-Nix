<?php function skill_perso()
{
  global $db;
  $perso = intval($_GET['perso']);
  $limit = 17;
  while ($limit > 0)
  {
    $select = $db->prepare('SELECT g.id g_id, user_id, skil_id, l.id, l.name, l.cost, l.type, l.infos, l.number
    FROM skil_get g
    RIGHT JOIN skil_list l ON g.skil_id = l.id
    WHERE user_id= ? AND type = ?
    ORDER BY number ASC');
    $select->execute(array($perso, $limit));
    switch ($limit)
    {
      case 1 : { $type = "Air"; break;} case 2: {$type = "Arcane"; break; } case 3 : {$type = "Chaos"; break;} case 4: {$type = "Eau"; break;}
      case 5: { $type = "Energie"; break;} case 6:{ $type = "Espace"; break;} case 7: {$type = "Feu"; break;} case 8:{ $type = "Glace"; break;}
      case 9 : { $type = "Lumiere"; break;} case 10:{ $type = "Metal"; break;} case 11:{ $type = "Nature"; break;}
      case 12:{  $type = "Ombre"; break;} case 13:{ $type = "Ombre"; break; }case 14: {$type = "Psy"; break;}
      case 15: { $type = "Chaleur"; break;} case 16:{ $type = "Terre"; break;} case 17 : {$type = "Void"; break;}
    }
    $count = $db->prepare('SELECT COUNT(*) AS count
    FROM skil_get g RIGHT JOIN skil_list l ON g.skil_id = l.id
    WHERE l.type = ? AND g.user_id = ?'); $count->execute(array($limit, $perso));
    $count = $count->fetch();
    if ($count['count'] > 0)
    {
    ?>
    <table cellpadding="15" cellspacing="0" background="pics/ico/skil_<?= $type?>.png" class="skil_tab" align="center" width="100%">
      <tbody>
       <tr>
        <th style="color:#ffffff;" colspan="2"><?= $type?></th>
      </tr>
      <tr>
       <th style="color:#ffffff;">Compétence</th>
       <th style="color:#ffffff;">Description</th>
      </tr>
      <?php while ($line = $select->fetch())
      {
       ?>
       <tr>
         <td style="color:#ffffff;"><?= $line['name']?></td>
         <td style="color:#ffffff;"><?= $line['infos'] ?></td>
       </tr>
       <?php 
        } ?>
      </tbody>
    </table>
    <?php
    }
    $limit --;
  }
}
?>
