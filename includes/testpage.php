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
      $sel = $db->query('SELECT c.id AS c_id, c.sender_id, c.pseudo_mc, c.candid, c.date_send, c.verify, m.id, m.title, m.name
      FROM candid c
      RIGHT JOIN members m ON m.id = c.sender_id
      WHERE verify = 0 ORDER BY date_send DESC');
    ?>
    <p>Il y a actuellement <?=$select['count'], ' candidature', $plural; ?> en attente de lecture.</p>
    
    <table cellspacing="0" cellpadding="0" width="100%">
      <tbody>
        <tr class="member_top">
          <th>Joueur</th>
          <th>Date d'envoi</th>
          <th>Pseudo MC</th>
          <th>Candidature</th>
        </tr>
        <? while ($line = $sel->fetch())
        {
        $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line['date_send']);
        ?>
        <tr class="memberbg_2" valign="center" style="text-align:center;">
          <td width="15%">
            <?= $line['name']?>
          </td>
          <td width="15%">
            <?= $date ?>
          </td>
          <td width="15%">
            <?= $line['pseudo_mc']?>
          </td>
          <td>
            <?= $line['candid']?>
          </td>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    
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
