<?php function pm ()
{
global $_SESSION, $db, $_GET;
?>
 <h2>Messagerie Privée</h2>
 <p>Sur cette page vous pourrez discuter avec les membres de manière plus approfondie que sur la ChatBox.</p>
 <? if (isset($_GET['action']))
 {
  if ($_GET['action'] == "send")
  {
    $to = intval($_GET['to']);
    ?>
    
    <?php
  }
 }
 elseif (isset($_GET['pm']))
 {
  $pm = intval($_GET['pm']);
  $select = $db->prepare('SELECT pm.id pm_id, pm.subject, pm.from_id, pm.message, pm.to_id, pm.date_send, pm.unread, m.id, m.name, m.title, m.ban, m.removed
    FROM private_message pm
    RIGHT JOIN members m ON from_id = m.id AND to_id = m.id 
    WHERE pm.id = ?'); $select->execute(array($pm));
    if ($line = $select->fetch())
    {
     if ($line['to_id'] == $_SESSION['id'])
     {
      if ($line['ban'] == 1) { $title = "Banni"; } elseif ($line['removed'] == 1) { $title = "Oublié"; } else { $title = $line['title']; }
      $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', 'Le $3/$2/$1 à $4', $line['date_send']);
      $message = preg_replace('#\n#', '<br />', $line['message']);
     ?>
     <table cellspacing="0" cellpadding="10" width="100%" style="border: 3px solid black; ">
      <tbody>
       <tr>
        <th style="background-color:#DDDDDD;">Sujet</th> <th style="background-color:#DDDDDD;">Auteur</th> <th style="background-color:#DDDDDD;">Date d'envoi</th>
       </tr>
       <tr>
        <td style="text-align:center;background-color:#CCCCCC; border-bottom: #333333 solid 4px;"><?= $line['subject']?></td>
        <td style="text-align:center;background-color:#CCCCCC; border-bottom: #333333 solid 4px;"><?= $title, ' ' , $line['name']?></td>
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
  <table cellspacing="0" cellpadding="10">
   <tbody>
    <tr>
     <th colspan="2">Sujet :</th>
     <th>Auteur :</th>
     <th>Date de réception :</th>
     <th>Action :</th>
    </tr>
    <?php 
    $select = $db->prepare('SELECT pm.id pm_id, pm.subject, pm.from_id, pm.to_id, pm.date_send, pm.unread, m.id, m.name, m.title, m.ban, m.removed
    FROM private_message pm
    RIGHT JOIN members m ON from_id = m.id AND to_id = m.id 
    WHERE to_id = ?
    ORDER BY unread DESC, date_send DESC, subject ASC'); $select->execute(array($_SESSION['id']));
    
    while ($line = $select->fetch())
    {
     $unread = ($line['unread'] == 1) ? '<span style=color:"red">[!]</span>' : '';
     if ($line['ban'] == 1) { $title = "Banni"; } elseif ($line['removed'] == 1) { $title = "Oublié"; } else { $title = $line['title']; }
     $date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', 'Le $3/$2/$1 à $4', $line['date_send']);
    ?>
    <tr>
     <td><?= $unread?></td>
     <td><a href="index?p=pm&pm=<?= $line['pm_id']?>"><?= $line['subject']?></a></td>
     <td><a href="index?p=perso&perso=<?= $line['id']?>"><?= $title, ' ', $line['name']?></a></td>
     <td><?=$date?></td>
     <td> <span style="color:red">[x]</span></td>
    </tr>
    <?php
    }
    ?>
   </tbody>
  </table>
  <?php
 }
}
?>
