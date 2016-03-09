<?php function sondage ()
{
	global $db, $_SESSION, $_POST, $_GET;
	?>


	<h2>Sondages d'RPNix.com</h2>

<?php if (isset($_GET['s']))
	
	{
	?>
	<center>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td>
						<img src="includes/img/magiepapertop.png" alt=" " />
					</td>
				</tr>
				<tr>
					<td>
						<table background="includes/img/magiepapercenter.png">
						
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<img src="includes/img/magiepapebottom.png" alt="" />
					</td>
				</tr>
			</tbody>
		</table>
	</center>
	<?php
	}
	else
	{
?>
	
	<ul id="categories">
		<li class="forum_category">
		<p>Votes Publics</p>
		
		<table class="forum" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr class="head_table">
					<th>Intitulé</th>
					<th class="last_post">Créé par</th>
				</tr>
				<tr>
					<td class="read">
					<a href="#"> Sondage A</a>
					</td>
					<td>
					<img width="20px" src="pics/avatar/miniskin_no.png">
					<a class="name7-T" href="#"> Opérateur Etzu</a>
					<br>
					Le 26/02/2016 à 22:29
					</td>
				</tr>
			</tbody>
		</table>
		</li>
	</ul>
<?php
	}
?>
	
<?php


} ?>
