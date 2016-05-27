<?php function testpage()
{
  global $db, $_SESSION, $_POST, $_GET;
  
  $select = $db->prepare('SELECT id, specialisation, spe_2 FROM members WHERE id = ?'); $select->execute(array($_SESSION['id']));
  $select = $select->fetch();
  ?>
  <a href="index.php?p=testpage&element=Air"><img src="pics/ico/Magie_Air.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie de l'Air" alt="" /></a>
	<? if ($select['specialisation'] == "Arcane" OR $select['spe_2'] == "Arcane" OR $_SESSION['rank'] > 5) {?>	<a href="index.php?p=testpage&element=Arcane"><img src="pics/ico/Magie_Arcane.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie de l'Arcane" alt="" /></a><? } ?>
	<? if ($select['specialisation'] == "Chaos" OR $select['spe_2'] == "Chaos" OR $_SESSION['rank'] > 5) {?>	<a href="index.php?p=testpage&element=Chaos"><img src="pics/ico/Magie_Chaos.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie du Chaos" alt="" /></a><? } ?>
		<a href="index.php?p=testpage&element=Eau"><img src="pics/ico/Magie_Eau.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie de l'Eau" alt="" /></a>
		<a href="index.php?p=testpage&element=Energie"><img src="pics/ico/Magie_Energie.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie de l'Energie" alt="" /></a>
		<a href="index.php?p=testpage&element=Feu"><img src="pics/ico/Magie_Feu.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie du Feu" alt="" /></a>
		<a href="index.php?p=testpage&element=Glace"><img src="pics/ico/Magie_Glace.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie de la Glace" alt="" /></a>
		<a href="index.php?p=testpage&element=Lumiere"><img src="pics/ico/Magie_Lumiere.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie de la Lumière" alt="" /></a>
		<a href="index.php?p=testpage&element=Metal"><img src="pics/ico/Magie_Metal.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie du Metal" alt="" /></a>
		<a href="index.php?p=testpage&element=Nature"><img src="pics/ico/Magie_Nature.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie de la Nature" alt="" /></a>
		<a href="index.php?p=testpage&element=Ombre"><img src="pics/ico/Magie_Ombre.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie de l'Ombre" alt="" /></a>
		<a href="index.php?p=testpage&element=Psy"><img src="pics/ico/Magie_Psy.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie du Psy" alt="" /></a>
		<a href="index.php?p=testpage&element=Terre"><img src="pics/ico/Magie_Terre.png" width="<?= $width?>" class="magie_type" title="Selectionner la magie de la Terre" alt="" /></a>
  <?php
  
      if (isset($_GET['element']))
      {
        switch ($_GET['element'])
        {
          case 'Air' : $type = 1; break; case 'Arcane': $type = 2; break; case 'Chaos': $type = 3; break; case "Eau": $type = 4; break;
          case "Energie": $type = 5; break; case "Espace": $type = 6; break; case "Feu": $type = 7; break; case "Glace": $type = 8; break;
          case "Lumiere" : $type = 9; break; case "Metal": $type = 10; break; case "Nature": $type = 11; break;
          case "Ombre": $type = 12; break; case "Ordre": $type = 13; break; case "Psy": $type = 14; break;
          case "Chaleur": $type = 15; break; case "Terre": $type = 16; break; case "Void": $type = 17; break;
        }
        $select = $db->prepare('SELECT * FROM skil_list WHERE type = ? ORDER BY number ASC'); $select->execute(array($type));
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
      else
      {
        //Selection
      }
}
?>
