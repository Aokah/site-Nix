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
      $select = $db->prepare('SELECT * FROM dev WHERE id = ?'); $select->execute(array($ask));
      if ($line = $select->fetch())
      {
        $ok = ($line['isok'] == 1) ? '<img src="pics/ico/tick.png" title="Tâche terminée" alt="" width="25%" />' : '<span title="Tâche non encore terminée" class="name7" width="100%">X</span>';
        $input = ($line['isok'] == 1) ? '<input type="submit" name="unvalid" stle="color:red;" value="Marquer comme tâche en cours" />' : '<input type="submit" name="valid" stle="color:green;" value="Marquer comme terminée" />' ;
          switch ($line['type'])
          {
            case 1 : $type = "Ajout d'une nouveau sort"; break; case 2: $type = "Ajout d'une nouvelle commande"; break;
          }
          $details = preg_replace('#\n#', '<br />', $line['details']);
      ?>
      <form method="POST" action="index?p=dev&ask=<?=$line['id']?>">
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
      if (isset($_GET['action']))
      {
        if ($_GET['action'] == 'create')
        {
          ?>
          <p>
            <form method="POST" action="index?p=dev&action=valid">
              <table cellspacing="5" scellpadding="0" align="center" width="50%" style="text-align:center;">
        <tbody>
          <tr>
            <th class="bgth">Type de tâche</th>
            <th class="bgth">Requête</th>
          </tr>
          <tr>
            <td class="bgtd"><select name="type">
              <option value="1">Ajout d'un nouveau sort</option>
              <option value="2">Ajout d'une nouvelle commande</option>
            </select></td>
          <td class="bgtd"><input type="text" name="ask" /></td>
          </tr>
          <tr>
            <th colspan="2" class="bgth">Détails</th>
          </tr>
          <tr>
            <td colspan="2" class="bgtd"><textarea width="100%" name="details"></textarea></td>
          </tr>
        </tbody>
      </table>
            </form>
          </p>
          <?php
        }
        elseif ($_GET['action'] == "valid")
        {
          $type = htmlspecialchars($_POST['type']);
          $details = htmlentities($_POST['details']);
          $ask = htmlspecialchars($_POST['ask']);
          if (isset($type) AND isset($details) AND isset($ask))
          {
            $insert = $db->prepare("INSERT INTO dev VALUE('', ?, ?, ?, 0)"); $insert->execute(array($type, $ask,$details));
          }
          else
          {
            echo '<p>Erreur, il vous manque des informations.</p>';
          }
        }
      }
      else
      {
      if ($_SESSION['name'] == "Nikho")
      {
        echo '<p><a href="index?p=dev&action=create">Créer une nouvelle tâche</a></p>';
      }
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
            case 1 : $type = "Ajout d'une nouveau sort"; break; case 2: $type = "Ajout d'une nouvelle commande"; break;
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
  }
  else
  {
    echo 'Page inexistante.';
  }
}
?>
