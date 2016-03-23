<?php function testpage ()
{

global $_POST, $db, $_SESSION;

  $max = $db->query('SELECT COUNT(*) AS idmax FROM members WHERE id != 0'); $max = $max->fetch();
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
        
        $ajout = $select['E_magique'] + 30;
        
        
        if ($ajout > $limit AND $select['E_magique'] < ($limit))
        {
          $add = $limit + 30 - $ajout;
        }
        elseif ($ajout < $limit) { $add = 30; }
        else
        { $add = 0; }
        $finaladd = $select['E_magique'] + $add;
        $maj = $db->prepare('UPDATE members SET = E_magique = ?');
        $maj->execute(array($finaladd));
      }
    $id --;
  }
}
?>
