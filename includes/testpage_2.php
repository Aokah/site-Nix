<?php function testpage_2 ()
{
global $_SESSION, $db;
//$psw = $db->prepare('SELECT password, id FROM members WHERE id = ?'); $psw->execute(array($_SESSION['id'])); 

//if ($line = $psw->fetch())
//{
 // if (password_verify('dragonball76', $line['password']))
 // {
  //  echo 'yes';
  //}
 // else
 // {
 //   echo 'no';
 // }
//}
?>
  <h2>Mon Compte</h2>
  <p>Sur cette page vosu trouverez toutes les informatiosn relatives à votre comtpe RPNix.com.</p>
  
  <h3>Adresse Mail</h3>
  <p>Vous souhaitez changer votre adresse mail ? C'est <a href="#&action=changemail">par ici</a> !</p>
  
  <h3>Changer de mot de passe</h3>
  <p>Besoin de sécurité ou simple doute ? Changez votre mot de passe <a href="#&action=changepsw">ici</a> !</p>
  
  <h3>Compte Minecraft</h3>
  <p>Le nom du compte Minecraft que vous utilisez est nécessaire pour profiter d'un maximum de chose en jeu, si vous souhaitez lier un novueau compte, c'est <a href="#&action=changemc">par ici</a> !</p>
<?php
}
?>
