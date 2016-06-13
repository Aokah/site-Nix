<?php function report ()
{
  global $_POST, $db;
  
  if ($_SESSION['connected'])
  {
    echo '<h2>Rapport d\'erreur</h2>';
   
    if (isset($_POST['send']))
    {
      $report = htmlspecialchars($_POST['report']);
      $insert = $db->prepare("INSERT INTO report VALUES('',NOW(),?,?,?,0,0,'','')"); $insert->execute(array($_POST['type'], $report, $_SESSION['id']));
      echo '<p>Votre rapport a bien été enregistré.<p>
      <p><a href="index?p=report">Cliquez ici</a> pour retourner à la page précédente.</p>';
    }
    elseif (isset($_GET['answer']) AND $_SESSION['rank'] > 4)
    {
      $id = intval($_GET['answer']);
      if (isset($_POST['valid']))
      {
        $select = $db->prepare('SELECT * FROM report WHERE id = ?'); $select->execute(array($id)); $line = $select->fetch();
        
        $sel = $db->prepare('SELECT id, name, rank, technician, pionier, removed, ban, title FROM members WHERE id = ?');
        $sel->execute(array($line['resolver_id'])); $line_ = $sel->fetch();
        $tech = ($line_['technician'] == 1)? '-T' : '';
        $pionier = ($line_['pionier'] == 1)? '-P' : '';
        if ($line_['pionier'] == 1) { $title ="Pionier"; } elseif ($line_['ban'] == 1) { $title = "Banni"; }
        elseif ($line_['removed'] == 1) { $title = "Oublié"; } else { $title = $line_['title']; }
                    
        $respond = htmlspecialchars($_POST['respond']);
        $update = $db->prepare('UPDATE report SET resolve = ?, resolver_id = ?, respond = ?, resolve_date = NOW()');
        $update->execute(array($_POST['state'], $_SESSION['id'], $respond));
        if ($_POST['state'] != 0)
        {
          if ($_POST['state'] == 1)
          {
          $pm = "Voici la réponse de" .$title. " " .$line_['name']. " à votre rapport d'erreur :<br /><br />" . $respond .
          "<br />Merci de nous avoir signalé cette erreur ! <br /> Shirka, le robot du Staff";
          }
          elseif ($_POST['state'] == 2)
          {
          $pm = "Voici la réponse de" .$title. " " .$line_['name']. " à votre rapport d'erreur classé sans suite :<br /><br />" . $respond .
          "<br />Merci tout de même de nous avoir signalé cette erreur ! <br /> Shirka, le robot du Staff";
          }
          else
          {
            $pm = "Voici la réponse de" .$title. " " .$line_['name']. " à votre rapport d'erreur défini comme insoluble :<br /><br />" . $respond .
          "<br />Merci tout de même de nous avoir signalé cette erreur ! <br /> Shirka, le robot du Staff";
          }
          $insert = $db->prepare("INSERT INTO private_message VALUE ('','[Page Erreur] : Réponse', ?, NOW(),92, ?,1,0 )");
          $insert->execute(array($pm, $line['reporter_id']));
        }
        echo '<p>Rapport édité ! <a href="index?p=report">Cliquez ici</a> pour retourner à la page des Rapports d\'Erreur.</p>';
      }
      else
      {
        $select = $db->prepare('SELECT * FROM report WHERE id = ?'); $select->execute(array($id));
        if ($line = $select->fetch())
        {
        switch ($line['type'])
              {
                case 1: $type = "Bug rencontré sur le serveur"; break; case 2: $type = "Grief repéré sur le Serveur"; break; case 3: $type = "RPQ surpris sur le serveur"; break;
                case 4: $type = "Triche constatée sur le serveur"; break; case 5: $type = "Abus de pouvoir constaté par un Membre du Staff"; break;
                case 6: $type = "\"Fatal Error\" détectée sur une page du site !"; break; case 7: $type ="Bug d'affichage repéré sur le site"; break;
                default : $type = "Problème de type \"autre\" reporté"; break; case 9: $type ="Faute d'orthographe sur le site."; break;
              }
              $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line['date']);
              $date_ = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line['resolve_date']);
              $respond = preg_replace('#\n#', '<br />', $line['respond']);
              $report = preg_replace('#\n#', '<br />', $line['text']);
              switch ($line['resolve'])
              {
                default: $state = "loader.gif"; $desc = "Problème encore en attente de résolution."; break;
                case 1: $state = "tick.png"; $desc = "Problème résolu !"; break;
                case 2: $state = "unresolved.gif"; $desc = "Problème classé sans suite."; break;
                case 3: $state = "impossible.gif"; $desc = "Problème insoluble."; break;
              }
              $tech = ($line['technician'] == 1)? '-T' : '';
                  $pionier = ($line['pionier'] == 1)? '-P' : '';
                  if ($line['pionier'] == 1) { $title ="Pionier"; } elseif ($line['ban'] == 1) { $title = "Banni"; } elseif ($line['removed'] == 1) { $title = "Oublié"; } else { $title = $line['title']; }
            ?>
            <form action="index?p=report&answer=<?= $id?>" method="POST">
              <input type="submit" name="valid" value="Terminer" />
              <table cellspacing="0" cellpadding="5" width="100%" style="border: 5px gray solid; border-radius: 10px; background-color: #DDDDDD;text-shadow: white 1px 1px 4px;">
                <tbody>
                  <tr style="background-color:#BBBBBB;">
                    <th><?= $type?></th>
                  </tr>
                  <tr>
                    <td>Etat d'analyse du problème : <select name="state">
                      <option value="0">En cours. . .</option>
                      <option value="1">Résolu !</option>
                      <option value="2">Non résolu</option>
                      <option value="3">Impossible</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Date d'envoi : <?= $date?></td>
                  </tr>
                  <tr>
                    <td>Envoyé par : <span class="name<?=$line['rank'],$tech,$pionier?>"><?= $title , ' ' , $line['name']?></span></td>
                  </tr>
                  <tr>
                    <td>Problème :
                    <p><?= $report?></p></td>
                  </tr>
                  <?php
                    $sel = $db->prepare('SELECT id, name, rank, technician, pionier, removed, ban, title FROM members WHERE id = ?');
                    $sel->execute(array($line['resolver_id'])); $answ = $sel->fetch();
                    $tech = ($answ['technician'] == 1)? '-T' : '';
                    $pionier = ($answ['pionier'] == 1)? '-P' : '';
                    if ($answ['pionier'] == 1) { $title ="Pionier"; } elseif ($answ['ban'] == 1) { $title = "Banni"; } elseif ($answ['removed'] == 1) { $title = "Oublié"; } else { $title = $answ['title']; }
                  ?>
                  <tr>
                    <td>Date de la dernière réponse : <?= $date_?></td>
                  </tr>
                  <tr>
                    <td>Par : <span class="name<?=$answ['rank'],$tech,$pionier?>"><?= $title , ' ' , $answ['name']?></span></td>
                  </tr>
                  <tr>
                    <td>Réponse :
                    <p><textarea name="respond"><?= $line['respond']?></textarea></p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
           <?php
        }
        else
        {
          echo '<p>Navré, mais cette requête n\'existe pas.</p>';
        } 
      }
    }
    else
    {
      if ($_SESSION['rank'] > 4)
      {
       ?>
       <div>
         <h3>Liste des Problèmes enregistrés</h3>
         <p>Ici est listé les problèmes listés par date d'envoie et par statut !</p>
          <?php
          $select = $db->prepare('SELECT * FROM report ORDER BY resolve_date DESC, id DESC'); $select->execute(array($_SESSION['id']));
          while ($line = $select->fetch())
          {
            switch ($line['type'])
            {
              case 1: $type = "Bug rencontré sur le serveur"; break; case 2: $type = "Grief repéré sur le Serveur"; break; case 3: $type = "RPQ surpris sur le serveur"; break;
              case 4: $type = "Triche constatée sur le serveur"; break; case 5: $type = "Abus de pouvoir constaté par un Membre du Staff"; break;
              case 6: $type = "\"Fatal Error\" détectée sur une page du site !"; break; case 7: $type ="Bug d'affichage repéré sur le site"; break;
              default : $type = "Problème de type \"autre\" reporté"; break; case 9: $type ="Faute d'orthographe sur le site."; break;
            }
            $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line['date']);
            $date_ = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line['resolve_date']);
            $respond = preg_replace('#\n#', '<br />', $line['respond']);
            $report = preg_replace('#\n#', '<br />', $line['text']);
            switch ($line['resolve'])
            {
              default: $state = "loader.gif"; $desc = "Problème encore en attente de résolution."; break;
              case 1: $state = "tick.png"; $desc = "Problème résolu !"; break;
              case 2: $state = "unresolved.gif"; $desc = "Problème classé sans suite."; break;
              case 3: $state = "impossible.gif"; $desc = "Problème insoluble."; break;
            }
            $tech = ($line['technician'] == 1)? '-T' : '';
                $pionier = ($line['pionier'] == 1)? '-P' : '';
                if ($line['pionier'] == 1) { $title ="Pionier"; } elseif ($line['ban'] == 1) { $title = "Banni"; } elseif ($line['removed'] == 1) { $title = "Oublié"; } else { $title = $line['title']; }
          ?>
          <a href="index?p=report&answer=<?= $line['id']?>" class="button">Etudier le problème</a>
          <table cellspacing="0" cellpadding="5" width="100%" style="border: 5px gray solid; border-radius: 10px; background-color: #DDDDDD;text-shadow: white 1px 1px 4px;">
            <tbody>
              <tr style="background-color:#BBBBBB;">
                <th><?= $type?></th>
              </tr>
              <tr>
                <td>Etat d'analyse du problème : <img src="pics/ico/<?= $state?>" width="20px" alt="" title="<?= $desc?>"/> </td>
              </tr>
              <tr>
                <td>Date d'envoi : <?= $date?></td>
              </tr>
              <tr>
                <td>Envoyé par : <span class="name<?=$line['rank'],$tech,$pionier?>"><?= $title , ' ' , $line['name']?></span></td>
              </tr>
              <tr>
                <td>Problème :
                <p><?= $report?></p></td>
              </tr>
              <?php if ($line['resolve'] == 1)
              {
                $sel = $db->prepare('SELECT id, name, rank, technician, pionier, removed, ban, title FROM members WHERE id = ?');
                $sel->execute(array($line['resolver_id'])); $answ = $sel->fetch();
                $tech = ($answ['technician'] == 1)? '-T' : '';
                $pionier = ($answ['pionier'] == 1)? '-P' : '';
                if ($answ['pionier'] == 1) { $title ="Pionier"; } elseif ($answ['ban'] == 1) { $title = "Banni"; } elseif ($answ['removed'] == 1) { $title = "Oublié"; } else { $title = $answ['title']; }
              ?>
              <tr>
                <td>Date de réponse : <?= $date_?></td>
              </tr>
              <tr>
                <td>Par : <span class="name<?=$answ['rank'],$tech,$pionier?>"><?= $title , ' ' , $answ['name']?></span></td>
              </tr>
              <tr>
                <td>Réponse :
                <p><?= $respond?></p>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
         <?php
          }
          ?>
       </div>
       <?
      }
    
    ?>
      <p>Ici vous pourrez exposer vos problèmes / bugs trouvés sur le site ou le serveur afin que le Staff puisse le régler quand il le verra.</p>
      <p>Tout abus ou usage malhonnête de cette page pourra amener à des sanctions.</p>
      <form action="index?p=report" method="POST">
        <label for="type">Sélectionnez votre type de problème : </label><select name="type">
          <option value="1">Bug In Game</option>
          <option value="2">Grief In Game</option>
          <option value="3">RPQ sur le serveur</option>
          <option value="4">Tricherie explicite</option>
          <option value="5">Abus de pouvoir d'un Staffeux</option>
          <option value="6">"Fatal Error" sur le site</option>
          <option value="7">Bug d'affichage site</option>
          <option value="9">Faute d'orthographe sur le site</option>
          <option value="8">Autres . . .</option>
        </select>
        <br /><textarea placeholder="Notez ici le problème que vous avez rencontré . . ." name="report" style="width: 500px; height: 200px;"></textarea>
        <br /><input type="submit" name="send" value="Envoyer" />
      </form>
      <?php
      $presel = $db->prepare('SELECT COUNT(*) AS count FROM report WHERE reporter_id = ?'); $presel->execute(array($_SESSION['id']));
      $presel = $presel->fetch();
      if ($presel['count'] > 0)
      {
        ?>
        <h3>Requête de votre part classées par date d'envoi</h3>
        <?php
        $select = $db->prepare('SELECT * FROM report WHERE reporter_id = ?'); $select->execute(array($_SESSION['id']));
        while ($line = $select->fetch())
        {
          switch ($line['type'])
          {
            case 1: $type = "Bug rencontré sur le serveur"; break; case 2: $type = "Grief repéré sur le Serveur"; break; case 3: $type = "RPQ surpris sur le serveur"; break;
            case 4: $type = "Triche constatée sur le serveur"; break; case 5: $type = "Abus de pouvoir constaté par un Membre du Staff"; break;
            case 6: $type = "\"Fatal Error\" détectée sur une page du site !"; break; case 7: $type ="Bug d'affichage repéré sur le site"; break;
            case 9: $type ="Faute d'orthographe sur le site."; break; default : $type = "Problème de type \"autre\" reporté"; break;
          }
          $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line['date']);
          $date_ = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line['resolve_date']);
          $respond = preg_replace('#\n#', '<br />', $line['respond']);
          $report = preg_replace('#\n#', '<br />', $line['text']);
          switch ($line['resolve'])
          {
            default: $state = "loader.gif"; $desc = "Problème encore en attente de résolution."; break;
            case 1: $state = "tick.png"; $desc = "Problème résolu !"; break;
            case 2: $state = "unresolved.gif"; $desc = "Problème classé sans suite."; break;
            case 3: $state = "impossible.gif"; $desc = "Problème insoluble."; break;
          }
        ?>
        <table cellspacing="0" cellpadding="5" width="100%" style="border: 5px gray solid; border-radius: 10px; background-color: #DDDDDD;text-shadow: white 1px 1px 4px;">
          <tbody>
            <tr style="background-color:#BBBBBB;">
              <th><?= $type?></th>
            </tr>
            <tr>
              <td>Etat d'analyse du problème : <img src="pics/ico/<?= $state?>" width="20px" alt="" title="<?= $desc?>"/> </td>
            </tr>
            <tr>
              <td>Date d'envoi : <?= $date?></td>
            </tr>
            <tr>
              <td>Problème :
              <p><?= $report?></p></td>
            </tr>
            <?php if ($line['resolve'] == 1)
            {
              $sel = $db->prepare('SELECT id, name, rank, technician, pionier, removed, ban, title FROM members WHERE id = ?');
              $sel->execute(array($line['resolver_id'])); $answ = $sel->fetch();
              $tech = ($answ['technician'] == 1)? '-T' : '';
              $pionier = ($answ['pionier'] == 1)? '-P' : '';
              if ($answ['pionier'] == 1) { $title ="Pionier"; } elseif ($answ['ban'] == 1) { $title = "Banni"; } elseif ($answ['removed'] == 1) { $title = "Oublié"; } else { $title = $answ['title']; }
            ?>
            <tr>
              <td>Date de réponse : <?= $date_?></td>
            </tr>
            <tr>
              <td>Par : <span class="name<?=$answ['rank'],$tech,$pionier?>"><?= $title , ' ' , $answ['name']?></span></td>
            </tr>
            <tr>
              <td>Réponse :
              <p><?= $respond?></p>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
       <?php
        }
      }
    }
  }
  else
  {
    echo '<p>Vous devez être connecté pour avoir accès à cette page.</p>';
  }
}
?>
