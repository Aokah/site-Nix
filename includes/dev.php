<?php function dev()
{
global $db, $_GET, $_POST, $_SESSION;
  if ($_SESSION['name'] == "Nikho" OR $_SESSION['name'] == "Lune")
  {
    if (isset($_GET['ask']))
    {
      if (isset($_POST['valid']))
      {
        $update = $db->prepare('UPDATE dev SET isok = 1 WHERE id = ?'); $update->execute(array($_POST['id']));
        echo '<p>Tâche validée avec succès !</p> <p><a href="index?p=dev">Retour à la page précéente</a></p>';
      }
      elseif (isset($_POST['unvalid']))
      {
        $update = $db->prepare('UPDATE dev SET isok = 0 WHERE id = ?'); $update->execute(array($_POST['id']));
        echo '<p>Tâche invalidée avec succès !</p> <p><a href="index?p=dev">Retour à la page précéente</a></p>';
      }
      else
      {
      $ask = intval($_GET['ask']);
      $select $db->prepare('SELECT * FROM dev WHERE id = ?'); $select->execute(array($ask));
      if ($line = $select->fetch())
      {
        $ok = ($line['isok'] == 1) ? '<img src="pics/ico/tick.png" title="Tâche terminée" alt="" width="25%" />' : '<span title="Tâche non encore terminée" class="name7" width="100%">X</span>';
        $input = ($line['isok'] == 1) ? '<input type="submit" name="unvalid" stle="color:red;" value="Marquer comme tâche en cours" />' : '<input type="submit" name="valid" stle="color:green;" value="Marquer comme terminée" />' ;
          switch ($line['type'])
          {
            case 1 : $type = "Ajout d'un Sort"; break;
          }
          $details = preg_replace('#\n#', '<br />', $line['details']);
      ?>
      <form method="POST" action="index?p=dev">
        <input type="hidden" value="<?= $line['id']?>" name="id" />
        <table cellspacing="5" scellpadding="0" align="center" width="50%" style="text-align:center;">
        <tbody>
          <tr>
            <th class="bgth">Type de tâche</th>
            <th class="bgth">Requête</th>
            <th class="bgth">Terminée ?</th>
          </tr>
          <tr>
            <td class="bgtd"><?= $type?></td>
          <td class="bgtd"><a href="index?p=dev&ask=<?= $line['id']?>"><div style="padding:3%"><?= $line['ask']?></div></a></td>
          <td class="bgtd" width="20%"><?= $ok?></td>
          </tr>
          <tr>
            <th colspan="3" class="bgth">Détails</th>
          </tr>
          <tr>
            <td colspan="3" class="bgtd"><?=$details?></td>
          </tr>
          <tr>
            <td style="text-alging:center;" colspan="3"><?= $input?></td>
          </tr>
        </tbody>
      </table>
      </form>
      <?php
      }
      else
      {
        echo '<p align="center">Une erreur s\'est produite.</p>';
      }
      }
    }
    else
    {
      ?>
      <table cellspacing="5" scellpadding="0" align="center" width="50%" style="text-align:center;">
        <tbody>
          <tr>
            <th class="bgth">Type de tâche</th>
            <th class="bgth">Requête</th>
            <th class="bgth">Terminée ?</th>
          </tr>
      <?php
      $select = $db->query('SELECT * FROM dev ORDER BY isok ASC, id ASC');
        while ($line = $select->fetch())
        {
          $ok = ($line['isok'] == 1) ? '<img src="pics/ico/tick.png" title="Tâche terminée" alt="" width="25%" />' : '<span title="Tâche non encore terminée" class="name7" width="100%">X</span>';
          switch ($line['type'])
          {
            case 1 : $type = "Ajout d'un Sort"; break;
          }
        ?>
        <tr>
          <td class="bgtd"><?= $type?></td>
          <td class="bgtd"><a href="index?p=dev&ask=<?= $line['id']?>"><div style="padding:3%"><?= $line['ask']?></div></a></td>
          <td class="bgtd" width="20%"><?= $ok?></td>
        </tr>
        <?php
        }
      ?>
        </tbody>
      </table>
      <?php
    }
  }
  else
  {
    echo 'Page inexistante.';
  }
}
?>
