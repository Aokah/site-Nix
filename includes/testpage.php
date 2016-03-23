<?php function testpage ()
{

global $_POST, $db, $_SESSION;

  $max = $db->query('SELECT COUNT(*) AS idmax FROM members'); $max = $max->fetch();
  $idmax = $max['idmax'] ;
  
  $id = $idmax;
  
  while ($id > 0)
  {
    
    $select = $db->prepare('SELECT * FROM members WHERE id = ?');
    $select->execute(array($id));
    
      if ($select = $select->fetch())
      {
        if ($select['magie_rank'] == 0) { $limit = 50; } elseif ($select['magie_rank'] == 1) { $limit = 100; } elseif ($select['magie_rank'] == 2) { $limit = 150; }
        elseif ($select['magie_rank'] == 3) { $limit = 200; } elseif ($select['magie_rank'] == 4) { $limit = 300; } elseif ($select['magie_rank'] == 5) { $limit = 400; }
        elseif ($select['magie_rank'] == 6) { $limit = 500; } 
        
        
        if ($select['E_magique'] < $limit) { $add = 30; }
        elseif ($select['E_magique'] + 30 > $limit)
        {
          $add = ($select['E_magique'] + 30) - $limit;
        }
        else
        { $add = 0; }
        ?>
        <table>
          <tbody>
            <tr>
              <td>Nom : <?= $select['name']?></td>
              <td>Magie : <?= $select['E_magique']?></td>
              <td>Limite : <?= $limit?></td>
              <td>$add = <?=$add?></td>
            </tr>
          </tbody>
        </table>
        <?php
      }
    $id --;
  }
}
?>
