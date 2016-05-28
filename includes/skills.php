<?php function skills()
{
  global $db, $_SESSION, $_POST, $_GET;
  
  if ($_SESSION['connected']) {
    //if ($_SESSION['rank'] > 4) {
      
    if (isset($_GET['upgrade']))
    {
      $type = intval($_GET['upgrade']);
      if ($_GET['upgrade'] >= 1 AND $_GET['upgrade'] <= 17)
      {
        if (isset($_GET['confirm']))
        {
          $id = intval($_GET['confirm']);
          $vget = $db->prepare('SELECT id FROM skil_get WHERE id = ?'); $vget->execute(array($id));
          // Vérifie si la compétence n'est pas déjà apprise -^
          // Vérifie s'il n'y a pas d'autres compétences à apprendre avant ->
          $verify = $db->prepare('SELECT * FROM skil_get WHERE user_id = ?'); $verify->execute(array($_SESSION['id']));
          $scount = 1;
          while ($line = $verify->fetch())
          {
            $verify_ = $db->prepare('SELECT * FROM skil_list WHERE id = ? AND type = ?'); $verify_->execute(array($line['skil_id'], $type));
            if ($verify_->fetch())
            {
              $scount ++;
            }
          }
          $select = $db->prepare('SELECT * FROM skil_list WHERE type = ? AND number = ?'); $select->execute(array($type, $scount));
          if ($select = $select->fetch())
          {
            if ($id < $scount)
            {
              echo '<p>Navré mais vous possédez déjà cette compétence.</p>';
                '<p><a href="index?p=skills">Retourner à la page des Compétences.</a></p>';
            }
            elseif ($id > $scount)
            {
              echo '<p>Navré mais vous devez apprendre d\'autres compétences avant d\'apprendre celle-ci.</p>';
                '<p><a href="index?p=skills">Retourner à la page des Compétences.</a></p>';
            }
            elseif ($id == $scount)
            {
              $presel = $db->prepare('SELECT exp, id FROM members WHERE id = ?'); $presel->execute(array($_SESSION['id'])); $presel = $presel->fetch();
              $verif = $db->prepare('SELECT cost, id FROM skil_list WHERE id = ?'); $verif->execute(array($id)); $verif = $verif->fetch();
              if ($presel['exp'] >= $verif['cost'])
              {
                //Retrait des PCs
                $final = $presel['exp'] - $verif['cost'];
                $update = $db->prepare('UPDATE members SET exp = ?'); $update->execute(array($final));
                $add = $db->prepare("INSERT INTO skil_get VALUES('',?, ?)"); $add->execute(array($_SESSION['id'], $select['id']));
                echo '<p>Compétence acquise avec succès !</p>',
                '<p><a href="index?p=skills">Retourner à la page des Compétences.</a></p>';
              }
              else
              {
                echo '<p>Navré, mais vous ne possédez pas assez de Points de Compétence.</p>',
                '<p><a href="index?p=skills">Retourner à la page des Compétences.</a></p>';
              }
            }
            else
            {
              echo '<p>Une erreur s\'est produite.</p>',
                '<p><a href="index?p=skills">Retourner à la page des Compétences.</a></p>';
            }
          }
          else
          {
            echo '<p>Navré mais cette compétence n\'existe pas.</p>',
                '<p><a href="index?p=skills">Retourner à la page des Compétences.</a></p>';
          }
        }
        else
        {
          $verif = $db->prepare('SELECT * FROM skil_get WHERE user_id = ?'); $verif->execute(array($_SESSION['id']));
          $scount = 1;
          while ($line = $verif->fetch())
          {
            $verify = $db->prepare('SELECT * FROM skil_list WHERE id = ? AND type = ?'); $verify->execute(array($line['skil_id'], $type));
            if ($verify->fetch())
            {
              $scount ++;
            }
          }
          $select = $db->prepare('SELECT * FROM skil_list WHERE type = ? AND number = ?'); $select->execute(array($type, $scount));
          if ($select = $select->fetch())
          {
          ?>
          <table align="center" cellpadding="10" cellspacing="0">
            <tbody>
              <tr>
                <td colspan="2" style="text-align:center;">Débloquer cette compétence</td>
              </tr>
              <tr>
                <th style="text-align:center; background-color:black; color:white;">Compétence</td>
                <th style="text-align:center; background-color:black; color:white;">Description</td>
              </tr>
              <tr>
                <td style="text-align:center; background-color:black; color:white;"><?= $select['name']?></td>
                <td style="text-align:center; background-color:black; color:white;"><?=$select['infos']?></td>
              </tr>
              <tr>
                <td colspan="2" style="text-align:center;">Contre <?=$select['cost']?> Points de Compétences ?</td>
              </tr>
              <tr>
                <td colspan="2" style="text-align:center;"><a href="index?p=skills&upgrade=<?= $type?>&confirm=<?= $select['id']?>">[Confirmer la décision]</a></td>
              </tr>
              <tr>
                <td colspan="2" style="text-align:center;"><a href="index?p=skills">[Retourner à la séléction des éléments]</a></td>
              </tr>
            </tbody>
          </table>
          <?php
          }
          else
          {
            echo '<p>Une erreur s\'est produite, peut-être que vous n\'avez pas d\'autres compétences à acquérir dans cet élément.</p>',
                '<p><a href="index?p=skills">Retourner à la page des Compétences.</a></p>';
          }
        }
      }
      else
      {
        echo '<p>Qu\'essaies-tu ? De monter tes compétences magiques dans un élément qui n\'esiste pas ?</p>',
                '<p><a href="index?p=skills">Retourner à la page des Compétences.</a></p>';
      }
    }
    else
    {
      $select = $db->prepare('SELECT id, specialisation, spe_2, exp FROM members WHERE id = ?'); $select->execute(array($_SESSION['id']));
      $select = $select->fetch();
      $plural = ($select['exp'] > 1)? 's' : '';
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
      <h2>Mes Aptitudes</h2>
      <p>Cette page vous servira à répartir vos différents points de compétence et de vous informer sur les aptitudes de votre personnage dans le domaine de la Magie.</p>
      <p class="name3">Vous êtes actuellement spécialisé en <span class="name6"><?=$select['specialisation']?></span><?
      if ($select['spe_2'] != "Inconnue") {?>et <span class="name7"><?=$select['spe_2']?></span><?php } ?>. Il est donc vivement conseillé d'attribuer vos points dans <?php
      if ($select['spe_2'] != "Inconnue") { echo 'ces '; } else { echo 'ce '; } ?> domaine<?php
      if ($select['spe_2'] != "Inconnue") { echo 's'; }?>.</p>
      <table cellspacing="0" cellpadding="10" width="100%">
      	<tbody>
      	  <tr>
      	    <th style="text-align:center;" colspan="13">Séléction de l'élément</th>
      	  </tr>
      	  <tr>
      	    <td style="text-align:center;" colspan="13">Vous avez actuellement <?= $select['exp']?> Point<?=$plural?> de Compétence.</td>
      	  </tr>
      		<tr>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Air"><img src="pics/magie/Magie_Air.png" width="<?= $width1?>" class="magie_type" title="Selectionner la magie de l'Air" alt="" /></a>
      			</td>
      			<? if ($select['specialisation'] == "Arcane" OR $select['spe_2'] == "Arcane" OR $_SESSION['rank'] > 5) {?>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Arcane"><img src="pics/magie/Magie_Arcane.png" width="<?= $width2?>" class="magie_type" title="Selectionner l'Essence de l'Arcane" alt="" /></a>
      			</td>
      			<?php } ?>
      			<? if ($select['specialisation'] == "Chaos" OR $select['spe_2'] == "Chaos" OR $_SESSION['rank'] > 5) {?>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Chaos"><img src="pics/magie/Magie_Chaos.png" width="<?= $width3?>" class="magie_type" title="Selectionner l'Essence du Chaos" alt="" /></a>
      			</td>
      			<?php } ?>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Eau"><img src="pics/magie/Magie_Eau.png" width="<?= $width4?>" class="magie_type" title="Selectionner la magie de l'Eau" alt="" /></a>
      			</td>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Energie"><img src="pics/magie/Magie_Energie.png" width="<?= $width5?>" class="magie_type" title="Selectionner la magie de l'Energie" alt="" /></a>
      			</td>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Feu"><img src="pics/magie/Magie_Feu.png" width="<?= $width6?>" class="magie_type" title="Selectionner la magie du Feu" alt="" /></a>
      			</td>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Glace"><img src="pics/magie/Magie_Glace.png" width="<?= $width7?>" class="magie_type" title="Selectionner la magie de la Glace" alt="" /></a>
      			</td>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Lumiere"><img src="pics/magie/Magie_Lumière.png" width="<?= $width8?>" class="magie_type" title="Selectionner la magie de la Lumière" alt="" /></a>
      			</td>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Metal"><img src="pics/magie/Magie_Métal.png" width="<?= $width9?>" class="magie_type" title="Selectionner la magie du Metal" alt="" /></a>
      			</td>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Nature"><img src="pics/magie/Magie_Nature.png" width="<?= $width10?>" class="magie_type" title="Selectionner la magie de la Nature" alt="" /></a>
      			</td>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Ombre"><img src="pics/magie/Magie_Ombre.png" width="<?= $width11?>" class="magie_type" title="Selectionner la magie de l'Ombre" alt="" /></a>
      			</td>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Psy"><img src="pics/magie/Magie_Psy.png" width="<?= $width12?>" class="magie_type" title="Selectionner la magie du Psy" alt="" /></a>
      			</td>
      			<td style="text-align:center;">
      				<a href="index?p=skills&element=Terre"><img src="pics/magie/Magie_Terre.png" width="<?= $width13?>" class="magie_type" title="Selectionner la magie de la Terre" alt="" /></a>
      			</td>
      		</tr>
      	</tbody>
      </table>
      <?php
      
          if (isset($_GET['element']))
          {
            switch ($_GET['element'])
            {
              case 'Air' : { $type = 1; break;} case 'Arcane': {$type = 2; break; }case 'Chaos': {$type = 3; break;} case "Eau": {$type = 4; break;}
              case "Energie": { $type = 5; break;} case "Espace":{ $type = 6; break;} case "Feu": {$type = 7; break;} case "Glace":{ $type = 8; break;}
              case "Lumiere" : { $type = 9; break;} case "Metal":{ $type = 10; break;} case "Nature":{ $type = 11; break;}
              case "Ombre":{  $type = 12; break;} case "Ordre":{ $type = 13; break; }case "Psy": {$type = 14; break;}
              case "Chaleur": { $type = 15; break;} case "Terre":{ $type = 16; break;} case "Void": {$type = 17; break;}
            }
            $select = $db->prepare('SELECT * FROM skil_list WHERE type = ? ORDER BY number ASC'); $select->execute(array($type));
              $cost = 0;
              ?>
              <table cellspacing="0" cellpadding="10" background="pics/ico/skil_<?= $_GET['element']?>.png" class="skil_tab" align="center" width="100%">
                <tbody>
                  <tr>
                    <td colspan="3">
                      <a href="index?p=skills&upgrade=<?= $type?>" style="color:white;">[Obtenir une nouvelle compétence]</a>
                    </td>
                  </tr>
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
                    if ($verif->fetch())
                    {
                      $def = $line['infos'];
                      $get = 'style="color:white;"';
                      $get2 = 'color:white;';
                    }
                    elseif ($line['number'] == 1 OR $_SESSION['rank'] > 5)
                    {
                      $def = $line['infos'];
                      $get = '';
                      $get2 = '';
                    }
                    else
                    {
                      $def = "Description Inconnue, obtenez d'autres capacités pour en savoir plus.";
                      $get = '';
                      $get2 = '';
                    }
                  ?>
                  <tr>
                    <td style="text-align:center; <?=$get2?>"><?= $cost?></td>
                    <td <?=$get?>><?= $line['name']?></td>
                    <td <?=$get?>><?= $def ?></td>
                  </tr>
                  <?php 
                  } ?>
                </tbody>
              </table>
              <?php
          }
          else
          {
            echo '<p>Veuillez cliquer sur une des icônes pour afficher la liste de copétence en rapport avec l\'élément séléctionné.</p>';
          }
    }
    //}
   // else
   // {
    //  echo '<p>Page en cours de création, revenez plus tard ou informez-vous auprès d\'un Maître du Jeu.</p>';
   // }
  }
  else
  {
    echo '<p>Veuillez vous connecter pour accéder à cette page.</p>';
  }
}
?>
