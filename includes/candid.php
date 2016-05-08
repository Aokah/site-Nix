<?php function candid()
{
  global $_POST, $db, $_GET;
  if ($_SESSION['connected'])
  {
    ?>
    <p>Page ne cours de maintenance.
    Pour effectuer votre candidature manuellement, rendez-vous <a href="index?p=forum&forum=412">ici</a> !</p>
    <?php
    $verif = $db->prepare('SELECT * FROM members WHERE id = ?');
    $verif->execute(array($_SESSION['id'])); $verif = $verif->fetch();
    if ($_SESSION['rank'] > 4)
    {
      if (isset($_GET['valid']))
      {
        $candid = intval($_GET['valid']);
        $sel = $db->prepare('SELECT c.id AS c_id, c.sender_id, c.pseudo_mc, c.candid, c.date_send, c.verify, m.id, m.title, m.name
        FROM candid c
        RIGHT JOIN members m ON m.id = c.sender_id
        WHERE c.id = ?');
        $sel->execute(array($candid));
        if ($line = $sel->fetch())
        {
          if ($line['verify'] == 0)
          {
            if (isset($_POST['valid']))
            {
              
            }
            else
            {
              $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line['date_send']);
            ?>
              <h3>Validation de Candidature</h3>
              <form action="index?p=candid&valid=<?= $candid?>" method="POST">
                <p>
                  <textarea width="100%" name="reason">Noter ici votre commentaire . . .</textarea>
                  <input type="submit" name="valid" value="Envoyer" />
                </p>
              </form>
              
              <p>Pour rappel, voici la candidature déposée par <?= $line['name']?>.</p>
              
              <table cellspacing="0" cellpadding="5px" width="100%">
              <tbody>
                <tr class="member_top">
                  <th>Joueur</th>
                  <th>Date d'envoi</th>
                  <th>Pseudo MC</th>
                  <th>Candidature</th>
                </tr>
                <tr class="memberbg_2" valign="center" style="text-align:center;;">
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
              </tbody>
            </table>
          <?php
            }
          }
          else
          {
            echo '<p>Navré, mais ce joueur a déjà passé sa candidature.';
          }
        }
        else
        {
          echo '<p>Navré mais cette candidature n\'existe pas ou a déjà été vérifiée.</p>';
        }
      }
      elseif (isset($_GET['unvalid']))
      {
        
      }
      else
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
  
      <table cellspacing="0" cellpadding="5px" width="100%">
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
          <tr class="memberbg_2" valign="center" style="text-align:center;;">
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
          <tr class="memberbg_2" valign="center" style="text-align:center;">
            <td colspan="3" style="border-bottom:3px dashed black;">
              <a href="index?p=candid&valid=<?= $line['c_id']?>">
                [Valider la Candidature]
              </a>
            </td>
            <td style="border-bottom:3px dashed black;">
              <a href="index?p=candid&unvalid=<?= $line['c_id']?>">
                [Refuser la Candidature]
              </a>
            </td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
      
      </form>
      <?
      }
      else
      {
      ?>
      <p> Il n'y a actuellement aucune candidature en attente de lecture :).</p>
      <?php
      }
      }
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
