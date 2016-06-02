<?php function testpage()
{
  global $_SESSION, $_POST, $db;
  
  if ($_SESSION['connected'])
  {
    $verif = $db->prepare('SELECT id, testm FROM members WHERE id = ? AND testm = 0');
    $verif->execute(array($_SESSION['id']));
    if ($verif->fetch())
    {
      if (isset($_POST['valid']))
      {
        
      }
      else
      {
        
      }
    }
    else
    {
      echo '<p>NAvré, mais vous avez déjà passé ce test.</p>';
    }
  }
  else
  {
    echo '<p>Vous devez vous connecter pour accéder à cette page.</p>';
  }
}
?>
