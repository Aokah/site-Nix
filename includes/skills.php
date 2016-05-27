<?php function skills()
{
  global $db, $_SESSION, $_POST, $_GET;
  
  if ($_SESSION['connected']) {
    if ($_SESSION['rank'] > 4) {
      
    $select = $db->prepare('SELECT id, specialisation, spe_2 FROM members WHERE id = ?'); $select->execute(array($_SESSION['id']));
    $select = $select->fetch();
    $width1 = ($_GET['element'] == "Air")? '60' : '40';
    $width2 = ($_GET['element'] == "Arcane")? '60' : '40';
    $width3 = ($_GET['element'] == "Chaos")? '60' : '40';
    $width4 = ($_GET['element'] == "Eau")? '60' : '40';
    $width5 = ($_GET['element'] == "Energie")? '60' : '40';
    $width6 = ($_GET['element'] == "Feu")? '60' : '40';
    $width7 = ($_GET['element'] == "Glace")? '60' : '40';
    $width8 = ($_GET['element'] == "Lumiere")? '60' : '40';
    $width9 = ($_GET['element'] == "Metal")? '60' : '40';
    $width10 = ($_GET['element'] == "Nature")? '60' : '40';
    $width11 = ($_GET['element'] == "Ombre")? '60' : '40';
    $width12 = ($_GET['element'] == "Psy")? '60' : '40';
    $width13 = ($_GET['element'] == "Terre")? '60' : '40';
    
    ?>
    <p>Cette page vous servira à répartir vos différents points de compétence et de vous informer sur les aptitudes de votre personnage dans le domaine de la Magie.</p>
    <p class="name4">Vous êtes actuellement spécialisés en <span class="name7"><?=$select['specialisation']?></span><?
    if ($select['spe_2'] != "Inconnue") {?>et <span class="name7"><?=$select['spe_2']?></span><?php } ?>. Il est donc vivement conseillé d'attribuer vos points dans <?php
    if ($select['spe_2'] != "Inconnue") { echo 'ces '; } else { echo 'ce '; } ?> domaine<?php
    if ($select['spe_2'] != "Inconnue") { echo 's'; }?>.</p>
    <table cellspacing="0" cellpadding="10" width="100%">
    	<tbody>
    	  <tr>
    	    <th style="text-align:center;" colspan="13">Séléction de l'élément</th>
    	  </tr>
    		<tr>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Air"><img src="pics/magie/Magie_Air.png" width="<?= $width1?>" class="magie_type" title="Selectionner la magie de l'Air" alt="" /></a>
    			</td>
    			<? if ($select['specialisation'] == "Arcane" OR $select['spe_2'] == "Arcane" OR $_SESSION['rank'] > 5) {?>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Arcane"><img src="pics/magie/Magie_Arcane.png" width="<?= $width2?>" class="magie_type" title="Selectionner l'Essence de l'Arcane" alt="" /></a>
    			</td>
    			<?php } ?>
    			<? if ($select['specialisation'] == "Chaos" OR $select['spe_2'] == "Chaos" OR $_SESSION['rank'] > 5) {?>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Chaos"><img src="pics/magie/Magie_Chaos.png" width="<?= $width3?>" class="magie_type" title="Selectionner l'Essence du Chaos" alt="" /></a>
    			</td>
    			<?php } ?>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Eau"><img src="pics/magie/Magie_Eau.png" width="<?= $width4?>" class="magie_type" title="Selectionner la magie de l'Eau" alt="" /></a>
    			</td>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Energie"><img src="pics/magie/Magie_Energie.png" width="<?= $width5?>" class="magie_type" title="Selectionner la magie de l'Energie" alt="" /></a>
    			</td>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Feu"><img src="pics/magie/Magie_Feu.png" width="<?= $width6?>" class="magie_type" title="Selectionner la magie du Feu" alt="" /></a>
    			</td>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Glace"><img src="pics/magie/Magie_Glace.png" width="<?= $width7?>" class="magie_type" title="Selectionner la magie de la Glace" alt="" /></a>
    			</td>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Lumiere"><img src="pics/magie/Magie_Lumière.png" width="<?= $width8?>" class="magie_type" title="Selectionner la magie de la Lumière" alt="" /></a>
    			</td>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Metal"><img src="pics/magie/Magie_Métal.png" width="<?= $width9?>" class="magie_type" title="Selectionner la magie du Metal" alt="" /></a>
    			</td>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Nature"><img src="pics/magie/Magie_Nature.png" width="<?= $width10?>" class="magie_type" title="Selectionner la magie de la Nature" alt="" /></a>
    			</td>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Ombre"><img src="pics/magie/Magie_Ombre.png" width="<?= $width11?>" class="magie_type" title="Selectionner la magie de l'Ombre" alt="" /></a>
    			</td>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Psy"><img src="pics/magie/Magie_Psy.png" width="<?= $width12?>" class="magie_type" title="Selectionner la magie du Psy" alt="" /></a>
    			</td>
    			<td style="text-align:center;">
    				<a href="index.php?p=skills&element=Terre"><img src="pics/magie/Magie_Terre.png" width="<?= $width13?>" class="magie_type" title="Selectionner la magie de la Terre" alt="" /></a>
    			</td>
    		</tr>
    	</tbody>
    </table>
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
    else
    {
      echo '<p>Page en cours de création, revenez plus tard ou informez-vous auprès d\'un Maître du Jeu.</p>';
    }
  }
  else
  {
    echo '<p>Veuillez vous connecter pour accéder à cette page.</p>';
  }
}
?>
