<?php function testb()
{	
global $db;
if ($_SESSION['connected'])
{
	$id = $_SESSION['id'];
	$select = $db->prepare('SELECT COUNT(*) AS plus FROM hrpavis WHERE target_id = ? AND avis = 1 AND sender_rank <= 4');
	$select->execute(array($id)); $line0 = $select->fetch();
	$select1 = $db->prepare('SELECT COUNT(*) AS plusstaff FROM hrpavis WHERE target_id = ? AND avis = 1 AND sender_rank > 4');
	$select1->execute(array($id)); $line1 = $select1->fetch();
	$select2 = $db->prepare('SELECT COUNT(*) AS moins FROM hrpavis WHERE target_id = ? AND avis = 0 AND sender_rank <= 4');
	$select2->execute(array($id)); $line2 = $select2->fetch();
	$select3 = $db->prepare('SELECT COUNT(*) AS moinsstaff FROM hrpavis WHERE target_id = ? AND avis = 0 AND sender_rank > 4');
	$select3->execute(array($id)); $line3 = $select3->fetch();
	$countj = $line0['plus'] - $line2['moins'];
	$plus = $line1['plusstaff'] * 2; $moins = $line3['moinsstaff'] * 2;
	$counts = $plus - $moins; $hrpavis = $countj + $counts;
	$select4 = $db->prepare('SELECT buildok FROM members WHERE buildok = 0 AND id = ?');
	$select4->execute(array($id)); 
   if ($_SESSION['rank'] > 1 OR $hrpavis >= 10)
   {
   
echo '<h2>Questionnaire</h2>';
	if ($select4->fetch())
   	{
   if (isset($_POST['confirm']))
   {
      $count = 0;
      if ($_POST['buildat'] == "accord") { $count ++; }
      if ($_POST['breakwhen'] == "qandcok") { $count ++; }
      if ($_POST['mine'] == "plusieurs") { $count ++; }
      if ($_POST['elevage'] == "create") { $count ++; }
      if ($_POST['cutting'] == "pousse") { $count ++; }
      if ($_POST['event'] == "expe") { $count ++; }
      if ($_POST['steal'] == "allok") { $count ++; }
      if ($_POST['cave'] == "adapt") { $count ++; }
      if ($_POST['size'] == "adapte") { $count ++; }
      if ($_POST['cult'] == "ext") { $count ++; }
      echo '<p>';
      if ($count >= 8)
      {
         $update = $db->prepare('UPDATE members SET buildok = 1 WHERE id = ?');
         $update->execute(array($_SESSION['id']));
      ?>
      Félicitations ! Vous avez atteint le score de <?= $count?>/10 , <?php
      if ($count == 10) { ?>ce qui est parfait,<?php } else
      { ?>ce qui est pas mal,<?php } ?> vous pouvez maintenant demander le mode survie à un Staffeux !
      <?php
      }
      else
      {
      ?>
      Navré, mais vous avez atteint le score de <?= $count?>/10 , ce qui n'est pas suffisant pour valider votre test de construction. 
      <a href="index?p=testb">Réessayez.</a>
      <?php
      }
      echo '</p>';
   }
   else
   {
?>
<p>Afin de vous permettre de participer à l'évolution du serveur par la construction, il est important pour nous que vous ayez bien saisi les principes de base de la construction dans le cadre d'un jeu de rôle communautaire.</p>
<form method="POST" action="index?p=testb">
   <p>
      Je suis autorisé à construire . . .<br />
      <img src="pics/testb_1.png" alt="" class="guild" /><br />
      <input type="radio" name="buildat" value="partout" id="partout" /> <label for="partout">N'importe où, tant que ça ne se voit pas.</label><br />
      <input type="radio" name="buildat" value="nullepart" id="nullepart" /> <label for="nullepart">Nulle part, le Staff construit tout !</label><br />
      <input type="radio" name="buildat" value="avue" id="avue" /> <label for="avue">Bien à la vue de tous ! Ce serait dommage de ne pas montrer mon talent ! !</label><br />
      <input type="radio" name="buildat" value="accord" id="accord" /> <label for="accord">Sur une place cohérente et dans le cadre du RP, si besoin avec accord d'un Maître du Jeu.</label>
   </p>
   <p>
      Je peux détruire d'autres bâtiments . . .<br />
      <input type="radio" name="breakwhen" value="jeveux" id="jeveux" /> <label for="jeveux">Ce qui ne me plait pas, après tout ça n'avait qu'à pas être là !</label><br />
      <input type="radio" name="breakwhen" value="chezmoi" id="chezmoi" /> <label for="chezmoi">Quand ça empiète sur mon terrain.</label><br />
      <input type="radio" name="breakwhen" value="qandcok" id="qandcok" /> <label for="qandcok">Lors de scènes RP cohérentes et autorisées par le Staff / Le joueur à qui appartient la maison.</label><br />
      <input type="radio" name="breakwhen" value="boum" id="boum" /> <label for="boum">Si j'ai des explosifs, on verra rien.</label>
   </p>
   <p>
      Je mine. . .<br />
      <img src="pics/testb_2.png" alt="" class="guild" /><br />
      <input type="radio" name="mine" value="opti" id="opti" /> <label for="opti">Optimisées, linéaire, et richesse sont mes mots d'ordre, et la couche 11 mon salut !</label><br />
      <input type="radio" name="mine" value="carriere" id="carriere" /> <label for="carriere">D'un puit, faisons une carrière ! Avec des pelleteuse même !</label><br />
      <input type="radio" name="mine" value="plusieurs" id="plusieurs" /> <label for="plusieurs">De manière logique et si possible à plusieurs pour créer du RP.</label><br />
      <input type="radio" name="mine" value="maison" id="maison" /> <label for="maison">Sous ma maison en ligne droite puis je rebouche quand j'en ai marre.</label>
   </p>
   <p>
      L'élevage :<br />
      <img src="pics/testb_3.png" alt="" class="guild" /><br />
      <input type="radio" name="elevage" value="batcave" id="batcave" /> <label for="batcave">Dans ma batcave en secret, bien sûr.</label><br />
      <input type="radio" name="elevage" value="create" id="create" /> <label for="create">Je regarde s'il n'y a pas une infrastructure d'elevage, sinon je me renseigne pour en créer une via le RP.</label><br />
      <input type="radio" name="elevage" value="spam" id="spam" /> <label for="spam">Je surpeuple une zone et y revient régulièrement.</label><br />
      <input type="radio" name="elevage" value="respawn" id="respawn" /> <label for="respawn">Je décime les population sans retenue, ça va réapparaitre un jour.</label>
   </p>
   <p>
      Je coupe les Arbres . . .<br />
      <img src="pics/testb_4.png" alt="" class="guild" /><br />
      <input type="radio" name="cutting" value="pousse" id="pousse" /> <label for="pousse">Proprement et intégralement, puis je replante une pousse.</label><br />
      <input type="radio" name="cutting" value="besoin" id="besoin" /> <label for="besoin">Pile le bois dont j'ai besoin et je laisse le reste au suivant.</label><br />
      <input type="radio" name="cutting" value="urbain" id="urbain" /> <label for="urbain">Je décime la forêt, on pourra parler urbanisme en plus.</label><br />
      <input type="radio" name="cutting" value="osef" id="osef" /> <label for="osef">Je coupe l'arbe, point, un de plus ou de moins.</label>
   </p>
   <p>
      Je découvre un lieu étrange . . .<br />
      <input type="radio" name="event" value="expe" id="expe" /> <label for="expe">J'observe les environs et propose une expédition en groupe pour le découvrir !</label><br />
      <input type="radio" name="event" value="secret" id="secret" /> <label for="secret">Je casse tous les murs pour voir s'il n'y a pas de salles secrètes !</label><br />
      <input type="radio" name="event" value="xray" id="xray" /> <label for="xray">J'use d'X-Ray, on sait jamais.</label><br />
      <input type="radio" name="event" value="rush" id="rush" /> <label for="rush">Je rush l'endroit, donjon ou temple, et je garde ces secrets pour moi.</label>
   </p>
   <p>
      Je vol un tiers . . .<br />
      <input type="radio" name="steal" value="tout" id="tout" /> <label for="tout">Je prends tout ce que mon inventaire peut supporter !</label><br />
      <input type="radio" name="steal" value="supervision" id="supervision" /> <label for="supervision">Avec accord du propriétaire et/ou du MJ.</label><br />
      <input type="radio" name="steal" value="allok" id="allok" /> <label for="allok">Avec supervision d'un Membre du Staff quoi qu'il arrive.</label><br />
      <input type="radio" name="steal" value="discret" id="discret" /> <label for="discret">Je vole le minimum histoire de ne pas me faire prendre.</label>
   </p>
   <p>
      Ma Cave doit être . . .<br />
      <input type="radio" name="cave" value="batcave2" id="batcave2" /> <label for="batcave2">Un véritable sous-terrain de superheros, je dois y avoir tout ce dont j'ai besoin pour sauver la veuve et l'orphelin !</label><br />
      <input type="radio" name="cave" value="adapted" id="adapted" /> <label for="adapted">Adaptée à la maison, sans hotel sous-terrain ou "batcave".</label><br />
      <input type="radio" name="cave" value="naheul" id="naheul" /> <label for="naheul">Dignes des plus grands maîtres du donjon ! Des pièges partouts et des explosifs de secours ! Vous ne volerez pas mon or ! !</label><br />
      <input type="radio" name="cave" value="lol" id="lol" /> <label for="lol">J'optimise la place avec tout un tas de systèmes étranges dont seul moi connais le secret.</label>
   </p>
   <p>
      La taille d'une maison doit être . . .<br />
      <input type="radio" name="size" value="skip" id="skip" /> <label for="skip">Compact et utile ! Comme on les aime.</label><br />
      <input type="radio" name="size" value="villa" id="villa" /> <label for="villa">Une villa du futur de ses morts !</label><br />
      <input type="radio" name="size" value="adapte" id="adapte" /> <label for="adapte">Adaptée à sa fonctionnalitée, ne pas construire une forteresse pour 4 personnes seulement. Et respecter la cohérence du milieu.</label><br />
      <input type="radio" name="size" value="dirt" id="dirt" /> <label for="dirt">Un carré de terre 5x5. Allez !</label>
   </p>
   <p>
      Je plante mon champs . . .<br />
      <input type="radio" name="cult" value="roof" id="roof" /> <label for="roof">dans mon grenier, ça rendra les combles utiles.</label><br />
      <input type="radio" name="cult" value="incave" id="incave" /> <label for="incave">Dans ma cave, et sous la lumière d'une torche bien sûr !</label><br />
      <input type="radio" name="cult" value="ext" id="ext" /> <label for="ext">En extérieur, de manière cohérente et réfléchie.</label><br />
      <input type="radio" name="cult" value="pillage" id="pillage" /> <label for="pillage">Je  pille un village random, pourquoi s'embêter ?</label>
   </p>
   
   <p>
      <input type="submit" name="confirm" value="Terminer" />
   </p>
</form>

<?php
}
}
else
{
	echo '<p>Vous avez déjà passé ce test, pourquoi donc le refaire ?</p>';
}
}
else
{
   echo '<p>Vous n\'avez pas le grade ou les permissions suffisantes pour accéder à cette page.</p>';
}
}
else
{
   echo '<p>Veuillez vous connecter pour accéder à cette page.</p>';
}
}
?>
