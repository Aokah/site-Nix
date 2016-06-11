<?php function report ()
{
  global $_POST, $db;
  
  if ($_SESSION['connected'])
  {
    echo '<h2>Rapport d\'erreur</h2>';
   
    if (isset($_POST['send']))
    {
      $report = htmlspecialchars($_POST['report']);
      $insert = $db->prepare("INSERT INTO report VALUES('',NOW(),?,?,?,1,0,'','')"); $insert->execute(array($_POST['type'], $report, $_SESSION['id']));
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
        $select = $db->prepare('SELECT * FROM report WHERE sender_id = ?'); $select->execute(array($_SESSION['id']));
        while ($line = $select->fetch())
        {
        ?>
        <table cellspacing="0" cellpadding="0" width="100%" style="border: 5px gray solid; border-radius: 10px; background-color: #DDDDDD;text-shadow: white 1px 1px 4px;">
          <tbody>
            <tr style="background-color:#BBBBBB;">
              <th><?= $type?></th>
            </tr>
            <tr>
              <td>Etat d'analyse du problème : <img src="pics/ico/<?= $state?>" alt="" title="<?= $desc?>"/> </td>
            </tr>
            <tr>
              <td>Date d'envoi : <?= $date?></td>
            </tr>
            <tr>
              <td>Problème :
              <p><?= $report?></p></td>
            </tr>
            <tr>
              <td>Date de réponse : <?= $date_?></td>
            </tr>
            <tr>
              <td>Réponse :
              <p><?= $respond?></p>
              </td>
            </tr>
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
