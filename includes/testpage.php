<?php function testpage()
{
  global $_POST, $db, $_GET;
  if ($_SESSION['connected'])
  {
    ?>
    <h2>Votre candidature</h2>
    <?php
    $verif = $db->prepare('SELECT * FROM members WHERE id = ?');
    $verif->execute(array($_SESSION['id'])); $verif = $verif->fetch();
    if ($_SESSION['rank'] > 4)
    {
    ?>
    <p>Affichage MJ</p>
    <?
    }
    elseif ($verif['accepted'] == 0)
    {
    ?>
    <p>Affichage Joueur non candidatié</p>
    <?php
    }
    else
    {
      echo '<p>Vous avez déjà passé votre candidature.</p>';
    }
  }
  else
  {
    echo '<p>Veuillez vous connecter pour accéder à cette page.</p>';
  }
}
?>
