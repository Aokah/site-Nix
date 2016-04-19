<?php function privated()
{
  if ($_SESSION['name'] == "Nikho")
  {
    echo '<h2>Hrobrine Sky & Ground</h2>';
    if (isset($_GET['char']))
    {
      if ($_GET['char'] == "NathHerak")
      {
        $name = "Nath Herak";
      }
      ?>
      <table class="magie_type">
        <tbody>
          <tr>
            <th rowspan="2">
              <?php echo $name; ?>
            </th>
          </tr>
          <tr>
            <td>
              <th>
                <img src="pics/sg_<?= $_GET['char']?>.png" alt="" width="300px" class="guild" />
              </th>
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
