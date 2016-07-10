<?php function nav ()
{
	define('rank_cbm', 6);
	define('rank_admin',6);

	global $db, $_SESSION, $_GET;

	$page = (isset($_GET['p'])) ? $_GET['p'] : false;
	
	$answer = $db->query("SELECT COUNT(*) AS count FROM candid WHERE verify = 0");
	$line = $answer->fetch();
	$answer->closeCursor();
	
	if ($_SESSION['rank'] < 5) { $width = 20; } elseif ($_SESSION['rank'] == 5) { $width = 16; } elseif ($_SESSION['rank'] > 5) { $width = 14; }
	else { $width = 25;}
	
	if ($_SESSION['connected'])
	{
		$presel = $db->prepare('SELECT * FROM sondage WHERE rank <= ? AND verr = 0');
		$presel->execute(array($_SESSION['rank']));
		$scount = 0;
		while ($sel = $presel->fetch())
		{
			$select = $db->prepare('SELECT * FROM sondage_unread WHERE unread = 1 AND sondage_id = ? AND user_id = ?');
			$select->execute(array($sel['id'], $_SESSION['id']));
			if ($select->fetch())
			{
				$scount ++;
			}
		}
		$select = $db->prepare('SELECT * FROM members WHERE id = ?'); $select->execute(array($_SESSION['id'])); $select = $select->fetch();
	}
	
?>
	<table cellspacing="0" cellpadding="0" style="text-align:center;" width="100%">
      		<tbody>
      			<tr>
      				<td width="<?= $width,'%'?>">
			        	<ul class="menu1">
						<li>
							Accueil <?if ($_SESSION["rank"] >= 5 AND $line['count'] >= 1) { echo '<span style="color:red;">[!]</span>'; }?>
							<div class="menu2">
								<a href="index.php" class="link">
									<div>
										Page d'Accueil
									</div>
								</a>
								<a href="index?p=rules" class="link">
									<div class="link">
										Règles
									</div>
								</a>
								
								<a href="index?p=server" class="link">
									<div>
										Le Serveur
									</div>
								</a>
								<? if ($_SESSION['rank'] < 5 AND $select['accepted'] == 0 OR $_SESSION['rank'] > 4)
								{
								?>
								<a href="index?p=candid" class="link">
									<div>
										<?if ($_SESSION["rank"] >= 5 AND $line['count'] >= 1) {?>
										<span style="color: red">[<?= $line['count']?>]</span><? } ?>
										Candidature
									</div>
								</a>
								<?php } ?>
							</div>
						</li>
					</ul>
			        </td>
			        <td width="<?= $width,'%'?>">
			        	<ul class="menu1">
						<li>
							Communauté <? if ($scount > 0) { echo '<span style="color:red;">[!]</span>'; } ?>
							<div class="menu2">
								<a href="index?p=news" class="link">
									<div>
										Actualités
									</div>
								</a>
								
								<a href="index?p=members" class="link">
									<div>
										Membres
									</div>
								</a>
								
								<a href="index?p=forum" class="link">
									<div>
										Forums
									</div>
								</a>
								
								<a href="index?p=chatbox" class="link">
									<div>
										Dialogue en Direct
									</div>
								</a>
								
								<a href="index?p=update" class="link">
									<div>
										Maintenance
									</div>
								</a>
								<?php if ($_SESSION['connected'])
								{
								?>
								<a href="index?p=sondage" class="link">
									<div>
										<?php
										if ($scount > 0)
										{ echo '<span style="color:red;">[', $scount,']</span>'; }
										?>
										Sondages
									</div>
								</a>
								<?php
								}
								?>
							</div>
						</li>
					</ul>
			        </td>
			        <td width="<?= $width,'%'?>">
			        	<ul class="menu1">
						<li>
							Contenu
							<div class="menu2">
								<a href="index?p=races" class="link">
									<div>
										Races
									</div>
								</a>
								
								<a href="index?p=guilds" class="link">
									<div>
										Les Groupes
									</div>
								</a>
								
								<a href="index?p=credits" class="link">
									<div>
										Crédits Divers
									</div>
								</a>
								
								<a href="index?p=chatbox" class="link">
									<div>
										Dialogue en Direct
									</div>
								</a>
								
								<a href="index?p=staffteam" class="link">
									<div>
										L'Equipe Admin'
									</div>
								</a>
							</div>
						</li>
					</ul>
			        </td>
			         <?php if ($_SESSION['rank'] > 4)
			         {
			         ?>
			        <td width="<?= $width,'%'?>">
			        	<ul class="menu1">
						<li>
							Modération <?php if ($_SESSION['name'] == "Lune" OR $_SESSION['name'] == "Nikho") {
								$dev = $db->query('SELECT COUNT(*) AS dev FROM dev WHERE isok = 0'); $dev = $dev->fetch(); $dev = $dev['dev'];
							if ($dev > 0)
							{
							echo '<span style="color:red;">[!]</span>';
							}
							}?>
							<div class="menu2">
								<a href="index?p=whitelist" class="link">
									<div>
										Whitelist
									</div>
								</a>
								
								<a href="index?p=background" class="link">
									<div>
										Le BackGround
									</div>
								</a>
								
								<a href="index?p=event" class="link">
									<div>
										Evènements
									</div>
								</a>
								
								<a href="index?p=magie_admin" class="link">
									<div>
										Administration Magique
									</div>
								</a>
								<?php if ($_SESSION['name'] == "Lune" OR $_SESSION['name'] == "Nikho")
								{
								?>
								<a href="index?p=dev" class="link">
									<div>
										<?php
										if ($dev > 0)
										{ echo '<span style="color:red;">[', $dev,']</span> '; }
										?>Requêtes de Développement
									</div>
								</a>
								<?php
								}
								?>
							</div>
						</li>
					</ul>
			        </td>
			        <?php
				}
				?>
			        <?php if ($_SESSION['rank'] > 5)
			        {
			        ?>
			        <td width="<?= $width,'%'?>">
			        	<ul class="menu1">
						<li>
							Administration
							<div class="menu2">
								<a href="index?p=chat_ig" class="link">
									<div>
										Chat In Game
									</div>
								</a>
								
								<a href="index?p=chatboxmj" class="link">
									<div>
										ChatBox MJ
									</div>
								</a>
								
								<a href="index?p=serv_admin" class="link">
									<div>
										Administration Serveur
									</div>
								</a>
								
								<a href="index?p=chrono" class="link">
									<div>
										Chronologie
									</div>
								</a>
								
								<a href="index?p=rulesmj" class="link">
									<div>
										Règlement MJ
									</div>
								</a>
								
								<a href="index?p=pnj_list" class="link">
									<div>
										Liste des PNJs
									</div>
								</a>
							</div>
						</li>
					</ul>
				</td>
				<?php
			        }
			        ?>
			        <?php if($_SESSION['connected'])
			        {
			        ?>
				<td width="<?= $width,'%'?>">
					<ul class="menu1">
						<li>
							Magie
							<div class="menu2">
								<a href="index?p=sorts" class="link">
									<div>
										Mes Sorts
									</div>
								</a>
								<a href="index?p=skills" class="link">
									<div>
										Mes Aptitudes
									</div>
								</a>
							</div>
						</li>
					</ul>
			        </td>
			       	<td width="<?= $width,'%'?>">
			       		<?php
			       		$report = $db->query('SELECT COUNT(*) AS report FROM report WHERE resolve = 0'); $report = $report->fetch(); $report = $report['report'];
			       		?>
					<ul class="menu1">
						<li>
							Mon Compte <?php if ($_SESSION['alertNewMsgs'] OR $report > 0 AND $_SESSION['rank'] > 4) { echo '<span style="color:red;">[!]</span>';}?>
							<div class="menu2">
								<a href="index?p=perso" class="link">
									<div>
										Mon Personnage
									</div>
								</a>
								
								<a href="index?p=report" class="link">
									<div>
										<?php
										if ($report > 0 AND $_SESSION['rank'] > 4)
										{ echo '<span style="color:red;">[', $report,']</span> '; }?>
										Rapport d'Erreur
									</div>
								</a>
								
								<a href="index?p=pm" class="link">
									<div>
										<?php if ($_SESSION['alertNewMsgs']) { ?><span style="color:red">[<?= $_SESSION['alertNewMsgs']?>] </span><?php
										} ?> Message Privés
									</div>
								</a>
								
								<a href="index?p=account" class="link">
									<div>
										Mon Compte
									</div>
								</a>
								
								<a href="index?p=login&action=disconnection" class="link">
									<div>
										Deconnexion
									</div>
								</a>
							</div>
						</li>
					</ul>
			        </td>
			        <?php
			        }
			        else
			        {
			        ?>
			        <td width="<?= $width,'%'?>">
					<ul class="menu1">
						<li>
							Enregistrement
							<div class="menu2">
								<a href="index?p=register" class="link">
									<div>
										S'inscrire
									</div>
								</a>
								
								<a href="index?p=login" class="link">
									<div>
										Se connecter
									</div>
								</a>
							</div>
						</li>
					</ul>
			        </td>
			        <?php
			        }
			        ?>
      			</tr>
      		</tbody>
      	</table>
	
<?php 
}
?>
