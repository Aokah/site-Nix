<?php function testpage_2()
{	
global $db;

echo '<h2>Questionnaire</h2>';

   if (isset($_POST['confirm']))
   {
      $count == 0;
      if ($_POST['buildat'] == "accord") { $count ++; }
      if ($_POST['breakwhen'] == "qandcok") { $count ++; }
      if ($_POST['mine'] == "plusieurs") { $count ++; }
      if ($_POST['elevage'] == "create") { $count ++; }
      if ($_POST['cutting'] == "pousse") { $count ++; }
      echo '<p>';
      if ($count >= 8)
      {
      ?>
      Félicitations ! Vous avez atteint le score de <?= echo $count?>/10 , <?php
      if ($count == 10) { ?>ce qui est parfait,<?php } else
      { ?>ce qui est pas mal,<?php } ?> vous pouvez maintenant demander le mode survie à un Staffeux !
      <?php
      }
      else
      {
      ?>
      Navré, mais vous avez atteint le score de <?= echo $count?>/10 , ce qui n'est pas suffisant pour valider votre test de construction. 
      <a href="index?p=testpage_2">Réessayez.</a>
      <?php
      }
      echo '</p>';
   }
   else
   {
?>
<p>Afin de vous permettre de participer à l'évolution du serveur par la construction, il est important pour nous que vous ayez bien saisi les principes de base de la construction dans le cadre d'un jeu de rôle communautaire.</p>
<form method="POST" action="index?p=testpage_2">
   <p>
      Je suis autorisé à construire . . .<br />
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
      <input type="radio" name="mine" value="opti" id="opti" /> <label for="opti">Optimisées, linéaire, et richesse sont mes mots d'ordre, et la couche 11 mon salut !</label><br />
      <input type="radio" name="mine" value="carriere" id="carriere" /> <label for="carriere">D'un puit, faisons une carrière ! Avec des pelleteuse même !</label><br />
      <input type="radio" name="mine" value="plusieurs" id="plusieurs" /> <label for="plusieurs">De manière logique et si possible à plusieurs pour créer du RP.</label><br />
      <input type="radio" name="mine" value="maison" id="maison" /> <label for="maison">Sous ma maison en ligne droite puis je rebouche quand j'en ai marre.</label>
   </p>
   <p>
      L'élevage :<br />
      <input type="radio" name="elevage" value="batcave" id="batcave" /> <label for="batcave">Dans ma batcave en secret, bien sûr.</label><br />
      <input type="radio" name="elevage" value="create" id="create" /> <label for="create">Je regarde s'il n'y a pas une infrastructure d'elevage, sinon je me renseigne pour en créer une via le RP.</label><br />
      <input type="radio" name="elevage" value="spam" id="spam" /> <label for="spam">Je surpeuple une zone et y revient régulièrement.</label><br />
      <input type="radio" name="elevage" value="respawn" id="respawn" /> <label for="respawn">Je décime les population sans retenue, ça va réapparaitre un jour.</label>
   </p>
   <p>
      Je coupe les Arbres . . .<br />
      <input type="radio" name="cutting" value="pousse" id="pousse" /> <label for="pousse">Proprement et intégralement, puis je replante une pousse.</label><br />
      <input type="radio" name="cutting" value="besoin" id="besoin" /> <label for="besoin">Pile le bois dont j'ai besoin et je laisse le reste au suivant.</label><br />
      <input type="radio" name="cutting" value="urbain" id="urbain" /> <label for="urbain">Je décime la forêt, on pourra parler urbanisme en plus.</label><br />
      <input type="radio" name="cutting" value="osef" id="osef" /> <label for="osef">Je coupe l'arbe, point, un de plus ou de moins.</label>
   </p>
   
   <p>
      <input type="submit" name="confirm" value="Terminer" />
   </p>
</form>

<?php
}
}
?>
