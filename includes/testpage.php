<?php function testpage()
{
  global $db, $_SESSION, $_POST, $_GET;
  
  $select = $db->prepare('SELECT id, specialisation, spe_2 FROM members WHERE id = ?'); $select->execute(array($_SESSION['id']));
  $select = $select->fetch();
  
      if (isset($_GET['element']))
      {
        switch ($_GET['element'])
        {
          case "Air" : $type = 1; break; case "Arcane": $type = 2; break; case "Chaos": $type = 3; break; case "Eau": $type = 4; break;
          case "Energie": $type = 5; break; case "Espace": $type = 6; break; case "Feu": $type = 7; break; case "Glace": $type = 8; break;
          case "Lumiere" : $type = 9; break; case "Metal": $type = 10; break; case "Nature": $type = 11; break;
          case "Ombre": $type = 12; break; case "Ordre": $type = 13; break; case "Psy": $type = 14; break;
          case "Chaleur": $type = 15; break; case "Terre": $type = 16; break; case "Void": $type = 17; break;
        }
        $select = $db->prepare('SELECT * FROM skil_list WHERE type = ? ORDER BY number ASC'); $select->execute(array($type));
        if ($_GET['element'] == "Air")
        {
          $cost = 0;
          ?>
          <table cellspacing="0" cellpadding="10" background="pics/ico/skil_<?= $_GET['element']?>.png" class="skil_tab" align="center" width="100%">
            <tbody>
              <tr>
                <th> </th>
                <th style="color:#ffffff;">Compétence</th>
                <th style="color:#ffffff;">Description</th>
              </tr>
              <?php while ($line = $select->fetch())
              {
                $cost = $cost + $line['cost'];
                $verif = $db->prepare('SELECT * FROM skil_get WHERE user_id = ? AND skil_id = ?');
                $verif->execute(array($_SESSION['id'], $line['id']));
                $get = ($verif->fetch()) ? 'style="color:white;"' : '';
              ?>
              <tr>
                <td <?=$get?>><?= $cost?></td>
                <td <?=$get?>><?= $line['name']?></td>
                <td <?=$get?>><?= $line['infos']?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <?php
        }
      }
      else
      {
        //Selection
      }
}
?>
