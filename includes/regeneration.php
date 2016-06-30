<?php function regeneration()
{
global $_POST, $db, $_SESSION;
    
    $select_ = $db->query('SELECT * FROM members');
    
      while ($select = $select_->fetch())
      {
        if ($select['magie_rank'] == 0) { $limit = 50; } elseif ($select['magie_rank'] == 1) { $limit = 100; } elseif ($select['magie_rank'] == 2) { $limit = 150; }
        elseif ($select['magie_rank'] == 3) { $limit = 200; } elseif ($select['magie_rank'] == 4) { $limit = 300; } elseif ($select['magie_rank'] == 5) { $limit = 400; }
        elseif ($select['magie_rank'] == 6) { $limit = 500; } 
        
        $ajout = $select['E_magique'] + 30;
        
        
        if ($ajout > $limit AND $select['E_magique'] < $limit)
        {
          $add = $limit + 30 - $ajout;
        }
        elseif ($ajout <= $limit) { $add = 30; }
        else
        { $add = 0; }
        
        $vajout = $select['E_vitale'] + 10;
        
        if ($vajout > 200 AND $select['E_vitale'] < 200)
        {
          $vadd = 200 + 10 - $vajout;
        }
        elseif ($vajout <= 200) { $vadd = 10; }
        else
        { 
            $vadd = 0; 
            
        }
        $maj = $db->prepare('UPDATE members SET E_magique = E_magique + ?, E_vitale = E_vitale + ? WHERE id = ?');
        $maj->execute(array($add, $vadd, $select['id']));
      }
}
  ?>
