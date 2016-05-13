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
                <td><img src="pics/ico/bg_sub_<?= $line['id']?>" alt="" /></td>
                <td><a href="index?p=background&sub=<?= $line['id']?>"><?= $line['subject']?></a></td>
                <td><?= $level?></td>
              </tr>
        <?php
        }
        ?>
            </tbody>
          </table>
        <?php
      }
      elseif (isset($_GET['sub']))
      {
        $sub = intval($_GET['sub']);
        ?>
          <a href="index?p=background&type=<?=$line['type_id']?>">
            <img src="pics/ico/back.png" alt="" width="30px" />
          </a>
        <table cellspacing="5" cellpadding="10">
            <tbody>
              <tr>
                <th colspan="2">Types de sujets</th>
                <th>Niveau de visionnage</th>
              </tr>
        <?php
        $select = $db->prepare('SELECT * FROM bg_id WHERE sub_id = ? AND level <= ?'); $select->execute(array($sub, $_SESSION['rank']));
        while ($line = $select->fetch())
        {
          switch ($line['level']) 
          {
            case 5: $level = "Modérateur"; break; case 6: $level = "Maître du Jeu"; break; case 7: $level = "Opérateur"; break;
          }
        ?>
              <tr>
                <td><img src="pics/ico/bg_id_<?= $line['id']?>" alt="" /></td>
                <td><a href="index?p=background&id=<?= $line['id']?>"><?= $line['title']?></a></td>
                <td><?= $level?></td>
              </tr>
        <?php
        }
        ?>
            </tbody>
          </table>
        <?php
      }
      elseif (isset($_GET['id']))
      {
        $id = intval($_GET['id']);
        $select = $db->prepare('SELECT * FROM bg_id WHERE id = ?'); $select->execute(array($id));
        if ($line = $select->fetch())
        {
          if ($line['level'] <= $_SESSION['rank'])
          {
            $content = preg_replace('#\n#', '<br />', $line['content']);
        ?>
          <a href="index?p=background&sub=<?=$line['sub_id']?>">
            <img src="pics/ico/back.png" alt="" width="30px" />
          </a>
        <h3 style="text-align:center; background-color:#333333;border: 3px white double; color:white;padding:1%;"><?= $line['title']?></h3>
        <p style="text-align:center; background-color:#555555;border: 3px black double; color:white;padding:1%;"><?= $content?></p>
        <?php
          }
          else
          {
            echo '<p>Essaieraiu-tu de tricher et de regarder du contenu qui n\'est pas de ton niveau ? :p</p>';
          }
        }
        else
        {
          echo '<p>Désolé mais vous avez séléctionné un ID inexistant.</p>';
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
