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
    else
    {
      if ($_SESSION['rank'] > 4)
      {
       ?>
       <div>
         <h3>Liste des</h3>
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
          <option value="8">Autres . . .</option>
        </select>
        <div align="center"><textarea placeholder="Notez ici le problème que vous avez rencontré . . ." name="report" style="width: 500px; height: 200px;"></textarea></div>
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
            default : $type = "Problème de type \"autre\" reporté"; break;
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
            ?>
            <tr>
              <td>Date de réponse : <?= $date_?></td>
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
