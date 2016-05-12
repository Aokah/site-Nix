<?php function candid()
{
  global $_POST, $db, $_GET;
  if ($_SESSION['connected'])
  {
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
              $verif = $db->prepare('SELECT id, verify FROM candid WHERE id = ? AND verify = 0');
              $verif->execute(array($candid));
              if ($verif->fetch())
              {
                $reason = htmlspecialchars($_POST['reason']);
                $update = $db->prepare('UPDATE candid SET verify = 1, reason = ?, valider_id = ?, accepted = 1, date_verify = NOW() WHERE id = ?');
                $update->execute(array($reason, $_SESSION['id'],$candid));
                echo '<p>La candidature a bien été validée !</p>';
                $msg = "Candidature validée pour ". $line['name'] ." !";
                $cb = $db->prepare("INSERT INTO chatbox VALUES('',NOW(),92,0,'',?)");
                $cb->execute(array($msg));
                $select = $db->prepare('SELECT * FROM members WHERE id = ?'); $select->execute(array($_SESSION['id'])); $session = $select->fetch();
                $title = $session['title']; if ($session['pionier'] == 1) { $title = "Pionier"; }
                if (isset($reason))
                {
                 $pm = "Votre candidature candidature vient d'être acceptée par " . $title . " " . $_SESSION['name'] . ' avec  le commentaire ci-joint :<br />'
                  . $reason . 
                ' <br />Vous pouvez désormais accéder au serveur avec l\'ip ci-dessous !<br />62.210.232.129:10414 <br /><br />Au plaisir de vous revoir en jeu !<br /><br />Shirka';
                }
                else
                {
                $pm = "Votre candidature candidature vient d'être acceptée par " . $title . " " . $_SESSION['name'] .
                '. <br />Vous pouvez désormais accéder au serveur avec l\'ip ci-dessous !<br />62.210.232.129:10414 <br /><br />Au plaisir de vous revoir en jeu !<br /><br />Shirka';
                }
                $insert = $db->prepare("INSERT INTO private_message VALUE('','[Réponse] : Candidature', ?, NOW(), 92, ?, 1)");
                $insert->execute(array($pm, $line['sender_id']));
                $verify = $db->prepare('SELECT id, rank FROM members WHERE id= ? ANd rank = 1');
                $verify->execute(array($line['sender_id']));
                if ($verify->fetch())
                {
                  $upgrade = $db->prepare('UPDATE members SET rank = 2 WHERE id = ?');
                  $upgrade->execute(array($line['sender_id']));
                }
              }
              else
              {
              ?>
              <img src="pics/tf7.png" width="100%" alt="" /><br />
              <p>Navré, mais un autre MJ a été plus rapide que vous !</p>
              <?php
              }
            }
            else
            {
              $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line['date_send']);
            ?>
              <h3>Validation de Candidature</h3>
              <form action="index?p=candid&valid=<?= $candid?>" method="POST">
                <p>
                  <textarea width="100%" name="reason"  placeholder="Noter ici votre commentaire . . ."></textarea><br />
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
        $candid = intval($_GET['unvalid']);
        $sel = $db->prepare('SELECT c.id AS c_id, c.sender_id, c.pseudo_mc, c.candid, c.date_send, c.verify, m.id, m.title, m.name
        FROM candid c
        RIGHT JOIN members m ON m.id = c.sender_id
        WHERE c.id = ?');
        $sel->execute(array($candid));
        if ($line = $sel->fetch())
        {
          if ($line['verify'] == 0)
          {
            if (isset($_POST['unvalid']))
            {
              $verif = $db->prepare('SELECT id, verify FROM candid WHERE id = ? AND verify = 0');
              $verif->execute(array($candid));
              if ($verif->fetch())
              {
                $reason = htmlspecialchars($_POST['reason']);
                $update = $db->prepare('UPDATE candid SET verify = 1, reason = ?, valider_id = ?, accepted = 0, date_verify = NOW() WHERE id = ?');
                $update->execute(array($reason, $_SESSION['id'],$candid));
                echo '<p>La candidature a bien été refusée !</p>';
                $msg = "Candidature non retenue, rendez-vous en page Messages Privés pour en savoir plus.";
                $cb = $db->prepare("INSERT INTO chatbox VALUES('',NOW(),92,?,'',?)");
                $cb->execute(array($line['sender_id'], $msg));
                $select = $db->prepare('SELECT * FROM members WHERE id = ?'); $select->execute(array($_SESSION['id'])); $session = $select->fetch();
                $title = $session['title']; if ($session['pionier'] == 1) { $title = "Pionier"; }
                if (isset($reason))
                {
                 $pm = "Votre candidature candidature vient d'être refusée par " . $title . " " . $_SESSION['name'] . ' avec  le commentaire ci-joint :<br />'
                  . $reason . 
                ' <br />Relisez-bien tous les onglets d\'information à votre disposition ou veillez à ce que l\'orthographe de votre candidature reste correcte puis réessayez.<br /><br />Shirka';
                }
                else
                {
                $pm = "Votre candidature candidature vient d'être refusée par " . $title . " " . $_SESSION['name'] .
                '. <br />Relisez-bien tous les onglets d\'information à votre disposition ou veillez à ce que l\'orthographe de votre candidature reste correcte puis réessayez.<br /><br />Shirka';
                }
                $insert = $db->prepare("INSERT INTO private_message VALUE('','[Réponse] : Candidature', ?, NOW(), 92, ?, 1)");
                $insert->execute(array($pm, $line['sender_id']));
                $verify = $db->prepare('SELECT id, rank FROM members WHERE id= ? ANd rank = 1');
                $verify->execute(array($line['sender_id']));
                if ($verify->fetch())
                {
                  $upgrade = $db->prepare('UPDATE members SET rank = 2, accepted = 1 WHERE id = ?');
                  $upgrade->execute(array($line['sender_id']));
                }
                else
                {
                  $upgrade = $db->prepare('UPDATE members SET accepted = 1 WHERE id = ?');
                  $upgrade->execute(array($line['sender_id']));
                }
              }
              else
              {
              ?>
              <img src="pics/tf7.png" width="100%" alt="" /><br />
              <p>Navré, mais un autre MJ a été plus rapide que vous !</p>
              <?php
              }
            }
            else
            {
              $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', '$3/$2/$1 à $4', $line['date_send']);
            ?>
              <h3>Refus de Candidature</h3>
              <form action="index?p=candid&unvalid=<?= $candid?>" method="POST">
                <p>
                  <textarea width="100%" name="reason"  placeholder="Noter ici votre commentaire . . ."></textarea><br />
                  <input type="submit" name="unvalid" value="Envoyer" />
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
            echo '<p>Navré, mais cette candidature a déjà été vérifiée.';
          }
        }
        else
        {
          echo '<p>Navré mais cette candidature n\'existe pas.</p>';
        }
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
      ?>
      <h2>Votre candidature</h2>
      <?php
      $verif = $db->prepare('SELECT * FROM candid WHERE accepted = 0, sender_id = ?');
      $verif->execute(array($_SESSION['id']));
      if ($verif->fetch())
      {
        $verif = $db->query('SELECT COUNT(*) AS count FROM candid WHERE verify = 0');
        if ($count = $verif->fetch())
        {
         $count = $count['count'];
         if ($count == 1)
         {
           echo '<p>Votre candidature est pour le moment la seule en attente et devrait être examinée rapidement, revenez d\'ici quelques instants</p>';
         }
         else
         {
           $cleft = $count--;
           $plural = ($cleft == 1)? '' : 's';
           echo '<p>Il y a actuellement ' . $c_left .' candidature'. $plural.' en attente de lecture auprès de la votre. Patientez quelques temps, un membre du Staff ne devrait pas tarder à la lire.</p>';
         }
        }
      }
      else
      {
        if (isset($_POST['send']))
        {
          $mc = htmlspecialchars($POST['mc']);
          $candid = htmlentities($_POST['candid']);
          $verif = $db->prepare('SELECT Minecraft_Account from members WHERE Minecraft_Account = ?');
          $verif->execute(array($mc));
          if ($verif->fetch())
          {
          ?>
            <h3>Ecrivez ici votre candidature</h3>
        <p>Afin de vous garantir une intégration convenable sur le serveur, il est nécessaire pour nous de connaitre votre niveau de jeu et vos motivations de venir jouer parmi nous.</p>
        <p style="color:red;">Pour rappel : Il est vivement conseillé de ne pas mentionner le fait que vous soyez un quelconque mage de puissante renomée, mieux vaut découvrir le système technique de la magie en RP, ceci vous permettra également de profiter de l'apprentissage sur le vif.</p>
        <p>
        <form action="index?p=candid" method="POST">
          <input type="text" name="mc" value="<?= $mc?>" placeholder="Votre pseudo Minecraft" />
          <span style="color:red;">NAvré, mais ce compte Minecraft est déjà utilisé.</span>
          <textarea name="candid" placeholder="&Ecute;crivez votre candidature ici . . ."><?= $candid?></textarea>
          <input name="send" value="Envoyer" />
        </form>
        </p>
        <?php
          }
          else
          {
            $insert = $db->prepare("INSERT INTO candid VALUE('',?, ?, ?, NOW(), 0, 0, '', '', 0)");
            $insert->execute(array($_SESSION['id'], $mc, $candid));
            echo '<p>Votre candidature a bien été envoyée et est déosrmais en attente de validation !</p>';
          }
        }
        else
        {
      ?>
        <h3>Ecrivez ici votre candidature</h3>
        <p>Afin de vous garantir une intégration convenable sur le serveur, il est nécessaire pour nous de connaitre votre niveau de jeu et vos motivations de venir jouer parmi nous.</p>
        <p style="color:red;">Pour rappel : Il est vivement conseillé de ne pas mentionner le fait que vous soyez un quelconque mage de puissante renomée, mieux vaut découvrir le système technique de la magie en RP, ceci vous permettra également de profiter de l'apprentissage sur le vif.</p>
        <p>
        <form action="index?p=candid" method="POST">
          <input type="text" name="mc" placeholder="Votre pseudo Minecraft" />
          <textarea name="candid" placeholder="&Ecute;crivez votre candidature ici . . ."></textarea>
          <input name="send" value="Envoyer" />
        </form>
        </p>
        <?php
        }
      }
    }
  }
  else
  {
    echo '<p>Veuillez vous connecter pour accéder à cette page.</p>';
  }
}
?>
