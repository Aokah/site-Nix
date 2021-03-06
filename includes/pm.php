<?php function pm ()
{
global $_SESSION, $db, $_GET;

if ($_SESSION['connected'])
{
?>
 <h2>Messagerie Privée</h2>
 <p>Sur cette page vous pourrez discuter avec les membres de manière plus approfondie que sur la ChatBox.</p>
 <? if (isset($_GET['action']))
 {
  if ($_GET['action'] == "send")
  {
    $to = intval($_GET['to']);
    $ifto = (isset($_GET['to'])) ? '&to='. $to .'' : '';
    $select = $db->prepare('SELECT id, name FROM members WHERE id = ?'); $select->execute(array($to)); $select = $select->fetch();
    $name = htmlspecialchars($_POST['target']);
    $toid = (isset($_POST['send'])) ? $_POST['target'] : $select['name'];
    $presel = $db->prepare('SELECT id,name FROM members WHERE name = ?'); $presel->execute(array($name)); 
    if (isset($_POST['send']) AND isset($_POST['subject']) AND $presel = $presel->fetch() AND isset($_POST['pm']))
    {
     $insert = $db->prepare("INSERT INTO private_message VALUES('',?,?,NOW(),?,?,'1','0')");
     $insert->execute(array(htmlspecialchars($_POST["subject"]), htmlspecialchars($_POST['pm']), $_SESSION['id'], $presel['id']));
     echo '<p>Votre message a bien été envoyé.<p> <p><a href="index?p=pm">Cliquez ici pour retourner à la page des Messages Privés</a></p>';
    }
    else
    {
     ?>
     <?php if (isset($_POST['send'])) { ?><p style="color:red;">Navré, mais certains champs sont mal renseignés ou non complétés, réessayez.</p> <? } ?>
     <form action="index?p=pm&action=send<?=$ifto?>" method="POST">
      <table cellspacing="0" cellpadding="10" width="70%" align="center" style="border: black solid 2px;">
       <tbody>
        <tr>
         <td width="15%" style="background-color:#DDDDDD;"><label for="subject">Sujet :</label></td><td colspan="2" style="background-color:#DDDDDD;"><input type="text" name="subject" id="subject" value="<?= $_POST['subject']?>" /></td>
        </tr>
        <tr>
         <td width="15%" style="background-color:#DDDDDD;"><label for="target">Destinataire :</label></td><td colspan="2" style="background-color:#DDDDDD;"><input type="text" name="target" id="target" value="<?= $toid?>" /></td>
        </tr>
        <tr>
         <td colspan="3"><textarea name="pm" width="100%" style="width: 1000px; height: 150px;"><?=$_POST['pm']?></textarea></td>
        </tr>
        <tr>
         <td colspan="2">[Envoie d'image (bientôt disponible ?)]</td> <td style="text-align:right;"><input type="submit" name="send" value="Envoyer" /></td>
        </tr>
       </tbody>
      </table>
     </form>
     <?php
    }
  }
 }
 elseif (isset($_GET['pm']))
 {
  $pm = intval($_GET['pm']);
  $select = $db->prepare('SELECT pm.id pm_id, pm.subject, pm.from_id, pm.message, pm.to_id, pm.date_send, pm.unread, m.id, m.name, m.title, m.ban, m.removed
    FROM private_message pm
    RIGHT JOIN members m ON to_id = m.id 
    WHERE pm.id = ?'); $select->execute(array($pm));
    if ($line = $select->fetch())
    {
     if ($line['to_id'] == $_SESSION['id'])
     {
      $presel = $db->prepare('SELECT*  FROM members WHERE id = ?'); $presel->execute(array($line['from_id'])); $presel = $presel->fetch();
      $update = $db->prepare('UPDATE private_message SET unread = 0 WHERE id = ?'); $update->execute(array($pm));
      if ($presel['ban'] == 1) { $title = "Banni"; } elseif ($presel['removed'] == 1) { $title = "Oublié"; } else { $title = $presel['title']; }
      $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', 'Le $3/$2/$1 à $4', $line['date_send']);
      $message = preg_replace('#\n#', '<br />', $line['message']);
     ?>
     <a href="index?p=pm&action=send&to=<?= $presel['id']?>">[Répondre]</a>
     <table cellspacing="0" cellpadding="10" width="100%" style="border: 3px solid black; ">
      <tbody>
       <tr>
        <th style="background-color:#DDDDDD;">Sujet</th> <th style="background-color:#DDDDDD;">Auteur</th> <th style="background-color:#DDDDDD;">Date d'envoi</th>
       </tr>
       <tr>
        <td style="text-align:center;background-color:#CCCCCC; border-bottom: #333333 solid 4px;"><?= $line['subject']?></td>
        <td style="text-align:center;background-color:#CCCCCC; border-bottom: #333333 solid 4px;"><?= $title, ' ' , $presel['name']?></td>
        <td style="text-align:center;background-color:#CCCCCC; border-bottom: #333333 solid 4px;"><?= $date; ?></td>
       </tr>
       <tr>
        <td colspan="3" style="padding:1%;"><?= $message ?></td>
       </tr>
      </tbody>
     </table>
     <?php
     }
     else
     {
      echo '<p>Désolé mais ce message ne vous est pas adressé.</p>';
     }
    }
    else
    {
     echo '<p>Navré, mais ce MP n\'existe pas.</p>';
    }
 }
 else
 {
  ?>
  <a href="index?p=pm&action=send">[Ecrire un nouveau message]</a>
  <table cellspacing="0" cellpadding="10" width="100%">
   <tbody>
    <tr>
     <th style="background-color:#DDDDDD;border:black solid 1px" colspan="2">Sujet :</th>
     <th style="background-color:#DDDDDD;border:black solid 1px" width="20%">Auteur :</th>
     <th style="background-color:#DDDDDD;border:black solid 1px" width="20%">Date de réception :</th>
     <th style="background-color:#DDDDDD;border:black solid 1px" width="10%">Action :</th>
    </tr>
    <?php 
    $select = $db->prepare('SELECT pm.id pm_id, pm.subject, pm.from_id, pm.to_id, pm.date_send, pm.unread, m.id, m.name, m.title, m.ban, m.removed
    FROM private_message pm
    RIGHT JOIN members m ON pm.to_id = m.id 
    WHERE pm.to_id = ? AND pm.del = 0
    ORDER BY unread DESC, date_send DESC, subject ASC'); $select->execute(array($_SESSION['id']));
    
    while ($line = $select->fetch())
    {
     $presel = $db->prepare('SELECT*  FROM members WHERE id = ?'); $presel->execute(array($line['from_id'])); $presel = $presel->fetch();
     $unread = ($line['unread'] == 1) ? '<span style="color:red">[!]</span>' : '';
     if ($presel['ban'] == 1) { $title = "Banni"; } elseif ($presel['removed'] == 1) { $title = "Oublié"; } else { $title = $presel['title']; }
     $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', 'Le $3/$2/$1 à $4', $line['date_send']);
    ?>
    <tr>
     <td width="5%" style="text-align:right; border-bottom:#555555 solid 1px;border-left:#555555 solid 1px;"><?= $unread?></td>
     <td style="text-align:left;border-right:#555555 solid 1px;border-bottom:#555555 solid 1px;"><a href="index?p=pm&pm=<?= $line['pm_id']?>"><?= $line['subject']?></a></td>
     <td style="text-align:left;border-right:#555555 solid 1px;border-bottom:#555555 solid 1px;"><a href="index?p=perso&perso=<?= $presel['id']?>"><?= $title, ' ', $presel['name']?></a></td>
     <td style="text-align:left;border-right:#555555 solid 1px;border-bottom:#555555 solid 1px;"><?=$date?></td>
     <td style="text-align:center;border-right:#555555 solid 1px;border-bottom:#555555 solid 1px;"> <span style="color:red">[x]</span></td>
    </tr>
    <?php
    }
    ?>
   </tbody>
  </table>
  <?php
 }
}
else
{
 echo '<p>Veuillez vous connecter pour accéder à cette page.</p>';
}
}
?>
