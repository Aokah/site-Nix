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
      if(isset($_GET['search']))
      {
        $perso = htmlspecialchars($_GET['search']);
        
      if ($_SESSION['rank'] > 4)
        {
    ?>
    <h3>Liste des sorts Validés</h3>
    <?php 
    $irank = 8;
    while ($irank > 0)
    {
      $incan = $db->prepare('SELECT ig.id, ig.user_id, ig.incan_id, ig.valid,
      m.id AS m_id, m.rank, m.pionier, m.technician, m.ban, m.removed, m.name AS nom,
      il.id AS il_id, il.name AS sort, il.desc, il.level, il.cost, il.command, il.type
      FROM incan_get ig
      RIGHT JOIN members m ON m.id = ig.user_id
      LEFT JOIN incan_list il ON il.id = ig.incan_id
      WHERE ig.valid = 0 AND il.level = ? AND nom = ?
      ORDER BY nom ASC , il.level DESC , il.type ASC , il.name');
      $incan->execute(array($irank,$perso));
      $line = $incan->fetch();
      
      $name = $db->prepare('SELECT id, name FROM members WHERE name = ?');
      $name->execute(array($perso)); $name = $name->fetch();
      $id = $name['id'];
      $select = $db->prepare('SELECT COUNT(*) AS verif FROM incan_get
      RIGHT JOIN incan_list ON incan_list.id = incan_get.incan_id
      WHERE incan_get.user_id = ? AND incan_list.level = ?');
      $select->execute(array($id, $irank)); $count = $select->fetch();
      echo $irank, $count['verif'];
      if ($count['verif'] > 0)
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
    
        }
        else { echo 'Vous n\'avez pas le niveau pour voir ette partie de la page (bien tenté !)'; }
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
