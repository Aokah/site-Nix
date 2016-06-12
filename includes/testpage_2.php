<?php function testpage_2 ()
{
global $db;
$select = $db->query('SELECT * FROM members');
while ($line = $select->fetch())
{
$insert = $db->prepare("INSERT INTO caract VALUES('',?, 100,0,0,0,0,0,0)");
$insert->execute(array($line['id']));
echo 'Succès';
}
}
?>
