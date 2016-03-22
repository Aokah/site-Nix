<?php function testpage ()
{

global $_POST, $db, $_SESSION;

  $max = $db->query('SELECT COUNT(*) AS idmax FROM members'); $max = $max->fetch();
  $idmax = $max['idmax'] ;
  
  echo $idmax;
  $id = $idmax;
  while ($id > 0)
  {
    echo $id,'<br />';
    $select = $db->prepare('SELECT * FROM members WHERE id = ?');
    $select->execute(array($id));
    
      if ($select = $select->fetch())
      {
        echo 'PMs :' , $select['E_magique'], '<br />PVs :', $select['E_vitale'], '<br />level :' , $select['magie_rank'];
      }
    $id --;
  }
  
}
?>
