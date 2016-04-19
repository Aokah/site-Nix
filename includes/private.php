<?php function privated()
{
  if ($_SESSION['name'] == "Nikho")
  {
    echo '<h2>Hrobrine Sky & Ground</h2>';
    if (isset($_GET['char']))
    {
      $css_td = "background-color: #CCCCFF";
      $css_th = "background-color: #AAAAFF";
      if ($_GET['char'] == "NathHerak")
      {
        $name = "Nath Herak";
        $role = "Maître de Dojo";
        $meeting = "Inconnue";
      }
      ?>
      <table align="center" style="border: 5px #000077 solid; background-color: #9999FF" class="guild">
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
              <?php $meeting; ?>
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
      <?php
    }
  }
  else
  {
    echo 'Page inexistante';
  
  }
}
?>
