<?php function guilds ()
{
global $_POST,$_GET, $db;

echo "<h2>Groupes et Guildes</h2>";
    
    if (isset($_GET['add']))
    {
        $group = intval($_GET['for']);
        $name = htmlspecialchars($_GET['add']);
        
    $supersel = $db->prepare('SELECT gm.id, gm.user_id, gm.group_id, gm.user_rank, m.id, m.name, m.rank, m.title
    FROM group_members gm
    RIGHT JOIN members m ON gm.user_id = m.id
    WHERE gm.group_id = ?
    ORDER BY gm.user_rank DESC, m.rank DESC, m.name ASC');
    $supersel->execute(array($group)); $line = $supersel->fetch();
    $verif0 = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND user_rank > 3 AND user_rank > ?');
    $verif0->execute(array($_SESSION['id'], $line['user_rank']));
    
        if ($_SESSION['rank'] > 5 OR $verif0->fetch())
        {
      $verif = $db->prepare('SELECT name, id FROM members WHERE name = ?');
      $verif->execute(array($name));
      
      if ($verif = $verif->fetch())
      {
          $user = $verif['id'];
          $verif = $db->prepare('SELECT * FROM group_members WHERE user_id = ?');
          $verif->execute(array($user));
          if ($verif = $verif->fetch())
          {
              echo '<p>Navré, mais ce personnage est déjà présent dans ce groupe.</p> <p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
          }
          else
            {
              $verif = $db->prepare('SELECT * FROM group_name WHERE id = ?');
              $verif->execute(array($group));
              
              if ($verif->fetch())
              {
                  $update = $db->prepare("INSERT INTO group_members VALUES ('',? , ?, '0')");
                $update->execute(array($group, $user));
                echo '<p>Le personnage a bien été ajouté.</p> <p><a href="index?p=guilds">Cliquez ici</a> pour continuer.</p>';
              }
              else
              {
                echo '<p>Navré, mais ce groupe n\'existe pas.</p> <p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
              }
        }
          }
      else
      {
          echo  '<p>Navré, mais ce personnage n\'existe pas.</p> <p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
      }
        }
      else
      {
          echo '<p>Navré, mais vous n \'avez pas les permissions suffisantes pour effectuer cette requête.</p>';
      }
    }
    elseif (isset($_GET['del']))
    {
        $group = intval($_GET['from']);
        $user = intval($_GET['del']);
        
    $supersel = $db->prepare('SELECT gm.id, gm.user_id, gm.group_id, gm.user_rank, m.id, m.name, m.rank, m.title
    FROM group_members gm
    RIGHT JOIN members m ON gm.user_id = m.id
    WHERE gm.group_id = ?
    ORDER BY gm.user_rank DESC, m.rank DESC, m.name ASC');
    $supersel->execute(array($group)); $line = $supersel->fetch();
    $verif0 = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND user_rank > 3 AND user_rank > ?');
    $verif0->execute(array($_SESSION['id'], $line['user_rank']));
    
        if ($_SESSION['rank'] > 5 OR $verif0->fetch())
        {
            $verif =  $db->prepare('SELECT id FROM members WHERE id = ?');
            $verif->execute(array($user));
            if ($verif->fetch())
            {
                $verif = $db->prepare('SELECT id FROM group_name WHERE id = ?');
                $verif->execute(array($group));
                if ($verif->fetch())
                {
                    $verif = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND group_id = ?');
                    $verif->execute(array($user, $group));
                    if ($verif->fetch())
                    {
                        $update = $db->prepare('DELETE FROM group_members WHERE user_id = ? AND group_id = ?');
                        $update->execute(array($user, $group));
                        echo '<p>Le membre a bien été supprimé du groupe</p> <p><a href="index?p=guilds">Cliquez ici</a> pour continuer.</p>';
                    }
                    else
                    {
                        echo '<p>Navré, mais ce personnage n\'est pas dans ce groupe.</p><p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
                    }
                }
                else
                {
                    echo '<p>Navré, mais ce groupe n\'existe pas.</p><p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
                }
            }
            else
            {
                echo '<p>Navré mais ce personnage n\'existe pas.</p><p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
            }
        }
        else
        {
            echo '<p>Navré, mais vous n \'avez pas les permissions suffisantes pour effectuer cette requête.</p>';
        }
    }
    elseif (isset($_GET['up']))
    {
        $group = intval($_GET['from']);
        $user = intval($_GET['up']);
        
    $supersel = $db->prepare('SELECT gm.id, gm.user_id, gm.group_id, gm.user_rank, m.id, m.name, m.rank, m.title
    FROM group_members gm
    RIGHT JOIN members m ON gm.user_id = m.id
    WHERE gm.group_id = ?
    ORDER BY gm.user_rank DESC, m.rank DESC, m.name ASC');
    $supersel->execute(array($group)); $line = $supersel->fetch();
    $verif0 = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND user_rank > 3 AND user_rank > ?');
    $verif0->execute(array($_SESSION['id'], $line['user_rank']));
    $verif2 = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND group_id = ?');
    $verif2->execute(array($_SESSION['id'], $group)); $line3 = $verif2->fetch();
    
        if ($_SESSION['rank'] > 5 OR $verif0->fetch() AND $line3 > ($line['user_rank']+1))
        {
            $verif =  $db->prepare('SELECT id FROM members WHERE id = ?');
            $verif->execute(array($user));
            if ($verif->fetch())
            {
                $verif = $db->prepare('SELECT id FROM group_name WHERE id = ?');
                $verif->execute(array($group));
                if ($verif->fetch())
                {
                    $verif = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND group_id = ?');
                    $verif->execute(array($user, $group));
                    if ($verif->fetch())
                    {
                        $verif = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND group_id = ?');
                        $verif->execute(array($user, $group)); $verif = $verif->fetch();
                        if ($verif['user_rank'] < 5)
                        {
                        $update = $db->prepare('UPDATE group_members SET user_rank = user_rank + 1 WHERE user_id = ? AND group_id = ?');
                        $update->execute(array($user, $group));
                        echo '<p>Le membre a bien été promu !</p> <p><a href="index?p=guilds">Cliquez ici</a> pour continuer.</p>';
                        }
                        else
                        {
                            echo '<p>Navré, mais ce personnage ne peut être promu d\'avantage.</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Navré, mais ce personnage n\'est pas dans ce groupe.</p><p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
                    }
                }
                else
                {
                    echo '<p>Navré, mais ce groupe n\'existe pas.</p><p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
                }
            }
            else
            {
                echo '<p>Navré mais ce personnage n\'existe pas.</p><p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
            }
        }
        else
        {
            echo '<p>Navré, mais vous n \'avez pas les permissions suffisantes pour effectuer cette requête.</p>';
        }
    }
    elseif(isset($_GET['down']))
    {
      $group = intval($_GET['from']);
        $user = intval($_GET['down']);
        
    $supersel = $db->prepare('SELECT gm.id, gm.user_id, gm.group_id, gm.user_rank, m.id, m.name, m.rank, m.title
    FROM group_members gm
    RIGHT JOIN members m ON gm.user_id = m.id
    WHERE gm.group_id = ?
    ORDER BY gm.user_rank DESC, m.rank DESC, m.name ASC');
    $supersel->execute(array($group)); $line = $supersel->fetch();
    $verif0 = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND user_rank > 3 AND user_rank > ?');
    $verif0->execute(array($_SESSION['id'], $line['user_rank']));
    
        if ($_SESSION['rank'] > 5 OR $verif0->fetch() )
        {
            $verif =  $db->prepare('SELECT id FROM members WHERE id = ?');
            $verif->execute(array($user));
            if ($verif->fetch())
            {
                $verif = $db->prepare('SELECT id FROM group_name WHERE id = ?');
                $verif->execute(array($group));
                if ($verif->fetch())
                {
                    $verif = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND group_id = ?');
                    $verif->execute(array($user, $group));
                    if ($verif->fetch())
                    {
                        $verif = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND group_id = ?');
                        $verif->execute(array($user, $group)); $verif = $verif->fetch();
                        if ($verif['user_rank'] > 0)
                        {
                        $update = $db->prepare('UPDATE group_members SET user_rank = user_rank - 1 WHERE user_id = ? AND group_id = ?');
                        $update->execute(array($user, $group));
                        echo '<p>Le membre a bien été dégradé !</p> <p><a href="index?p=guilds">Cliquez ici</a> pour continuer.</p>';
                        }
                        else
                        {
                            echo '<p>Navré, mais ce personnage ne peut être dégradé d\'avantage.</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Navré, mais ce personnage n\'est pas dans ce groupe.</p><p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
                    }
                }
                else
                {
                    echo '<p>Navré, mais ce groupe n\'existe pas.</p><p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
                }
            }
            else
            {
                echo '<p>Navré mais ce personnage n\'existe pas.</p><p><a href="index?p=guilds">Retourner à la page normale.</a></p>';
            }
        }
        else
        {
            echo '<p>Navré, mais vous n \'avez pas les permissions suffisantes pour effectuer cette requête.</p>';
        }
    }
    else
    {
?>
  <p>Ici seront regroupées les informations basiques concernant les guildes et les groupes du site</p>
  <?php
  $select = $db->query('SELECT id, name, vanish, guild FROM group_name WHERE vanish = 0 ORDER BY guild DESC, name ASC');
  if ($_SESSION['id'] < 5) {
  $select2 = $db->prepare('SELECT gn.name, gn.id, gm.user_id, gm.group_id, gm. user_id
  FROM group_name gn 
  RIGHT JOIN group_members gm ON group_id = gn.id
  WHERE user_id = ? AND user_rank > 3
  ORDER BY gn.name ASC');
  $select2->execute(array($_SESSION['id']));
  } else { $select2  = $db->query('SELECT * FROM group_name ORDER BY name ASC'); }
  if ($_SESSION['rank'])
  ?>
  <form action="index.php" method="GET">
    <input type="hidden" name="p" value="guilds" />
    Ajout d'un nouveau membre : <input type="text" name="add" />
    <select name="for">
      <?php
      while ($option = $select2->fetch())
      {
        ?>
        <option value="<?= $option['id']?>"><?= $option['name']?></option>
        <?php
      }
      ?>
    </select>
    <input type="submit" value="Confirmer" />
  </form>
  <?php
  while ($line = $select->fetch())
  {
    $sel = $db->prepare('SELECT gm.id, gm.user_id, gm.group_id, gm.user_rank, m.id, m.name, m.rank, m.title
    FROM group_members gm
    RIGHT JOIN members m ON gm.user_id = m.id
    WHERE gm.group_id = ?
    ORDER BY gm.user_rank DESC, m.rank DESC, m.name ASC');
    $sel->execute(array($line['id']));
    $prefixe = ($line['guild'] == 1) ? 'Guilde :: ' : 'Groupe :: ';
  ?>
  <h3><?=$prefixe, $line['name']?></h3>
  <img src="pics/guild_<?= $line['id']?>.png" alt="" class="guild" />
  <ul>
    <?php
    while ($line2 = $sel->fetch())
    {
      if ($line2['rank'] == 9) { $rank = "titan"; } elseif ($line2['rank'] == 10) { $rank = "crea";} else { $rank = $line2['rank'];}
      $verif = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND user_rank > 3 AND user_rank > ?');
      $verif->execute(array($_SESSION['id'], $line2['user_rank']));
      $verif2 = $db->prepare('SELECT * FROM group_members WHERE user_id = ? AND group_id = ?');
      $verif2->execute(array($_SESSION['id'], $line['id'])); $line3 = $verif2->fetch();
      ?>
      <li>
        [G<?= $line2['user_rank']?>] <img src="pics/rank<?= $rank?>.png" alt="" class="magie_type" width="25" /> <?= $line2['title'], ' ', $line2['name']?> <?php
        if ($_SESSION['rank'] > 5 OR $verif->fetch()) {
          ?><a href="index?p=guilds&del=<?= $line2['user_id']?>&from=<?= $line['id']?>" class="name7">[X]</a><?php if ($line2['user_rank'] >= 0 AND $line2['user_rank'] < 5 OR $line3 > ($line2['user_rank']+1)) { ?> <a href="index?p=guilds&up=<?= $line2['user_id']?>&from=<?= $line['id']?>" class="name5">[+]</a><?php } echo ' '; if ($line2['user_rank'] > 0) { ?><a href="index?p=guilds&down=<?= $line2['user_id']?>&from=<?= $line['id']?>" class="name6">[-]</a><? }
        }?>
      </li>
      <?php
    }
    ?>
  </ul>
  <?php
  }
  ?>
<?php
}
}
?>
