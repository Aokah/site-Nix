<?php function testpage_2 ()
{
  global $_POST, $_GET, $_SESSION, $db;
  
?>
  <h2>Page Test pour les Incantations</h2>
  
<?php
  if (isset($_GET['i']))
  {
    ?>
    <h3>Vision du sort à l'unité (Modo +)</h3>
    <?php
  }
  elseif (isset($_GET['p']))
  {
  ?> 
    <h3>Liste des sorts d'un joueur</h3>
  <?php
  }
  elseif(isset($_GET['action']))
  {
    if ($_GET['action'] == "unvalided")
    {
  ?>
  <h3>Liste des sorts non validés</h3>
  <?php
    } else { echo 'Action invalide (Bien tenté !)'; }
  }
  else
  {
  ?>
  <h3>Mes sorts</h3>
  <?php
  }
}
?>
