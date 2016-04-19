<?php function privated()
{
  if ($_SESSION['name'] == "Nikho")
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
              <img src="pics/sg_NathHerak_battle.gif" alt="" />
            </td>
          </tr>
          <tr>
            <td colspan="4">
              <img src="pics/sg_NathHerak_avatar.png" alt="" />
            </td>
          </tr>
          <tr>
            <td>
              <img src="pics/sg_<?php echo $_GET['char'];?>_move_front.gif" alt="" /> 
            </td>
            <td>
              <img src="pics/sg_<?php echo $_GET['char'];?>_move_left.gif" alt="" /> 
            </td>
            <td>
              <img src="pics/sg_<?php echo $_GET['char'];?>_move_right.gif" alt="" /> 
            </td>
            <td>
              <img src="pics/sg_<?php echo $_GET['char'];?>_move_off.gif" alt="" /> 
            </td>
          </tr>
        </tbody>
      </table>
      <?php
    }
    else
    {
    ?>
      <h3>Choisissez un personnage</h3>
      <a href="index?p=herobrinesg&char=NathHerak">Maître de Dojo Nath Herak</a>
      <?php
    }
  }
  else
  {
    echo 'Page inexistante';
  
  }
}
?>
