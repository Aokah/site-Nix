<?php function background()
{
  global $_GET, $_POST, $db, $_SESSION;
  if ($_SESSION['connected'])
  {
    if ($_SESSION['rank'] > 4)
    {
      if (isset($_GET['type']))
      {
        $type = intval($_GET['type']);
        if (!isset($_GET['sub']))
        {
        ?>
        <table cellspacing="5" cellpadding="10">
            <tbody>
              <tr>
                <th colspan="2">Types de sujets</th>
                <th>Niveau de visionnage</th>
              </tr>
        <?php
        $select = $db->prepare('SELECT * FROM bg_sub WHERE type_id = ? AND level <= ?'); $select->execute(array($type, $_SESSION['rank']));
        while ($line = $select->fetch())
        {
          switch ($line['level']) 
          {
            case 5: $level = "Modérateur"; break; case 6: $level = "Maître du Jeu"; break; case 7: $level = "Opérateur"; break;
          }
        ?>
              <tr>
                <td><img src="pics/ico/bg_type_<?= $type?>&sub=<?= $line['id']?>" alt="" /></td>
                <td><a href="index?p=background&type=<?= $type?>&sub=<?= $line['id']?>"><?= $line['subject']?></a></td>
                <td><?= $level?></td>
              </tr>
        <?php
        }
        ?>
            </tbody>
          </table>
        <?php
        }
        if (isset($_GET['sub']))
        {
          $sub = intval($_GET['sub']);
          if (isset($_GET['id']))
          {
            // Détails du BG
          }
          else
          {
            // BGs
          }
        }
        else
        {
          //Liste des sous-type
        }
      }
      else
      {
       $select = $db->prepare('SELECT * FROM bg_type WHERE level <= ? ORDER BY type ASC'); $select->execute(array($_SESSION['rank']));
       ?>
          <table cellspacing="5" cellpadding="10">
            <tbody>
              <tr>
                <th colspan="2">Sujets Généraux</th>
                <th>Niveau de visionnage</th>
              </tr>
        <?php
        while ($line = $select->fetch())
        {
          switch ($line['level']) 
          {
            case 5: $level = "Modérateur"; break; case 6: $level = "Maître du Jeu"; break; case 7: $level = "Opérateur"; break;
          }
          ?>
              <tr>
                <td><img src="pics/ico/bg_type_<?= $line['id']?>" alt="" /></td>
                <td><a href="index?p=background&type=<?= $line['id']?>"><?= $line['type']?></a></td>
                <td><?= $level?></td>
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
      echo '<p>Vous n\'avez pas le niveau requis pour accéder à cette page.</p>';
    }
  }
  else
  {
    echo '<p>Connectez-vous pour accéder à cette page.</p>';
  }
}
?>
