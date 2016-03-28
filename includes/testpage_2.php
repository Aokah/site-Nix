<?php function testpage_2 ()
{
  global $_POST, $_GET, $_SESSION, $db;
  
  if(isset($_GET['perso']))
    {
    $perso = intval($_GET['perso']);
    $avis = $db->prepare('SELECT h.id, h.sender_id, h.sender_rank, h.avis, h.target_id, m.id , m.title, m.name
    FROM hrpavis h
    RIGHT JOIN members m
    ON m.id = h.sender_id
    WHERE target_id = ?
    ORDER BY h.id DESC');
    $avis->execute(array($perso));
    
    ?>
      <table>
        <tbody>
          <tr>
            <th>Nom</th>
            <th>Titre</th>
            <th>Avis</th>
          </tr>
        <?php if ($avis = $avis->fetch()) {
         $value = ($avis['sender_rank'] > 4) ? '2' : '1' ;
         $method = ($avis['avis'] == 1) ? '+' : '-'; 
         $select = $db->prepare('SELECT COUNT(*) AS plus FROM hrpavis WHERE target_id = ? AND avis = 1 AND sender_rank <= 4');
         $select->execute(array($perso)); $line = $select->fetch();
         $select1 = $db->prepare('SELECT COUNT(*) AS plusstaff FROM hrpavis WHERE target_id = ? AND avis = 1 AND sender_rank > 4');
         $select1->execute(array($perso)); $line1 = $select1->fetch();
         $select2 = $db->prepare('SELECT COUNT(*) AS moins FROM hrpavis WHERE target_id = ? AND avis = 0 AND sender_rank <= 4');
         $select2->execute(array($perso)); $line2 = $select2->fetch();
         $select3 = $db->prepare('SELECT COUNT(*) AS moinsstaff FROM hrpavis WHERE target_id = ? AND avis = 0 AND sender_rank > 4');
         $select3->execute(array($perso)); $line3 = $select3->fetch();
         $countj = $line['plus'] - $line2['moins'];
         $plus = $line1['plusstaff'] * 2; $moins = $line3['moinsstaff'] * 2;
         $counts = $plus - $moins; $count = $countj + $counts;
         
         ?>
          <tr>
            <td>
              <?= $avis['name']?>
            </td>
            <td>
              <?= $avis['title']?>
            </td>
            <td>
              <?php echo $method,$value ?>
            </td>
          </tr>
        <?php } ?>
        <tr>
          <th>Total :</th><td><?php echo $count;?></td>
        </tr>
        </tbody>
      </table>
    <?php
    echo $counts, $countj,'<br />', $line['plus'], $line1['moins'];
    }
  else
  { echo 't\'as oublié de mettre une valeur, c\'est une page test hein !'; }
}
?>
