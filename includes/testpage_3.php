<?php function testpage_3 ()
{
	global $db;
		
	echo "<h3>Forums</h3>";
	
	$view = (isset($_SESSION['rank'])) ? $_SESSION['rank'] : 0;
	
	if (isset($_GET['cat']))
	{
		
	}
	elseif (isset($_GET['forum']))
	{
		
	}
	else
	{
		$select = $db->prepare('SELECT * FROM forum_category WHERE \'group\' = 0 AND rank <= ?'); $select->execute(array($view));
		?>
		<div width="100%" style"padding:1%;margin:1%;">
			<?php
			while ($line = $select->fetch())
			{
			?>
			<h4><?= $line['name']?></h4>
			<p><img src="pics/forumcat_<?= $line['id']?>.png" class="guild" /></p>
			<table cellspacing="0" cellpadding="1%" align="center" width="95%">
				<tbody>
					<tr></tr>
				</tbody>
			</table>
			<?php
			}
			?>
		</div>
		<?php
	}
}
?>
