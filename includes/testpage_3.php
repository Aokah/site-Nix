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
		$select = $db->prepare('SELECT * FROM forum_category WHERE \'group\' = 0 AND rank <= ? ORDER BY rank ASC, name ASC'); $select->execute(array($view));
		?>
		<div width="100%" style"padding:1%;margin:1%;">
			<?php
			while ($line = $select->fetch())
			{
				$flist = $db->prepare('SELECT * FROM forum_forum WHERE del = 0 AND category = ? ORDER BY important DESC, last_post DESC');
				$flist->execute(array($line['id']));
			?>
			<h4><?= $line['name']?></h4>
			<p><img src="pics/forumcat_<?= $line['id']?>.png" class="guild" /></p>
			<table cellspacing="0" cellpadding="1%" align="center" width="95%">
				<tbody>
					<tr>
						<th>Sujet</th> <th width="25%">Dernière activité</th>
					</tr>
					<?php 
					while ($list = $flist->fetch())
					{
					?>
					<tr>
						<td>
							<a href="index?p=forum&forum=<?=$list['id']?>&page=1"><?= $list['name']?></a>
						</td>
						<td>\o/</td>
					</tr>
					<?php
					}
					?>
					<tr>
						
					</tr>
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
