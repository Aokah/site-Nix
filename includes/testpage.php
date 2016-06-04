<?php function testpage()
{
  global $_SESSION, $_POST, $db;
  
  if ($_SESSION['connected'])
  {
    $verif = $db->prepare('SELECT id, testm FROM members WHERE id = ? AND testm = 0');
    $verif->execute(array($_SESSION['id']));
    echo '<h3>Test de Personalité Magique</h3>';
    if ($verif->fetch())
    {
      if (isset($_POST['valid']))
      {
        $air = 0; $arcane = 0;  $chaleur = 0; $chaos = 0; $eau = 0; $espace = 0; $energie = 0;
        $feu = 0; $glace = 0; $lumiere = 0; $metal = 0;  $nature = 0;  $ombre = 0;  $ordre = 0;
        $psy = 0; $terre = 0;  $void = 0;
        if ($_POST['Q1'] == "R1") { $ombre++; } elseif ($_POST['Q1'] == "R2") {$glace++; $eau++; } 
        elseif ($_POST['Q1'] == "R3") {$feu++; $chaos++; } elseif ($_POST['Q1'] == "R4") { $void++; $psy++; $espace++; }
        elseif ($_POST['Q1'] == "R5") { $nature++; } elseif ($_POST['Q1'] == "R6") {$energie++; $arcane++; }
        elseif ($_POST['Q1'] == "R7") {$chaleur++; } elseif ($_POST['Q1'] == "R8") {$lumiere++; $ordre++;}
        elseif ($_POST['Q1'] == "R9") {$terre++;} elseif ($_POST['Q1'] == "R10") {$metal++; $air++;}
        
        if ($_POST['Q2'] == "R1") { $ombre++; } elseif ($_POST['Q2'] == "R2") { $energie++; }
        elseif ($_POST['Q2'] == "R3") { $lumiere++; }  elseif ($_POST['Q2'] == "R4") { $nature++; } 
        elseif ($_POST['Q2'] == "R5") { $terre++; $metal++; }  elseif ($_POST['Q2'] == "R6") { $chaleur++;  $feu++;} 
        elseif ($_POST['Q2'] == "R7") {$glace++;}  elseif ($_POST['Q2'] == "R8") {$ordre++; $arcane++; $psy++;} 
          elseif ($_POST['Q2'] == "R9") {$ordre++; $arcane++; $psy++;} 
          
      if ($_POST['Q3'] == "R1") { $nature++; } elseif ($_POST['Q3'] == "R2") { $terre++; }  elseif ($_POST['Q3'] == "R3") { $chaleur++; $feu++; }
       elseif ($_POST['Q3'] == "R4") { $air++; }  elseif ($_POST['Q4'] == "R5") { $glace++; }  elseif ($_POST['Q4'] == "R6") { $eau++; }
         elseif ($_POST['Q4'] == "R7") { $psy++; $chaos++; }   elseif ($_POST['Q4'] == "R8") { $ombre++; }   elseif ($_POST['Q4'] == "R9") { $lumiere++; }
        
        if ($_POST['Q4'] == "R1") { $lumiere++; } elseif ($_POST['Q4'] == "R2") { $ombre++; }elseif ($_POST['Q4'] == "R3") { $eau++; }
        elseif ($_POST['Q4'] == "R4") { $chaleur++; } elseif ($_POST['Q4'] == "R5") { $glace++; }
        elseif ($_POST['Q4'] == "R6") { $energie++; }
        
      # Ombre = 4  Void = 1  Glace = 3  Eau = 4  Feu = 3  Chaos = 2  Psy = 3  Nature = 3  Air = 3 Arcane = 2  Lumière = 5
      # Chaleur = 4  Ordre = 2 Terre = 3  Energie = 2  Espace = 1  Metal = 2
          if (max($ombre, $lumiere) == $ombre) { echo "ombre"; }
      }
      else
      {
      ?>
        <p>Ce questionnaire vous permettra de définir que élément naturel est lié à votre personnage, répondez-y honnêtement ! Les tentative de triche se feront très vite remarquer en jeu.</p>
        <p>Pensez bien qu'à ce questionnaire, vous devriez répondre comme si c'était votre personnage qui répondait, et non vous, le joueur derrière.</p>
        
        <form method="POST" action="index?p=testpage">
          <p>Quelle couleur pour représente le plus ?</p>
          <input type="radio" name="Q1" value="R1" id="Q1R1" /> <label for="Q1R1" class="name1">Le Noir</label><br />
          <input type="radio" name="Q1" value="R2" id="Q1R2" /> <label for="Q1R2" class="name1" style="color:aqua;">Le Bleu</label><br />
          <input type="radio" name="Q1" value="R3" id="Q1R3" /> <label for="Q1R3" class="name1" style="color:red;">Le Rouge</label><br />
          <input type="radio" name="Q1" value="R4" id="Q1R4" /> <label for="Q1R4" class="name1" style="color:purple;">Le Violet</label><br />
          <input type="radio" name="Q1" value="R5" id="Q1R5" /> <label for="Q1R5" class="name1" style="color:lime;">Le Vert</label><br />
          <input type="radio" name="Q1" value="R6" id="Q1R6" /> <label for="Q1R6" class="name1" style="color:white;">Le Blanc</label><br />
          <input type="radio" name="Q1" value="R7" id="Q1R7" /> <label for="Q1R7" class="name1" style="color:orange;">Le Orange</label><br />
          <input type="radio" name="Q1" value="R8" id="Q1R8" /> <label for="Q1R8" class="name1" style="color:yellow;">Le Jaune</label><br />
          <input type="radio" name="Q1" value="R9" id="Q1R9" /> <label for="Q1R9" class="name1" style="color:brown;">Le Marron</label><br />
          <input type="radio" name="Q1" value="R10" id="Q1R10" /> <label for="Q1R10" class="name1" style="color:silver;">Le Gris</label><br />
          
          <p>Quel objet vous correspond le mieux ?</p>
          <input type="radio" name="Q2" value="R1" id="Q2R1" /> <label for="Q2R1"><img src="pics/items/Ender_Pearl.png" alt="" width="20px" /> La Perle Noire.</label><br />
          <input type="radio" name="Q2" value="R2" id="Q2R2" /> <label for="Q2R2"><img src="pics/items/Lapis-lazuli.png" alt="" width="20px" /> Le Lapis Lazuli.</label><br />
          <input type="radio" name="Q2" value="R3" id="Q2R3" /> <label for="Q2R3"><img src="pics/items/Quartz.png" alt="" width="20px" /> Le Quartz.</label><br />
          <input type="radio" name="Q2" value="R4" id="Q2R4" /> <label for="Q2R4"><img src="pics/items/Flower.png" alt="" width="20px" /> La Fleur.</label><br />
          <input type="radio" name="Q2" value="R5" id="Q2R5" /> <label for="Q2R5"><img src="pics/items/iron_pickaxe.png" alt="" width="20px" /> La Pioche.</label><br />
          <input type="radio" name="Q2" value="R6" id="Q2R6" /> <label for="Q2R6"><img src="pics/items/Briquet.png" alt="" width="20px" /> Le Briquet.</label><br />
          <input type="radio" name="Q2" value="R7" id="Q2R7" /> <label for="Q2R7"><img src="pics/items/Snowball.png" alt="" width="20px" /> La Boule de Neige.</label><br />
          <input type="radio" name="Q2" value="R8" id="Q2R8" /> <label for="Q2R8"><img src="pics/items/XP.gif" alt="" width="20px" /> L'orbe.</label><br />
          <input type="radio" name="Q2" value="R9" id="Q2R9" /> <label for="Q2R9"><img src="pics/items/Elytra.png" alt="" width="20px" /> Le Ailes.</label><br />
          
          <p>Quel environnement vous attire le plus ?</p>
          <input type="radio" name="Q3" value="R1" id="Q3R1" /> <label for="Q3R1"><img src="pics/items/Spruce_Leaves.png" alt="" width="20px" /> La Forêt.</label><br />
          <input type="radio" name="Q3" value="R2" id="Q3R2" /> <label for="Q3R2"><img src="pics/items/Stone.png" alt="" width="20px" /> La Montagne.</label><br />
          <input type="radio" name="Q3" value="R3" id="Q3R3" /> <label for="Q3R3"><img src="pics/items/Red_Sand.png" alt="" width="20px" /> Le Désert.</label><br />
          <input type="radio" name="Q3" value="R4" id="Q3R4" /> <label for="Q3R4"><img src="pics/items/Aercloud.png" alt="" width="20px" /> Le Ciel.</label><br />
          <input type="radio" name="Q3" value="R5" id="Q3R5" /> <label for="Q3R5"><img src="pics/items/Dirt_Snow.png" alt="" width="20px" /> La Plaine Enneigée.</label><br />
          <input type="radio" name="Q3" value="R6" id="Q3R6" /> <label for="Q3R6"><img src="pics/items/Water.png" alt="" width="20px" /> L'Océan.</label><br />
          <input type="radio" name="Q3" value="R7" id="Q3R7" /> <label for="Q3R7"><img src="pics/items/Mushrooms.gif" alt="" width="20px" /> La Terre Champignon.</label><br />
          <input type="radio" name="Q3" value="R8" id="Q3R8" /> <label for="Q3R8"><img src="pics/items/Coal.png" alt="" width="20px" /> Les Mines.</label><br />
          <input type="radio" name="Q3" value="R9" id="Q3R9" /> <label for="Q3R9"><img src="pics/items/Redstone_Lamp.png" alt="" width="20px" /> Les Villes.</label><br />
          
          <p>Quelle météo ou quel moment de la journée vous met le plus à l'aise ?</p>
          <input type="radio" name="Q4" value="R1" id="Q4R1" /> <label for="Q4R1"><img src="pics/ico/sun.png" alt="" width="20px" /> Le Jour.</label><br />
          <input type="radio" name="Q4" value="R2" id="Q4R2" /> <label for="Q4R2"><img src="pics/ico/Moon.png" alt="" width="20px" /> La Nuit.</label><br />
          <input type="radio" name="Q4" value="R3" id="Q4R3" /> <label for="Q4R3"><img src="pics/ico/rain.png" alt="" width="20px" /> La Pluie.</label><br />
          <input type="radio" name="Q4" value="R4" id="Q4R4" /> <label for="Q4R4"><img src="pics/ico/termometr.png" alt="" width="20px" /> Le Temps Sec.</label><br />
          <input type="radio" name="Q4" value="R5" id="Q4R5" /> <label for="Q4R5"><img src="pics/ico/snow.png" alt="" width="20px" /> La Neige.</label><br />
          <input type="radio" name="Q4" value="R6" id="Q4R6" /> <label for="Q4R6"><img src="pics/ico/storm.png" alt="" width="20px" /> L'Orage.</label><br />
          
          <p><input type="submit" name="valid" value="Terminer" /></p>
      <?php
      }
    }
    else
    {
      echo '<p>Navré, mais vous avez déjà passé ce test.</p>';
    }
  }
  else
  {
    echo '<p>Vous devez vous connecter pour accéder à cette page.</p>';
  }
}
?>
