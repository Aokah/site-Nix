<?php function testpage_2 ()
{
	global $db; 
	
	echo "<h2>CB</h2>";
	?>
		<div align="center" width="95%" class="memberbg_4">
			<div width="100%">
				<?php
				 $cb_select = $db->prepare('SELECT * FROM cb_test WHERE del = 0 AND salon = "" AND to_id = ? OR
				 del = 0 AND salon = "" AND to_id = 0');
				 $cb_select->execute(array($_SESSION['id']));
				 
				 while ($line = $cb_select->fetch())
				 {
				 	$select_members = $db->prepare('SELECT * FROM members WHERE id = ?');
				 	$select_members->execute(array($line['sender_id']));
				 	$name_cb = $select_members->fetch();
				 	$tech = ($name_cb['technician'] == 1)? '-T' : '';
				 	$pionier = ($name_cb['pionier'] == 1)? '-P' : '';
				 	$date_send = preg_replace('#^.{11}(.{2}):(.{2}):.{2}$#', '$1:$2', $line['post_date']);
				?>
				<p style="text-align:left;">
				<?= $date_send; ?> : <span class="name<?= $name_cb['rank'], $tech, $pionier; ?>"><?= $name_cb['name']?></span> : <span <?= $bonus
				?>><?= $line['message']?></span>
				</p>
				<?php
				 }
				 ?>
			</div>
			<form action="cb_form" method="POST" style="text-align:left;">
				<label for="cb_msg">Message : </label> <input type="text" name="cb_msg" id="cb_msg" /></br>
				<label for="cb_whisp">Chuchoter à : </label> <input type="text" name="cb_whisp" id="cb_whisp" />
				<label for="cb_salon">Salon : </label> <input type="text" name="cb_salon" id="cb_salon" />
				<input type="submit" value="Envoyer" />
			</form>
		</div>
	<?php
	
}
?>
