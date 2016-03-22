<?php function testpage ()
{

global $_POST, $db, $_SESSION;

  $max = $db->query('SELECT COUNT(*) AS idmax FROM members'); $max = $max->fetch();
  $idmax = $max['idmax'] ;
  
  echo $idmax;
  //while
  //{
    
    
  //}
  
}
?>
