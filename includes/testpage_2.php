<?php function testpage_2 ()
{
  global $_POST, $_GET, $_SESSION, $db;
  
  if(isset($_GET['perso']))
    {
    $perso = intval($_GET['perso']); echo $perso;
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
         $select = $db->prepare('SELECT COUNT(*) AS plus FROM hrpavis WHERE target_id = ? AND avis = 1');
         $select->execute(array($perso));
         $select1 = $db->prepare('SELECT COUNT(*) AS moins FROM hrpavis WHERE target_id = ? AND avis = 0');
         $select1->execute(array($perso));?>
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
        </tbody>
      </table>
    <?php
    }
  else
  { echo 't\'as oublié de mettre une valeur, c\'est une page test hein !'; }
}
?>
