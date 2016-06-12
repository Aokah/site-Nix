<?php function testpage_2 ()
{
	global $db; 
	$perso = intval($_POST['perso']);
	$perso = 204;
	$select = $db->prepare('SELECT * FROM caract WHERE user_id= ?');
	$select->execute(array($perso));
	while ($line = $select->fetch())
	{
	?>
	<table cellspacing="0" cellapdding="5" width="100%" style="border: 5px gray solid; border-radius: 10px; background-color: #DDDDDD;text-shadow: white 1px 1px 4px;">
		<tbody>
			<tr style="background-color:#BBBBBB;">
				<th colspan="7">Points de compétence physiques</th>
			</tr>
			<tr style="background-color:#BBBBBB;">
				<th colspan="7">Points non encore distribués : <?=$line['points']?></th>
			</tr>
			<tr style="background-color:#BBBBBB;">
				<th>Force</th>
				<th>Intelligence</th>
				<th>Charisme</th>
				<th>Agilité</th>
				<th>Observation</th>
				<th>Savoir-faire</th>
				<th>Chance</th>
			</tr>
			<tr class="name1">
				<td><?=$line['puissance']?></td>
				<td><?=$line['intelligence']?></td>
				<td><?=$line['charisme']?></td>
				<td><?=$line['agilite']?></td>
				<td><?=$line['observation']?></td>
				<td><?=$line['savoirfaire']?></td>
				<td><?=$line['chance']?></td>
			</tr>
			<tr>
				<td colspan="7">Ce tableau statistique n'est là qu'à but indicatif, le plus important est la manière dont vous jouez votre personnage !</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
}
?>
