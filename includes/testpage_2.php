<?php function testpage_2()
{	
global $db;
?>
<h2>Questionnaire</h2>
<p>Afin de vous permettre de participer à l'évolution du serveur par la construction, il est important pour nous que vous ayez bien saisi les principes de base de la construction dans le cadre d'un jeu de rôle communautaire.</p>
<form method="POST" action="#">
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
</form>

<?php
}
?>
