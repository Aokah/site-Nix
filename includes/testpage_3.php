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
		<div width="100%" style="padding:1%" class="memberbg_7">
			<?php
			while ($line = $select->fetch())
			{
				$flist = $db->prepare('SELECT * FROM forum_forum WHERE del = 0 AND category = ? ORDER BY important DESC, last_post DESC LIMIT 10');
				$flist->execute(array($line['id']));
			?>
			<h4><?= $line['name']?></h4>
			<p><img src="pics/forumcat_<?= $line['id']?>.png" class="guild" /></p>
			<table cellspacing="0" cellpadding="1%" align="center" width="95%">
				<tbody>
					<tr class="member_top">
						<th>Sujet</th> <th width="25%">Dernière activité</th>
					</tr>
					<?php 
					while ($list = $flist->fetch())
					{
						$important = ($list['important'] == 1) ? '[Important] ' : "";
						$verif = $db->prepare('SELECT * FROM forum_unread WHERE user_id = ? AND forum_id = ?');
						$verif->execute(array($_SESSION['id'], $list['id']));
						if ($verif = $verif->fetch())
						{
							if ($verif['unread'] == 1)
							{
								$read = "";
								$page = $verif['page'];
							}
							else
							{
								$read = "class=\"unread\"";
								$page = $verif['page'];
							}
						}
						else
						{
							$read = "class=\"unread\"";
							$page = 1;
						}
						if ($list['important'] == 1)
						{
							$imp = "<a href=\"index?p=forum&imp=". $list['id']. "\" style=\"color:gold;\">[I]</a>";
						}
						else
						{
							$imp = "<a href=\"index?p=forum&norm=". $list['id']. "\" style=\"color:cyan;\">[N]</a>";
						}
					?>
					<tr class="memberbg_5">
						<td <?= $read?>>
							<a href="index?p=forum&del=<?=$list['id']?>" style="color:red;">[X]</a> <?= $imp?>
							<a href="index?p=forum&forum=<?=$list['id']?>&page=1"><?=$important, $list['name']?></a>
						</td>
						
						<td <?= $read?>>\o/</td>
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
