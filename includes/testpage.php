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
          case "Métal": $type = 9; break; case "Nature": $type = 10; break; case "Ombre": $type = 11; break; case "Ordre": $type = 12; break;
          case "Psy": $type = 13; break; case "Températures": $type = 14; break; case "Terre": $type = 15; break; case "Void": $type = 16; break;
        }
        $select = $db->prepare('SELECT * FROM skil_list WHERE type = ? ORDER BY number ASC'); $select->execute(array($type));
        if ($_GET['element'] == "Air")
        {
          ?>
          <table cellspacing="0" cellpadding="10" class="">
            <tbody>
              <tr>
                <th> </th>
                <th>Compétence</th>
                <th>Description</th>
              </tr>
              <?php while ($line = $select->fetch())
              {
              ?>
              <tr>
                <td><?= $cost?></td>
                <td><?= $line['name']?></td>
                <td><?= $line['infos']?></td>
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
