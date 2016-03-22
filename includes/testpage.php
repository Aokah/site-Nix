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
        elseif ($select['magie_rank'] == 6) { $limit = 500; } else { $limit = 0; }
        
        $dif = $select['E_magique'] + 30;
        if ($dif < $limit) { $ajout = $dif; } else { $ajout = 0;}
        $add = $db->prepare('UPDATE members SET E_magique = ? WHERE id = ?');
        $add->execute(array($ajout, $id));
        
        $diff = $select['E_vitale'] + 10;
        if ($diff < 200) { $addvie = $diff; } else { $addvie = 0; }
        $vie = $db->prepare('UPDATE members SET E_vitale = ? WHERE id = ?');
        $vie->execute(array($addvie, $id));
      }
    $id --;
  }
  
}
?>
