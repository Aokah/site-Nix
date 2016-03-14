<?php function ban_page ()
{
  global $db, $_POST, $_SESSION, $_GET;
  
  $_SESSION['connected'] = false;
?>
  <h2>Vous avez été banni de ce site</h2>
  
  <p>Votre compte a été banni du site, probablement car vous ne respectiez pas les règles en vigueur ici.</p>
<?php
}
?>
