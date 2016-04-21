<?php function privated()
{
  if ($_SESSION['name'] == "Nikho" OR $_SESSION['name'] == "Morrighan" OR $_SESSION['name'] == "Shawn" OR $_SESSION['name'] == "Nyshiki")
  {
    echo '<h2>Hrobrine Sky & Ground</h2>';
    if (isset($_GET['char']))
    {
      ?>
      <a href="index?p=herobrinesg">Retourner à la liste des personnages</a>
      <?php
      $css_td = "background-color: #CCCCFF";
      $css_th = "background-color: #AAAAFF";
      if ($_GET['char'] == "NathHerak")
      {
        $name = "Nath Herak";
        $role = "Maître de Dojo";
        $meeting = "Inconnue";
        $type = "Sol / Ténèbres";
      }
      elseif ($_GET['char'] == "Kisure")
      {
        $name = "Kisure";
        $role = "Champion Régionnal";
        $meeting = "Ligue Régionnale";
        $type = "Dragon / Combat";
      }
      elseif ($_GET['char'] == "Neylann")
      {
        $name = "Neylann";
        $role = "Maître d'Arène";
        $meeting = "Katraz";
        $type = "Spectre / Ténèbres";
      }
      elseif ($_GET['char'] == "Evo")
      {
        $name = "Evo";
        $role = "Admin Team Segghe";
        $meeting = "Inconnue";
        $type = "Glace / Ténèbres";
      }
      elseif ($_GET['char'] == "Ryder")
      {
        $name = "Ryder";
        $role = "Héros";
        $meeting = "Andalaue";
        $type = "Plante";
      }
      elseif ($_GET['char'] == "Dennethor")
      {
        $name = "Dennethor";
        $role = "Elite de Quatre";
        $meeting = "Ligue Régionnale";
        $type = "Combat";
      }
      ?>
      <table align="center" style="border: 5px #000077 solid; background-color: #9999FF; text-align:center;" class="guild">
        <tbody>
          <th colspan="2">
              <?php echo $name; ?>
           </th>
          <tr>
            <td colspan="2">
                <img src="pics/sg_<?= $_GET['char']?>.png" alt="" width="250px" class="guild" />
            </td>
          </tr>
          <tr>
              <th style="<?php echo $css_th;?>">
                Fonction :
              </th>
              <td style="<?php echo $css_td;?>">
                <?php echo $role; ?>
              </td>
          </tr>
          <tr>
            <th style="<?php echo $css_th;?>">
              Rencontre à :
            </th>
            <td style="<?php echo $css_td;?>">
              <?php echo $meeting; ?>
            </td>
          </tr>
          <tr>
            <th style="<?php echo $css_th;?>">
              Type de rituels :
            </th>
            <td style="<?php echo $css_td;?>">
              <?php echo $type; ?>
            </td>
          </tr>
        </tbody>
      </table>
      <p>Sprites</p>
      <table align="center" style="border: 5px #000077 solid; background-color: #9999FF; text-align:center;" class="guild">
        <tbody>
          <tr>
            <td colspan="4">
              <img src="pics/sg_<?php echo $_GET['char'];?>_battle.gif" alt="" width="200px" />
            </td>
          </tr>
          <tr>
            <td colspan="4">
              <img src="pics/sg_<?php echo $_GET['char'];?>_avatar.png" alt="" width="200px" />
            </td>
          </tr>
          <tr>
            <td>
              <img src="pics/sg_<?php echo $_GET['char'];?>_move_front.gif" alt=""  width="50px" /> 
            </td>
            <td>
              <img src="pics/sg_<?php echo $_GET['char'];?>_move_left.gif" alt="" width="50px"  /> 
            </td>
            <td>
              <img src="pics/sg_<?php echo $_GET['char'];?>_move_right.gif" alt="" width="50px"  /> 
            </td>
            <td>
              <img src="pics/sg_<?php echo $_GET['char'];?>_move_off.gif" alt="" width="50px"  /> 
            </td>
          </tr>
        </tbody>
      </table>
      <?php
    }
    else
    {
      $valid = "<img src='pics/ico/tick.png' alt='' width='2%' />";
    ?>
      <h3>Choisissez un personnage</h3>
      <p>Ligue Régionnale</p>
      <ul>
        <li>
          <a href="index?p=herobrinesg&char=Dennethor">Elite de Quatre Dennethor</a>
        </li>
        <li>
         <?=$valid?>  <a href="index?p=herobrinesg&char=Kisure">Champion de Sangha Kisure</a>
        </li>
        <li>
          <a href="index?p=herobrinesg&char=Neylann">Maître dArène Neylann</a>
        </li>
      </ul>
      <p>Team Segghe</p>
      <ul>
        <li>
          <a href="index?p=herobrinesg&char=Evo">Team Seggh Admin Evo</a>
        </li>
      </ul>
      <p>PNJs</p>
      <ul>
        <li>
        <?=$valid?>  <a href="index?p=herobrinesg&char=NathHerak">Maître de Dojo Nath Herak</a>
        </li>
      </ul>
      <p>Héros</p>
      <ul>
        <li>
          <a href="index?p=herobrinesg&char=Ryder">Héros Ryder</a>
        </li>
      </ul>
      <?php
    }
  }
  else
  {
    echo 'Page inexistante';
  
  }
}
?>
