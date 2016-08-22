<?php function testpage()
{
	global $db;
	
	$view = $_SESSION['rank'];
	$select = $db->prepare('SELECT * FROM forum_category WHERE guild = 0 AND rank <= ? ORDER BY rank ASC, name ASC'); $select->execute(array($view));
		?>
		<div width="100%" style="padding:1%" class="forumbg">
			<?php
			while ($line = $select->fetch())
			{
				$flist = $db->prepare('SELECT * FROM forum_forum WHERE del = 0 AND category = ? ORDER BY important DESC, last_post DESC LIMIT 10');
				$flist->execute(array($line['id']));
				
				$precount = $db->prepare('SELECT * FROM forum_forum WHERE del = 0 AND category = ?');
				$precount->execute(array($line['id'])); $presel = $precount->fetch();
				$preselect = $db->prepare('SELECT fu.id, fu.user_id, fu.forum_id, fu.page, fu.page, fp.forum_id, fp.post_date
				FROM forum_unread fu
				RIGHT JOIN forum_post fp ON fp.forum_id = fu.forum_id
				WHERE fu.unread = 0 AND fu.forum_id = ? AND fu.user_id = ? AND ADDDATE(fp.post_date, INTERVAL "1" MONTH) > NOW()');
				$preselect->execute(array($presel['id'], $_SESSION['id']));
				while ($line_ = $preselect->fetch())
				{
					
				}
				
			?>
			<h4><a href="index?p=forum&cat=<?= $line['id']?>"><?= $line['name']?></a></h4>
			<p><img src="pics/forumcat_<?= $line['id']?>.png" class="guild" /></p>
			<table cellspacing="0" cellpadding="3%" align="center" width="95%">
				<tbody>
					<tr class="member_top">
						<th>Sujet</th> <th width="25%">Dernière activité</th>
					</tr>
					<?php 
					while ($list = $flist->fetch())
					{
						$important = ($list['important'] == 1) ? '<span style="color:gold;">[Important]</span> ' : "";
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
						if ($list['important'] == 0)
								{
									$imp = "<a href=\"index?p=forum&imp=". $list['id']. "\" style=\"color:gold;\">[I]</a>";
								}
								else
								{
									$imp = "<a href=\"index?p=forum&norm=". $list['id']. "\" style=\"color:blue;\">[N]</a>";
								}
								if ($list['rp'] == 0)
								{
									$srp = "<a href=\"index?p=forum&hrp=". $list['id']. "\" style=\"color:gray;\">[sHRP]</a>";
								}
								else
								{
									$srp = "<a href=\"index?p=forum&rp=". $list['id']. "\" style=\"color:lime;\">[sRP]</a>";
								}
								if ($list['del'] == 0)
								{
									$sdel = "<a href=\"index?p=forum&del=". $list['id']. "\" style=\"color:red;\">[X]</a>";
								}
								else
								{
									$sdel= "<a href=\"index?p=forum&rest". $list['id']. "\" style=\"color:blue;\">[X]</a>";
								}
								if ($list['lock'] == 0)
								{
									$slock = "<a href=\"index?p=forum&lock=". $list['id']. "\" style=\"color:gold;\">[V]</a>";
								}
								else
								{
									$slock= "<a href=\"index?p=forum&unlock=". $list['id']. "\" style=\"color:gray;\">[dV]</a>";
								}
						$rp = ($list['rp'] == 1) ? "<span style='color:lime;'> [RP] </span>" : "";
						
						$latest = $db->prepare('SELECT * FROM forum_post WHERE forum_id = ? ORDER BY id DESC'); $latest->execute(array($list['id']));
						if ($latest = $latest->fetch())
						{
							if ($latest['unknow'] == 0)
							{
								$member = $db->prepare('SELECT * FROM members WHERE id = ?'); $member->execute(array($latest['user_id']));
								$member = $member->fetch();
								$title = $member['title'];
								$title = ($member['pionier']== 1)? "Pionier" : $title;
								$title = ($member['ban'] == 1)? "Banni" : $title;
								$title = ($members['removed'] == 1)? "Oublié" : $title;
								$user = $member['name'];
								$tech = ($member['technician'] == 1)? "-T" : "";
								$pionier = ($member['pionier'] == 1)? "-P" : "";
								$color = $member['rank']. "" . $tech. "" . $pionier;
								$a = "<a class='name". $color ."' href='index?p=perso&perso=" . $member['id'] ."'>";
								$aend = "</a>";
								$img = "<img src='pics/avatar/miniskin_" . $latest['user_id'] . ".png' alt='' width='6%' />";
							}
							else
							{
								$title = "Message";
								$user = "Anonyme";
								$color = "1";
								$a = "<span class='name" . $color . "'>";
								$aend = "</span>";
								$img = "";
							}
							$date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', 'Le $3/$2/$1 à $4', $latest['post_date']);
							
							$last = $img ." ". $a ."" . $title . " ". $user. "". $aend ."<br />" . $date ."";
						}
						else
						{
							$last = "Aucun message dans ce forum.";
						}
					?>
					<tr class="forumf">
						<td <?= $read?> style="border-bottom: solid 2px black; border-left: solid 2px black; border-right: black 2px solid;">
							<?php 
								if ($view > 5)
								{
									echo $sdel, " ", $imp, " ", $srp, " ", $slock?> |
								<?
								}
								?>
							<a href="index?p=forum&forum=<?=$list['id']?>&page=1"><?=$important, $rp , $list['name']?></a>
						</td>
						
						<td <?= $read?> style="border-bottom: solid 2px black; border-left: solid 2px black; border-right: black 2px solid; text-align:center;"><?= $last ?></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<?php
			}
			?>
		</div>
		<?php
}
?>
