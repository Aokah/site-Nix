<?php function pnj()
{
  global $db, $_SESSION, $_GET, $_POST;
?>

  <? if (isset($_GET['pnj']))
  {
    $pnj = intval($_GET['pnj']);
		$answer = $db->prepare('SELECT *
					FROM pnj_list AS p
					WHERE p.id = ?');
		$answer->execute(array($pnj));
		if ($line = $answer->fetch())
		{
			$filename = 'pics/pnj/pnj_' .$line['id']. '.png';if (file_exists($filename)) {$img = $line['id'];} else {$img = 'no';}
			if ($line['role'] == 0) { $color = "#0066FF"; $role = "Moindre";  }
			elseif ($line['role'] == 1) { $color = "#00FF00"; $role = "Mineure";  }
			elseif ($line['role'] == 2) { $color = "#FFCC00"; $role = "Intermédiaire";  }
			elseif ($line['role'] == 3) { $color = "#CC3300"; $role = "Majeure";  }
			elseif ($line['role'] == 4) { $color = "#FF0000"; $role = "Primaire";  }
			else { $color = "#808080"; $role = "Inconnu";  }
			$bg = preg_replace('#\n#', '<br />', $line['bg']);
?>
	<h3 style="color:<? echo $color?>; text-shadow: 2px 2px 2px #000000;">PNJ <?= $line['prenom']?></h3>
	<form action="index.php?p=pnj_list&pnj=<?= $line['id']?>" method="POST">
	<input type="submit" name="modifier" value="Modifier" style="color:blue;" />
	</form>
	
	<table class="pnjtable"  cellspacing="10px">
		<tbody>
				<tr>
					<td rowspan="4" width="150px" height="150px" style="border-radius: 10px;"><img width="180px" height="180px" src="pics/pnj/pnj_<?echo $img?>.png" /></td>	<td height="20px" style="border: 0px grey solid; background-color: grey;"> <p></p></td>
				</tr>
				<tr>
					<td width="60px" style="border: 0px grey solid; background-color: grey; color: grey;"><p></p></td> 	<td height="20px">Prénom : <?= $line['prenom']?> </td> <td height="20px">Nom : <?= $line['nom']?> </td><td width="89px" style="border: 0px grey solid; background-color: grey;"> <p></p></td>
				</tr>
				<tr>
					<td style="border: 0px grey solid; background-color: grey;"><p></p></td> <td width="80px" height="20px">Origine : <?= $line['origine']?> </td> <td width="80px" height="20px">Race : <?= $line['race']?> </td><td style="border: 0px grey solid; background-color: grey;"> <p></p></td>
				</tr>
				<tr>
					<td height="20px" style="border: 0px grey solid; background-color: grey;"> <p></p></td>
				</tr>
				<tr>
					<td>Taille : <?= $line['taille']?> </td> <td rowspan="2"><p>Signes distinctifs :</p> <?= $line['sd']?></td>
				</tr>
				<tr>
					<td>Poids :<?= $line['poids']?> </td>
					<td>Importance : <?php echo $role ?></td>
				</tr>
				<tr>
					<td>Elément : <?= $line['element']?> </td> <td colspan="3">Event d'apparition : <?= $line['event']?></td>
				</tr>
				<tr>
					<td><p>Qualités :</p><p><?= $line['qualite']?></p></td>
																<td style="vertical-align: top;" colspan="4" rowspan="5" width="100%" ><p>Histoire : </p>
																<p><?= $line['bg']?><p> </td>
				</tr>
				<tr>
					<td><p>Défaults :</p><p><?= $line['default']?></p></td>
				</tr>
				
				<tr>
					<td><p>Caractère :</p> <p><?= $line['caractere']?></p></td>
				</tr>
				<tr>
					<td><p>Equipement :</p>
					<p><?= $line['equipement']?></p></td>
				</tr>
		</tbody>
	</table>
	<?php
  } else { echo  "<p>Une erreur s'est produite ou le PNJ n'existe pas.</p>"; }
  ?>
  
<?php
}
?>
