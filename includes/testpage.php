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
      $select = $db->query('SELECT COUNT(*) AS count FROM candid WHERE verify = 0');
      $select = $select->fetch();
    ?>
    <h2>Lecture des candidatures</h2>
    <p>Ici sont répertoriées les différentes candidatures d'entrée à Nix n'étant pas encore validée.</p>
    <? if ($select['count'] > 0)
    {
    ?>
    <p>Il y a actuellement <?=$count, ' candidature', $plural; ?> en attente de lecture.</p>
    <?
    }
    else
    {
    ?>
    <p> Il n'y a actuellement aucune candidature en attente de lecture :).</p>
    <?php
    }
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
