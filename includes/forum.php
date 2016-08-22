<?php function forum ()
{
	global $db, $_GET, $_SESSION;
		
	echo "<h3>Forums</h3>";
	
	$view = (isset($_SESSION['rank'])) ? $_SESSION['rank'] : 0;
		
		if (isset($_GET['imp']))
		{
			$update = $db->prepare('UPDATE forum_forum SET important = 1 WHERE id = ?');
			$update->execute(array($_GET['imp']));
			$msg = "Le sujet a bien été défini comme important !";
		}
		elseif (isset($_GET['norm']))
		{
			$update = $db->prepare('UPDATE forum_forum SET important = 0 WHERE id = ?');
			$update->execute(array($_GET['norm']));
			$msg = "Le sujet a bien été défini comme standard.";
		}
		elseif (isset($_GET['rp']))
		{
			$update = $db->prepare('UPDATE forum_forum SET rp = 1 WHERE id = ?');
			$update->execute(array($_GET['rp']));
			$msg =  "Le sujet a bien été rendu RP !";
		}
		elseif (isset($_GET['hrp']))
		{
			$update = $db->prepare('UPDATE forum_forum SET rp = 0 WHERE id = ?');
			$update->execute(array($_GET['hrp']));
			$msg = "Le sujet a bien été rendu HRP.";
		}
		elseif (isset($_GET['lock']))
		{
			$update = $db->prepare('UPDATE forum_forum SET locked = 1, locker_id = ? WHERE id = ?');
			$update->execute(array($_SESSION['id'], $_GET['lock']));
			$msg = "Le sujet a bien été vérouillé.";
		}
		elseif (isset($_GET['unlock']))
		{
			$update = $db->prepare('UPDATE forum_forum SET locked = 0, locker_id = 0 WHERE id = ?');
			$update->execute(array($_GET['unlock']));
			$msg = "Le sujet a bien été déverrouillé !";
		}
		elseif (isset($_GET['del']))
		{
			$update = $db->prepare('UPDATE forum_forum SET del = 1, deleter_id = ? WHERE id = ?');
			$update->execute(array($_SESSION['id'], $_GET['del']));
			$msg = "Le sujet a bien été supprimé.";
		}
		elseif (isset($_GET['rest']))
		{
			$update = $db->prepare('UPDATE forum_forum SET del = 0, deleter_id = 0 WHERE id = ?');
			$update->execute(array($_GET['rest']));
			$msg = "Le sujet a bien été réstauré !";
		}
		
	if (isset($_GET['cat']))
	{
		$cat = intval($_GET['cat']);
		$verify = $db->prepare('SELECT * FROM forum_category WHERE id = ?'); $verify->execute(array($cat));
		$verify = $verify->fetch();
		if (isset($_POST['sendsubject']) AND isset($_POST['newsubject']))
		{
			$fimp = (isset($_POST['setImp']))? 1 : 0;
			$frp = (isset($_POST['setRP']))? 1 : 0;
			$fname = htmlspecialchars($_POST['newsubject']);
			
			$add = $db->prepare('INSERT INTO forum_forum VALUES("", ?, ?, 0, ?, ?, 0, 0, 0, 0)');
			$add->execute(array($fname, $cat, $fimp, $frp));
		}
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
			$line = $select->fetch();
			?>
			<div width="100%" style="padding:1%" class="forumbg">
				<h4><a href="index?p=forum">Forum</a> > <?= $line['name']?></h4>
			<?php if (isset($_GET['imp']) OR isset($_GET['norm']) OR isset($_GET['rp']) OR isset($_GET['hrp']) OR isset($_GET['rest']) OR
			isset($_GET['del']) OR isset($_GET['lock']) OR isset($_GET['unlock']))
			{
				echo "<p>", $msg, "</p>";
			}
			?>
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
									$imp = "<a href=\"index?p=forum&cat". $cat. "&imp=". $list['id']. "\" style=\"color:gold;\">[I]</a>";
								}
								else
								{
									$imp = "<a href=\"index?p=forum&cat". $cat. "&norm=". $list['id']. "\" style=\"color:blue;\">[N]</a>";
								}
								if ($list['rp'] == 0)
								{
									$srp = "<a href=\"index?p=forum&cat". $cat. "&hrp=". $list['id']. "\" style=\"color:gray;\">[sHRP]</a>";
								}
								else
								{
									$srp = "<a href=\"index?p=forum&cat". $cat. "&rp=". $list['id']. "\" style=\"color:lime;\">[sRP]</a>";
								}
								if ($list['del'] == 0)
								{
									$sdel = "<a href=\"index?p=forum&cat". $cat. "&del=". $list['id']. "\" style=\"color:red;\">[X]</a>";
								}
								else
								{
									$sdel= "<a href=\"index?p=forum&cat". $cat. "&rest". $list['id']. "\" style=\"color:blue;\">[X]</a>";
								}
								if ($list['lock'] == 0)
								{
									$slock = "<a href=\"index?p=forum&cat". $cat. "&lock=". $list['id']. "\" style=\"color:gold;\">[V]</a>";
								}
								else
								{
									$slock= "<a href=\"index?p=forum&cat". $cat. "&unlock=". $list['id']. "\" style=\"color:gray;\">[dV]</a>";
								}
							$rp = ($list['rp'] == 1) ? "<span style='color:lime;'> [RP] </span>" : "";
							$del = ($list['del'] == 1)? "<span style='color:red;'>[Supprimé] </span>" : "";
							
							
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
							<td <?= $read?>  style="border-bottom: solid 2px black; border-left: solid 2px black; border-right: black 2px solid;">
								<?php 
								if ($view > 5)
								{
									echo $sdel, " ", $imp, " ", $srp, " ", $slock?> |
								<?
								}
								?>
								<a href="index?p=forum&forum=<?=$list['id']?>&page=1"><?=$del, $important, $rp , $list['name']?></a>
							</td>
							
							<td <?= $read?>  style="border-bottom: solid 2px black; border-left: solid 2px black; border-right: black 2px solid; text-align:center;"><?= $last ?></td>
						</tr>
						<?php
						}
						if ($view > 0)
						{
							$importantbutton = ($view > 5)? "<br /><label for='setImp'>Considérer le nouveau sujet comme Important : </label><input type='checkbox' name='setImp' id='setImp' />": "";
							?>
							<tr>
								<td>
									<form action="index?p=forum&cat=<?= $cat?>" method="POST">
										<label for="newsubject">Nouveau sujet : </label><input type="text" name="newsubject" id="newsubject" width="65%" />
										<input type="submit" name="sendsubject" value="Créer"/><br />
										<label for="setRP">Considérer le nouveau sujet comme Rôleplay :</label> <input type="checkbox" id="setRP" name="setRP" />
										<?= $importantbutton ?>
									</form>
								</td>
								
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
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
		
		if (isset($_POST['sendnew']) AND isset($_POST['newpost']))
		{	
			$text = (isset($_POST['newpost']))? htmlspecialchars($_POST['newpost']) : "Message vierge (à supprimer)";
			$anonyme = (isset($_POST["sendunknow"]) AND $fname['rp'] == 1)? 1 : 0;
			if ($view > 5)
			{
				$text = preg_replace('#(?<!\|)\(b\)([^<>]+)\(/b\)#isU', '<span style="font-weight: bold;">$1</span>', $text);
				$text = preg_replace('#(?<!\|)\(i\)([^<>]+)\(/i\)#isU', '<span style="font-style: italic;">$1</span>', $text);
				$text = preg_replace('#(?<!\|)\(u\)([^<>]+)\(/u\)#isU', '<span style="text-decoration: underline;">$1</span>', $text);
				$text = preg_replace('#(?<!\|)\(a (https?://[a-z0-9._\-/&\?^()]+)\)([^<>]+)\(/a\)#isU', '<a href="$1" style="color: #FF8D1C;">$2</a>', $text);
				$text = preg_replace('#(?<!\|)\(img (https?://[a-z0-9._\-/&\?^()]+)\)#isU', '<img src="$1" alt=" "/>', $text);
				$text = preg_replace('#(?<!\|)\(c ([^<>]+)\)([^<>]+)\(/c\)#isU', '<span style="color: $1">$2</span>', $text);
			}
			
			$add = $db->prepare("INSERT INTO forum_post VALUES('', ?, NOW(), ?, ?, ?, 0, 0)");
			$add->execute(array($text, $_SESSION['id'], $forum, $anonyme));
			$update = $db->prepare('UPDATE forum_unread SET unread = 0 WHERE forum_id = ?');
			$update->execute(array($forum));
		}
		elseif (isset($_GET['del']))
		{
			if ($view > 5)
			{
				$delete = intval($_GET['del']);
				$del = $db->prepare('UPDATE forum_post SET del = 1, deleter_id = ? WHERE id = ?');
				$del->execute(array($_SESSION['id'], $delete));
				$msg = "Le post a bien été supprimé.";
			}
		}
		elseif (isset($_GET['restore']))
		{
			if ($view > 5)
			{
				$restore = intval($_GET['restore']);
				$rest = $db->prepare('UPDATE forum_post SET del = 0, deleter_id = 0 WHERE id = ?');
				$rest->execute(array($restore));
				$msg = "Le post a bien été restauré.";
			}
		}
		elseif (isset($_GET['edit']))
		{
			$edit = intval($_GET['edit']);
			if (isset($_POST['editpost']))
			{
				$text = htmlspecialchars($_POST['newpost']);
				if ($view > 5)
				{
					$text = preg_replace('#(?<!\|)\(b\)([^<>]+)\(/b\)#isU', '<span style="font-weight: bold;">$1</span>', $text);
					$text = preg_replace('#(?<!\|)\(i\)([^<>]+)\(/i\)#isU', '<span style="font-style: italic;">$1</span>', $text);
					$text = preg_replace('#(?<!\|)\(u\)([^<>]+)\(/u\)#isU', '<span style="text-decoration: underline;">$1</span>', $text);
					$text = preg_replace('#(?<!\|)\(a (https?://[a-z0-9._\-/&\?^()]+)\)([^<>]+)\(/a\)#isU', '<a href="$1" style="color: #FF8D1C;">$2</a>', $text);
					$text = preg_replace('#(?<!\|)\(img (https?://[a-z0-9._\-/&\?^()]+)\)#isU', '<img src="$1" alt=" "/>', $text);
					$text = preg_replace('#(?<!\|)\(c ([^<>]+)\)([^<>]+)\(/c\)#isU', '<span style="color: $1">$2</span>', $text);
				}
				$update = $db->prepare('UPDATE forum_post SET post = ? WHERE id = ?');
				$update->execute(array($text, $edit));
				$msg = "Le post a bien été modifié !";
			}
			else
			{
				$presel = $db->prepare('SELECT * FROM forum_post WHERE id = ?'); $presel->execute(array($edit));
				$edit = $presel->fetch();
				if ($view > 5 OR $edit['date_post'] == NOW())
				{
					$emsg = $edit['post'];
				}
			}
		}
			
		if ($verify['rank'] <= $view)
		{
			$page = (isset($_GET['page']) AND $_GET['page'] > 0)? intval($_GET['page']) : 1;
			$fname = $db->prepare('SELECT fc.id, fc.name AS fc_name, ff.name, ff.id AS ff_id, ff.category, ff.locker_id, ff.deleter_id, ff.rp, ff.important, ff.del, ff.locked FROM forum_category fc
			RIGHT JOIN forum_forum ff ON fc.id = ff.category
			WHERE ff.id = ?');
			$fname->execute(array($forum));
			$fname = $fname->fetch();
			
			if ($view < 6)
			{
				$fcount = $db->prepare('SELECT COUNT(*) AS pages FROM forum_post WHERE forum_id = ? AND del = 0'); $fcount->execute(array($forum));
				$count = $fcount->fetch();
				$plimit = ceil($count['pages'] / 10);
				$page = ($page > $plimit)? $plimit : $page;
				$pmin = ($page*10)-10;
				$pmax = $page*10;
				
				$select = $db->query("SELECT * FROM forum_post WHERE forum_id = $forum AND del = 0 ORDER BY post_date ASC LIMIT $pmin , $pmax");
			}
			else
			{
				$fcount = $db->prepare('SELECT COUNT(*) AS pages FROM forum_post WHERE forum_id = ?'); $fcount->execute(array($forum));
				$count = $fcount->fetch();
				$plimit = ceil($count['pages'] / 10);
				$page = ($page > $plimit)? $plimit : $page;
				$pmin = ($page*10)-10;
				$pmax = $page*10;
				
				$select = $db->query("SELECT * FROM forum_post WHERE forum_id = $forum ORDER BY post_date ASC LIMIT $pmin , $pmax");
			}
			$dname = $db->prepare('SELECT id,name FROM members WHERE id = ?'); $dname->execute(array($fname['deleter_id']));
			$dname = $dname->fetch();
			$vname = $db->prepare('SELECT id,name FROM members WHERE id = ?'); $vname->execute(array($fname['locker_id']));
			$vname = $vname->fetch();
			$isrp = ($fname['rp'] == 1)? "<span style=\"color:lime;\">[RP]</span> ": "";
			$isimportant = ($fname['important'] == 1)? "<span style=\"color:gold;\">[Important]</span> ": "";
			$isdel = ($fname['del'] == 1)? "<span style=\"color:#990000;\">[Supprimé (par ". $dname['name'].")]</span> ": "";
			$lockinfo = ($view > 5) ? " (par ". $vname['name'].")" : "";
			$islock = ($fname['locked'] == 1)? "<span style=\"color:#990000;\">[Vérrouillé". $lockinfo ."]</span> ": "";
			
			?>
			<h4><?=$islock , $isimportant, $isdel, $isrp?><a href="index?p=forum">Forum</a> > <a href="index?p=forum&cat=<?= $fname['id']?>"><?= $fname['fc_name'] ?></a> > <?= $fname['name']?></h4>
			
			<?php
				if (isset($_POST['sendnew']) AND isset($_POST['newpost']))
				{
					echo "Message envoyé avec succès !";
				}
				elseif (isset($_GET['del']) OR isset($_GET['restore']) Or isset($_POST['editpost']))
				{
					echo $msg;
				}
				$ppage = $page-1;
				$npage = $page+1;
				$first = ($page > 1)? "<a href=\"index?p=forum&forum=". $forum . "&page=1\">[Première Page] </a>" : "";
				$first = ($page > 1)? "<a href=\"index?p=forum&forum=". $forum . "&page=". $ppage ."\">[Page Précédente]</a>" : "";
				$next = ($page < $plimit)? "<a href=\"index?p=forum&forum=". $forum . "&page=". $npage ."\"> [Page Suivante]</a>" : "";
				$last = ($page < $plimit)? "<a href=\"index?p=forum&forum=". $forum . "&page=". $plimit ."\"> [Dernière Page]</a>" : "";
			?>
			<div align="left">
				<?= $first, $preview, $next, $last; ?>
			</div>
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
								$rank = $ranksel['rank'];
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
								$rank = 3;
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
							$delbutton = ($view > 4 AND $view >= $ranksel['rank'])? "<br /><a href='index?p=forum&forum=" . $forum ."&del=" . $line['id'] ."' style='color:red;' />[Supprimer]</a>" : "";
							$editbutton = ($view > 4 AND $view >= $ranksel['rank'] OR $_SESSION['id'] == $line['user_id'] AND $line['post_date'] == NOW())? "<br /><a href='index?p=forum&forum=" . $forum ."&edit=" . $line['id'] ."' style='color:blue;' />[Modifier]</a>": "";
							
						?>
							<tr class="forumrank<?= $rank?>" <?=$isdel?> >
								<td valign="top">
									<p><?= $post?></p>
								</td>
								<td valign="top">
									<?= $img, " " , $a , $title , " ", $user, $aend ,"<br />" , $date, $delmsg, $delbutton, $editbutton;
									?>
								</td>
							</tr>
						<?php		
						}
						$anonymebutton = ($line['rp'] == 1) ? "<label for='sendunknow'>Envoyer ensans signature</label> <input type='check' name='sendunknow' id='sendunknow' /><br />" : "";
						?>
						<tr>
							<td>
								<div width="100%" align="center">
									<?
									if (isset($_GET['edit']))
									{
									?>
									<form action="index?p=forum&forum=<?= $forum?>&page=<?= $page?>&edit=<?= $edit['id']?>" method="POST">
										<label for="newpost" style="text-align:right;">Envoyer une réponse</label><br />
										<textarea style="width: 95%; height: 120px;" id="newpost" name="newpost"><?= $emsg?></textarea><br />
										<input type="submit" style="text-align:right;" name="editpost" value="Modifier" />
									</form>
									<?php
									}
									else
									{
									?>
									<form action="index?p=forum&forum=<?= $forum?>&page=<?= $page?>" method="POST">
										<label for="newpost" style="text-align:right;">Envoyer une réponse</label><br />
										<textarea style="width: 95%; height: 120px;" id="newpost" name="newpost"></textarea><br />
										<?= $anonymebutton ?>
										<input type="submit" style="text-align:right;" name="sendnew" value="Envoyer" />
									</form>
									<?php
									}
									?>
								</div>
							</td>
						</tr>
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
		<div width="100%" style="padding:1%" class="forumbg">
			<?php
			while ($line = $select->fetch())
			{
				$flist = $db->prepare('SELECT * FROM forum_forum WHERE del = 0 AND category = ? ORDER BY important DESC, last_post DESC LIMIT 10');
				$flist->execute(array($line['id']));
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
}
?>
