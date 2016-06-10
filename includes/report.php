<?php function report ()
{
  if ($_SESSION['connected'])
  {
    echo '<h2>Rapport d\'erreur</h2>';
   # if ($_SESSION['rank'] > 4)
    #{
      // Affichage MJ
    #}
    #else
    #{
    ?>
      <p>Ici vous pourrez exposer vos problèmes / bugs trouvés sur le site ou le serveur afin que le Staff puisse le régler quand il le verra.</p>
      <p>Tout abus ou usage malhonnête de cette page pourra amener à des sanctions.</p>
      
    <?php
    #}
  }
  else
  {
    echo '<p>Vous devez être connecté pour avoir accès à cette page.</p>';
  }
}
?>
