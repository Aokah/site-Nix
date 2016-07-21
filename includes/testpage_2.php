<?php function testpage_2 ()
{
	global $db; 
	
	echo "<h2>CB</h2>";
	?>
		<div align="center" class="memberbg_4">
			<form action="cb_form" method="POST">
				<label for="cb_msg">Message : </label> <input type="text" name="cb_msg" id="cb_msg" /></br>
				<label for="cb_whisp">Message : </label> <input type="text" name="cb_whisp" id="cb_whisp" />
				<label for="cb_salon">Message : </label> <input type="text" name="cb_salon" id="cb_salon" />
				<input type="submit" value="Envoyer" />
			</form>
		</div>
	<?php
	
}
?>
