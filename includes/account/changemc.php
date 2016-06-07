<?php function changemc ()
{
  global $_POST, $db;
  
  if (isset($_POST['valid']))
  {
    $newMC = htmlspecialchars($_POST['newMC']);
    $verif = $db->prepare('SELECT Minecraft_Account FROM members WHERE Minecraft_Account = ?');
    $verif->execute(array($newMC));
    if ($verif->fetch())
    {
      echo '<p>Navré, mais ce compte est déjà pris par un autre utilisateur.<a href="index?p=account"> Cliquez ici</a> pour revenir aux options.</p>';
    }
    else
    {
      $update = $db->prepare('UPDATE members SET Minecraft_Account = ? WHERE id = ?');
      $update->execute(array($newMC, $_SESSION['id']));
      echo '<p>Votre nom de compte Minecraft a bien été changé, <a href="index?p=account">cliquez ici</a> pour revenir aux options.</p>';
    }
  }
  else
  {
  ?>
    <h3>Changement de compte Minecraft</h3>
    <p>Entrez ici votre nouveau nom de Compte Minecraft.</p>
    <form action="index?p=account&action=changemc" method="POST">
      <p>
        <label for="newMC">Nouveau nom de Compte Minecraft : </label><input type="text" id="newMC" name="newMC" /> <br />
        <input type="submit" name="valid" value="Modifier" />
      </p>
    </form>
  <?
  }
}
?>
