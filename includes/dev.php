<?php function dev()
{
global $db, $_GET, $_POST, $_SESSION;
  if ($_SESSION['name'] == "Nikho" OR $_SESSION['name'] == "Lune")
  {
    if (isset($_GET['ask']))
    {
      
    }
    else
    {
      ?>
      <table cellspacing="5" scellpadding="0" align="center">
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
          $ok = ($line['isok'] == 1) ? '<img src="pics/ico/tick.png" alt="" width="100%" />' : '<span class="name7" width="100%">X</span>';
          switch ($line['type'])
          {
            case 1 : $type = "Ajout d'un Sort"; break;
          }
        ?>
        <tr>
          <td class="bgtd"><?= $type?></td>
          <td><a href="index?p=dev&ask=<?= $line['id']?>"><div style="padding:3%"><?= $line['ask']?></div></a></td>
          <td class="bgtd"><?= $ok?></td>
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
    echo 'Page inexistante.'
  }
}
?>
