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
	
?>
	<table cellspacing="0" cellpadding="0" style="text-align:center;" width="100%">
      		<tbody>
      			<tr>
      				<td width="<?= $width,'%'?>">
			        	<ul class="menu1">
						<li>
							Acceuil
							<div class="menu2">
								<a href="index.php" class="link">
									<div>
										Acceuil
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
								
								<a href="index?p=candid" class="link">
									<div>
										<?if ($_SESSION["rank"] >= 5 AND $line['count'] >= 1) {?>
										<span style="color: red">[<?= $line['count']?>]</span><? } ?>
										Candidature
									</div>
								</a>
							</div>
						</li>
					</ul>
			        </td>
			        <td width="<?= $width,'%'?>">
			        	<ul class="menu1">
						<li>
							Communauté
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
							Modération
							<ul class="menu2">
								<a href="index?p=whitelist" class="link">
									<li>
										La Whitelist
									</li>
								</a>
								<a href="index?p=staffcontent" class="link">
									<li>
										Le BackGround
									</li>
								</a>
								<a href="index?p=magie_admin" class="link">
									<li>
										Administration Magique
									</li>
								</a>
							</ul>
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
							<ul class="menu2">
								<a href="index?p=chat_ig" class="link">
									<li>
										Chat In Game
									</li>
								</a>
								<a href="index?p=chatboxmj" class="link">
									<li>
										Chat Box MJ
									</li>
								</a>
								<a href="index?p=serv_admin" class="link">
									<li>
										Administration Serveur
									</li>
								</a>
								<a href="index?p=chrono" class="link">
									<li>
										Chronologie
									</li>
								</a>
								<a href="index?p=rulesmj" class="link">
									<li>
										Règlement MJ
									</li>
								</a>
								<a href="index?p=pnj_list" class="link">
									<li>
										Liste des PNJs
									</li>
								</a>
							</ul>
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
							<ul class="menu2">
								<a href="index?p=sorts" class="link">
									<li>
										Mes sorts
									</li>
								</a>
							</ul>
						</li>
					</ul>
			        </td>
			       	<td width="<?= $width,'%'?>">
					<ul class="menu1">
						<li>
							Mon Compte
							<ul class="menu2">
								<a href="index?p=perso" class="link">
									<li>
										Mon Personnage
									</li>
								</a>
								<a href="index?p=pm" class="link">
									<li>
										<?php if ($_SESSION['alertNewMsgs']) { ?><span style="color:red">[<?= $_SESSION['alertNewMsgs']?>] </span><?php
										} ?>
										Messages Privés
									</li>
								</a>
								<a href="index?p=account" class="link">
									<li>
										Mon Compte
									</li>
								</a>
								<a href="index?p=login&action=disconnection" class="link">
									<li>
										Se Déconnecter
									</li>
								</a>
							</ul>
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
							<ul class="menu2">
								<a href="index?p=register" class="link">
									<li>
										S'inscrire
									</li>
								</a>
								<a href="index?p=login" class="link">
									<li>
										Se connecter
									</li>
								</a>
							</ul>
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
