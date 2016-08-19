<?php function testpage_3 ()
{
	global $db, $_GET, $_SESSION;
		
	echo "<h3>Forums</h3>";
	
	$view = (isset($_SESSION['rank'])) ? $_SESSION['rank'] : 0;
	
	if (isset($_GET['cat']))
	{
		$cat = intval($_GET['cat']);
		$verify = $db->prepare('SELECT * FROM forum_category WHERE id = ?'); $verify->execute(array($cat));
		$verify = $verify->fetch()
		
		if ($verif['rank'] <= $view)
		{
			if ($view < 6)
			{
				$flist = $db->prepare('SELECT * FROM forum_forum WHERE category = ? AND del = 0');
				$flist->execute(array($cat));
			}
			else
			{
				$flist = $db->prepare('SELECT * FROM forum_forum WHERE category = ?');
				$flist->execute(array($cat));
			}
			$select = $db->prepare('SELECT * FROM forum_category WHERE id = ?'); $select->execute(array($cat));
			?>
			<div width="100%" style="padding:1%" class="memberbg_7">
				<?php
				while ($line = $select->fetch())
				{
					
				?>
				<h4><a href="index?p=testpage_3&cat=<?= $line['id']?>"><?= $line['name']?></a></h4>
				<p><img src="pics/forumcat_<?= $line['id']?>.png" class="guild" /></p>
				<table cellspacing="0" cellpadding="1%" align="center" width="95%">
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
								$imp = "<a href=\"index?p=testpage_3&imp=". $list['id']. "\" style=\"color:gold;\">[I]</a>";
							}
							else
							{
								$imp = "<a href=\"index?p=testpage_3&norm=". $list['id']. "\" style=\"color:blue;\">[N]</a>";
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
							$del = ($flist['del'] == 1)? "<span color:red;>[Supprimé] </span>" : "";
						?>
						<tr class="memberbg_5">
							<td <?= $read?>>
								<?php 
								if ($view > 5)
								{
								?>
								<a href="index?p=testpage_3&del=<?=$list['id']?>" style="color:red;">[X]</a> <?= $imp?> |
								<?
								}
								?>
								<a href="index?p=testpage_3&forum=<?=$list['id']?>&page=1"><?=$del, $important, $rp , $list['name']?></a>
							</td>
							
							<td <?= $read?>><?= $last ?></td>
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
		else
		{
		?>
			<p>Vous n'avez pas les droits nécessaires pour visinner cette catégorie.</p>
		<?php
		}
	}
	elseif (isset($_GET['forum']))
	{
		$forum = intval($_GET['forum']);
		$verify = $db->prepare('SELECT * FROM forum_category WHERE id = ?');
		$verify->execute(array($forum));
		$verify = $verify->fetch();
		
		if ($verify['rank'] <= $view)
		{
			$page = (isset($_GET['page']))? intval($_GET['page']) : 1;
			$fname = $db->prepare('SELECT fc.id, fc.name AS fc_name, ff.name, ff.id AS ff_id, ff.category, ff.rp, ff.important, ff.del, ff.locked FROM forum_category fc
			RIGHT JOIN forum_forum ff ON fc.id = ff.category
			WHERE ff.id = ?');
			$fname->execute(array($forum));
			$fname = $fname->fetch();
			
			if ($view < 6)
			{
				$select = $db->prepare('SELECT * FROM forum_post WHERE forum_id = ? AND del = 0 ORDER BY post_date DESC');
				$select->execute(array($forum));
			}
			else
			{
				$select = $db->prepare('SELECT * FROM forum_post WHERE forum_id = ? ORDER BY post_date DESC');
				$select->execute(array($forum));
			}
			$isrp = ($fname['rp'] == 1)? "<span style=\"color:lime;\">[RP]</span> ": "";
			$isimportant = ($fname['important'] == 1)? "<span style=\"color:gold;\">[Important]</span> ": "";
			$isdel = ($fname['del'] == 1)? "<span style=\"color:#990000;\">[Supprimé]</span> ": "";
			$islock = ($fname['locked'] == 1)? "<span style=\"color:#990000;\">[Vérrouillé]</span> ": "";
			
			?>
			<h4><?=$islock , $isimportant, $isdel, $isrp?><a href="index?p=forum">Forum</a> > <a href="index?p=forum&cat=<?= $fname['id']?>"><?= $fname['fc_name'] ?></a> > <?= $fname['name']?></h4>
				<table cellspacing="1" cellpadding="5" width="90%" align="center">
					<tbody>
						<tr class="member_top">
							<th>Message</th> <th width="25%">Envoyé par :</th>
						</tr>
						<?php
						while ($line = $select->fetch())
						{
							$post = preg_replace('#\n#', '<br />', $line['post']);
							$ranksel = $db->prepare('SELECT * FROM members WHERE id = ?'); $ranksel->execute(array($line['user_id']));
							$ranksel = $ranksel->fetch();
							if ($line['unknow'] == 0)
							{
								$member = $db->prepare('SELECT * FROM members WHERE id = ?'); $member->execute(array($line['user_id']));
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
								$img = "<img src='pics/avatar/miniskin_" . $line['user_id'] . ".png' alt='' width='6%' />";
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
							$date = preg_replace('#^(.{4})-(.{2})-(.{2}) (.{2}:.{2}):.{2}$#', 'Le $3/$2/$1 à $4', $line['post_date']);
							$isdel = ($line['del'] == 1)? "style='background-color:rgba(70,0,0,.5);'" : "";
							$deleter = $db->prepare('SELECT name, id FROM members WHERE id = ?');
							$deleter->execute(array($line['deleter_id'])); $del = $deleter->fetch();
							$delmsg = ($line['del'] == 1)? "<br />(Message Supprimé par " . $del['name'] .")" : "" ;
							
						?>
							<tr class="forumrank<?= $ranksel['rank']?>" <?=$isdel?> >
								<td valign="top">
									<p><?= $post?></p>
								</td>
								<td valign="top">
									<?= $img, " " , $a , $title , " ", $user, $aend ,"<br />" , $date, $delmsg; ?>
								</td>
							</tr>
						<?php		
						}
						?>
					</tbody>
				</table>
			<?php
			
		}
		else
		{
		?>
			<p>Vous n'avez pas le grade nécessaire pour accéder à cette page.</p>
		<?php
		}
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
			<h4><a href="index?p=testpage_3&cat=<?= $line['id']?>"><?= $line['name']?></a></h4>
			<p><img src="pics/forumcat_<?= $line['id']?>.png" class="guild" /></p>
			<table cellspacing="0" cellpadding="1%" align="center" width="95%">
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
							$imp = "<a href=\"index?p=testpage_3&imp=". $list['id']. "\" style=\"color:gold;\">[I]</a>";
						}
						else
						{
							$imp = "<a href=\"index?p=testpage_3&norm=". $list['id']. "\" style=\"color:blue;\">[N]</a>";
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
					<tr class="memberbg_5">
						<td <?= $read?>>
							<?php 
							if ($view > 5)
							{
							?>
							<a href="index?p=testpage_3&del=<?=$list['id']?>" style="color:red;">[X]</a> <?= $imp?> |
							<?
							}
							?>
							<a href="index?p=testpage_3&forum=<?=$list['id']?>&page=1"><?=$important, $rp , $list['name']?></a>
						</td>
						
						<td <?= $read?>><?= $last ?></td>
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
