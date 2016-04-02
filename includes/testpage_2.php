<?php function testpage_2 ()
{
  global $_POST, $_GET, $_SESSION, $db;
  
?>
  <h2>Page Test pour les Incantations</h2>
  
<?php
  if (isset($_GET['i']))
  {
    if ($_GET['i'] == "valid")
    {
      if ($_SESSION['rank'] > 4)
        {
      $incan = $db->query('SELECT ig.id, ig.user_id, ig.incan_id, ig.valid,
      m.id AS m_id, m.rank, m.pionier, m.technician, m.ban, m.removed, m.name AS nom,
      il.id AS il_id, il.name AS sort, il.desc, il.level, il.cost, il.command, il.type
      FROM incan_get ig
      RIGHT JOIN members m ON m.id = ig.user_id
      LEFT JOIN incan_list il ON il.id = ig.incan_id
      WHERE ig.valid = 0
      ORDER BY nom ASC , il.level DESC , il.type ASC , il.name');
      $line = $incan->fetch();
        }
        else { echo 'Vous n\'avez pas le niveau pour voir ette partie de la page (bien tenté !)'; }
    ?>
    <h3>Liste des sorts Validés</h3>
    <?php 
    $irank = 8;
    while ($irank > 0)
    {
    ?>
    <table cellspacing="0" cellpadding="0" align="center">
      <tbody>
        <tr>
          <td>
            <img src="pics/ico/magiepapertop.png" alt="" />
          </td>
        </tr>
        <tr>
          <td>
            <table width="640px" background="/pics/ico/magiepapercenter.png" align="center">
              <tbody>
                <tr>
                  <td style="text-align:center;">
                    Formule
                  </td>
                </tr>
                <tr>
                   <td style="text-align:center;">
                     Element / Niveau
                  </td>
                </tr>
                <tr>
                  <td style="text-align:center;">
                    Desc
                  </td>
                </tr>
                <tr>
                  <td style="text-align:center;">
                    coùt
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <img src="/pics/ico/magiepapebottom.png" alt="">
          </td>
        </tr>
      </tbody>
    </table>
    <?php
    $irank-- ;
    }
    }
    elseif ($_GET['i'] ==  "unvalid")
    {
      if ($_SESSION['rank'] > 4)
        {
      $incan = $db->query('SELECT ig.id, ig.user_id, ig.incan_id, ig.valid,
      m.id AS m_id, m.rank, m.pionier, m.technician, m.ban, m.removed, m.name AS nom,
      il.id AS il_id, il.name AS sort, il.desc, il.level, il.cost, il.command, il.type
      FROM incan_get ig
      RIGHT JOIN members m ON m.id = ig.user_id
      LEFT JOIN incan_list il ON il.id = ig.incan_id
      WHERE ig.valid = 0
      ORDER BY nom ASC , il.level DESC , il.type ASC , il.name');
      $line = $incan->fetch();
      ?>
        <h3>Liste des sorts non validés</h3>
      <?php
        }
        else { echo 'Vous n\'avez pas le niveau pour voir ette partie de la page (bien tenté !)'; }
    }
    else { echo 'N\'oublies pas de mettre une action valable :)'; }
  }
  elseif (isset($_GET['u']))
  {
  ?> 
    <h3>Liste des sorts d'un joueur</h3>
  <?php
  }
  elseif(isset($_GET['a']))
  {
    if ($_GET['a'] == "unvalided")
    {
  ?>
  <h3>Liste des sorts non validés</h3>
  <?php
    } else { echo 'Action invalide (Bien tenté !)'; }
  }
  else
  {
  ?>
  <h3>Mes sorts</h3>
  <?php
  }
}
?>
