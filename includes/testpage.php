<?php function testpage ()
{

global $_POST, $db, $_SESSION;

  $max = $db->query('SELECT COUNT(*) AS idmax FROM members'); $max = $max->fetch();
  $idmax = $max['idmax'] ;
  
  $id = $idmax;
  
  $test = 5 - 10;
  echo $test, '<br />';
  while ($id > 0)
  {
    echo $id,'<br />';
    $select = $db->prepare('SELECT * FROM members WHERE id = ?');
    $select->execute(array($id));
    
      if ($select = $select->fetch())
      {
        if ($select['magie_rank'] == 0) { $limit = 50; } elseif ($select['magie_rank'] == 1) { $limit = 100; } elseif ($select['magie_rank'] == 2) { $limit = 150; }
        elseif ($select['magie_rank'] == 3) { $limit = 200; } elseif ($select['magie_rank'] == 4) { $limit = 300; } elseif ($select['magie_rank'] == 5) { $limit = 400; }
        elseif ($select['magie_rank'] == 6) { $limit = 500; } else { $limit = 0; }
        
        $dif = $limit - $select['E_magique'];
        if ($dif < 0) { echo 'négatif'; } else { echo 'positif';}
        
        echo 'id = ', $id, '<br />PMs :' , $select['E_magique'], '<br />PVs :', $select['E_vitale'], '<br />level :' , $select['magie_rank'], '<br />';
      }
    $id --;
  }
  
}
?>
