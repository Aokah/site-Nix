<?php function cb_new ()
{
	global $db; 
	include ('includes/cb_form.php'); cb_form();
	echo "<h2>CB</h2>";
	?>
		<div align="center" width="95%" class="memberbg_6">
			<div width="100%" style="padding:1%;" class="memberbg_4">
				<?php
				if (isset($_GET['admin']))
				{
					if ($_GET['admin'] == "see_del")
					{
						$count = $db->prepare('SELECT COUNT(*) AS count FROM cb_test WHERE salon = "" AND to_id = ? OR
					 	 salon = "" AND to_id = 0 ORDER BY post_date ASC');
					 	 $count->execute(array($_SESSION['id']));
					 	$limit1 = $count['count'];
					 	$limit2 = $limit1 - 20;
					 	$limit2 = ($limit2 < 0) ? 0 : $limit2;
					 	
						$cb_select = $db->prepare('SELECT * FROM cb_test WHERE salon = "" AND to_id = ? OR
					 	 salon = "" AND to_id = 0 ORDER BY post_date ASC LIMIT ?, ?');
					 	$cb_select->execute(array($_SESSION['id'], $limit1, $limit2));	
					}
					elseif ($_GET['admin'] == "see_whisp")
					{
						$count = $db->prepare('SELECT COUNT(*) AS count FROM cb_test WHERE del = 0 AND salon = ""  ORDER BY post_date ASC ');
					 	$count->execute(array($_SESSION['id'])); $count = $count->fetch();
					 	$limit1 = $count['count'];
					 	$limit2 = $limit1 - 20;
					 	$limit2 = ($limit2 < 0) ? 0 : $limit2;
						$cb_select = $db->prepare('SELECT * FROM cb_test WHERE del = 0 AND salon = ""  ORDER BY post_date ASC LIMIT ?, ?');
						$cb_select->execute(arra($limit1, $limit2));
					}
				}
				else
				{
					$count = $db->prepare('SELECT COUNT(*) AS count FROM cb_test WHERE del = 0 AND salon = "" AND to_id = ? OR
					 del = 0 AND salon = "" AND to_id = 0  ORDER BY post_date ASC ');
					 	$count->execute(array($_SESSION['id'])); $count = $count->fetch();
					 	$limit1 = $count['count'];
					 	$limit2 = $limit1 - 20;
					 	$limit2 = ($limit2 < 0) ? 0 : $limit2;
					 	
					$cb_select = $db->prepare('SELECT * FROM cb_test WHERE del = 0 AND salon = "" AND to_id = ? OR
					 del = 0 AND salon = "" AND to_id = 0  ORDER BY post_date ASC LIMIT ?, ?');
					 $cb_select->execute(array($_SESSION['id'], $limit1, $limit2));	
				}
				 
				 
				 while ($line = $cb_select->fetch())
				 {
				 	$select_member = $db->prepare('SELECT * FROM members WHERE id = ?');
					$select_member->execute(array($line['sender_id']));
					$name_cb = $select_member->fetch();
				 	$tech = ($name_cb['technician'] == 1)? '-T' : '';
				 	$pionier = ($name_cb['pionier'] == 1)? '-P' : '';
				 	$date_send = preg_replace('#^.{11}(.{2}):(.{2}):.{2}$#', '$1:$2', $line['post_date']);
				 	if ($line['staff_effect'] == "class" OR $line['staff_effect'] == "style" )
				 	{
				 		$option = $line['staff_parameter'];
				 		$effect = $line['staff_effect']. '="' . $option . '" ';
				 	}
				 	else
				 	{
				 		$effect = " ";
				 	}
				 
					 if ($line['del'] == 0)	
					 {
						?>
						<p style="text-align:left;"> <a href="index?p=cb&del=<?= $line['id']?>" style="color:red;">[x]</a> 
						[<?= $date_send; ?>] <img src="pics/avatar/miniskin_<?= $line['sender_id']?>.png" alt="" width="15px" />
						<span class="name<?= $name_cb['rank'], $tech, $pionier; ?>"><?= $name_cb['name']?></span> : <span <?= $effect
						?>><?= $line['message']?></span>
						</p>
						<?php
					 }
					 else
					 {
					 	$select_del = $db->prepare('SELECT * FROM members WHERE id = ?');
					 	$select_del->execute(array($line['deleter_id']));
					 	$del = $select_del->fetch();
					 	?>
					 	<p style="text-align:left; color: darkred;">
						[<?= $date_send; ?>] <img src="pics/avatar/miniskin_<?= $line['sender_id']?>.png" alt="" width="15px" />
						<span class="name<?= $name_cb['rank'], $tech, $pionier; ?>"><?= $name_cb['name']?></span> : <span style="color:gold">(Supprimé par <?= $del['name']?>)</span> <?= $line['message']?>
						</p>
						<?php
					 }
				 }
				 ?>
			</div>
			<form method="POST" action="index?p=cb" style="text-align:left; padding:1%">
				<label for="cb_msg">Message : </label> <input type="text" id="reloadCB" onclick="toggleAutoRefresh(this);" name="cb_msg" id="cb_msg" /></br>
				<label for="cb_whisp">Chuchoter à : </label> <input type="text" name="cb_whisp" id="cb_whisp" /><br />
			<!--	<label for="cb_salon">Salon : </label> <input type="text" name="cb_salon" id="cb_salon" /> -->
				<? if ($_GET['admin'] != "see_del")
					{
						echo '<a href="index?p=cb&admin=see_del" class="button">Voir les messages supprimés</a>';
					}
				if (isset($_GET['admin']))
					{
						echo '<a href="index?p=cb" class="button">Retour à la CB Classique</a>';
					}
				?>
				<br /><input type="checkbox" name="staffeffect" id="staffeffect" /> <label for="staffeffect">Activer un effet de texte (NECESSITE DES BASES EN HTML)</label><br />
				<select name="effect">
					<option value="class">Class</option>
					<option value="style">Style</option>
				</select>
				<input type="text" name="option"/>
				<br /><input type="submit" name="send_cb" value="Envoyer" />
			</form>
		</div>
	<?php
	
}
?>
