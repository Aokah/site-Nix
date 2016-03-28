<?php function testpage_2 ()
{
  global $_POST, $_GET, $_SESSION, $db;
  
  if(isset($_GET['perso']))
    {
    $perso = intval($_GET['perso']); echo $perso;
    $avis = $db->prepare('SELECT h.id, h.sender_id, h.sender_rank, h.avis, h.target_id, m.id AS m_id, m.title, m.name
    FROM hrpavis h
    RIGHT JOIN members m
    ON m.id = h.target_id
    WHERE target_id = ?
    ORDER BY h.id DESC');
    $avis->execute(array($perso));
    $avis = $avis->fetch();
    }
  else
  { echo 't\'as oublié de mettre une valeur, c\'est une page test hein !'; }
}
?>
