<?php function nav ()
{
	define('rank_cbm', 6);
	define('rank_admin',6);

	global $db, $_SESSION, $_GET;

	$page = (isset($_GET['p'])) ? $_GET['p'] : false;
	
	$answer = $db->query("SELECT COUNT(*) AS count FROM candid WHERE verify = 0");
	$line = $answer->fetch();
	$answer->closeCursor();
	
	
?>
<!--	
<?php if (!$_SESSION['connected']) { ?>
	<div class="navtitle">Enregistrement</div>
		<ul class="nav">
			<a class="link" href="index.php?p=register" >
				<li class="navbg" <?php echo ($page == 'register') ? 'class="cur_page"' : '';?>><img src="/pics/icoregister.gif" alt="" />Inscription</li>
			</a>
			<a class="link" href="index.php?p=login" >
				<li class="navbg" <?php echo ($page == 'login') ? 'class="cur_page"' : '';?>><img src="/pics/ico/connection.gif" alt="" />Connexion</li>
			</a>
		</ul>
<?php }?>
<?php if ($_SESSION['connected']) { if ($_SESSION['pionier'] == 1) { $pionier = "-P";} else { $pionier = '';} if ($_SESSION['technician'] == 1) { $tech = "-T";} else { $tech = '';} ?>
		<div class="navtitle">Compte</div>
		<ul class="nav">
			<li class="navbg2" style="padding: 16px;"><span class="name<?= $_SESSION['rank']?><?echo $tech?><?echo $pionier?>"><? if ($_SESSION['pionier'] == 1) { echo "Pionier";} else { echo $_SESSION['title'] ;}?> <?= $_SESSION['name' ]?></span></li>
			<a class="link" href="index.php?p=perso" >
				<li class="navbg" <?php echo ($page == 'perso') ? 'class="cur_page"' : '';?>><img src="/pics/ico/page.gif" alt="" />Personnage</li>
			</a>
			<a class="link" href="index.php?p=pm" >
				<li class="navbg" <?php echo ($page == 'pm') ? 'class="cur_page"' : '';?>><img src="/pics/ico/pm.gif" alt="" />Messages Privés
					<? if ($_SESSION['alertNewMsgs']) { ?>
						<span style="color:red">[<?= $_SESSION['alertNewMsgs']?>] </span>
					<? } ?>
				</li>
			</a>
			<a class="link" href="index.php?p=account" >
				<li class="navbg" <?php echo ($page == 'account') ? 'class="cur_page"' : '';?>><img src="/pics/ico/option.gif" alt="" />Mon Compte</li>
			</a>
			<a class="link" href="index.php?p=login&amp;action=disconnection" >
				<li class="navbg" ><img src="includes/img/porte.gif" alt="" />Déconnexion</li>
			</a>
		</ul>
<?php } ?>
	
<?php if ($_SESSION["rank"] >= 3) { 
			
	$answer = $db->query('SELECT COUNT(*) AS ngrada FROM hist_grada');
	$line = $answer->fetch();
	$answer->closeCursor();

	$numMax = $line['ngrada'];
	$numMin = ($numMax >= 10) ? ($numMax - 10) : 0;
				
	$grada = $db->query('SELECT * FROM hist_grada ORDER BY id DESC LIMIT 10');
?>
	<div class="navtitle">Progression</div>
		<ul class="nav" style="padding: 10px;">
<?php	  
	while ($line = $grada->fetch())
	{	switch ($line['method']) { case 0: $gradam= "-" ; $gradat= "dégradé"; break; case 1: $gradam= "+"; $gradat= "promu"; break;} 
				$datasMemb = $db->query('SELECT * FROM members WHERE members.id = \'' .$line['upped_id']. '\'');
				$datasupped = $datasMemb->fetch();
				$datasMemb = $db->query('SELECT * FROM members WHERE members.id = \'' .$line['upper_id']. '\'');
				$datasupper = $datasMemb->fetch();
	?>
			<li style="list-style-type: none;">[<? echo $gradam ?>] <img src="pics/rank<?php echo $datasupped['rank']; ?>" width="25" class="magie_type" title="<?= $datasupper['name']?> a <? echo $gradat ?> <?= $datasupped['name']?> !" /> <?= $datasupped['name']?></li>
<?php } ?>
		</ul>
<?php } ?>

	<div class="navtitle">Plateformes</div>
		<ul class="nav">
			<li class="navbg2" style="font-size: 12px;list-style-type: none;"><img src="/pics/ico/ts.gif" alt="" />rpnix.ts3serv.com:10261</li>
			<li class="navbg2" style="clear: both;;list-style-type: none;"><img src="/pics/ico/twitter.gif" alt="" /><a href="https://twitter.com/RPNixfr" target=_blank >@RPNixfr</a></li>
		</ul>
		
	<div class="navtitle">Découvrez :</div>
		<ul class="nav">
			<a href="http://www.herobrine.fr" target=_blank >
				<li class="navbg2" style="list-style-type: none;"><img src="/pics/ico/hb.gif" alt="" />Herobrine.fr</li>
			</a>
		</ul>
		
	<div class="navtitle">Nos Pioniers</div>
		<p class="navbg2" style="text-align: center;">Membres honorable qui ont apporté un soutien considérable à Nix !<br />
		<br />
		&bull; Alwine<br />
		&bull; Einarr<br />
		&bull; Glenn<br />
		&bull; Lune<br />
		&bull; Shaolern<br />
		&bull; Zelenan</p> -->
	
	<table cellspacing="0" cellpadding="0" style="text-align:center;" width="100%">
      		<tbody>
      			<tr>
      				<td>
			        	<ul class="menu1">
						<li>
							Acceuil
							<ul class="menu2">
								<a href="index.php" class="link">
									<li>
										Acceuil
									</li>
								</a>
								<a href="index?p=rules" class="link">
									<li>
										Règles
									</li>
								</a>
								<a href="index?p=server" class="link">
									<li>
										Le Serveur
									</li>
								</a>
								<a href="index?p=candid" class="link">
									<li>
										Candidature
									</li>
								</a>
							</ul>
						</li>
					</ul>
			        </td>
			        <td>
			        	<ul class="menu1">
						<li>
							Communauté
							<ul class="menu2">
								<a href="index?p=news" class="link">
									<li>
										Actualités
									</li>
								</a>
								<a href="index?p=members" class="link">
									<li>
										Membres
									</li>
								</a>
								<a href="index?p=forum" class="link">
									<li>
										Forums
									</li>
								</a>
								<a href="index?p=chatbox" class="link">
									<li>
										Dialogue en Direct
									</li>
								</a>
								<a href="index?p=update" class="link">
									<li>
										Info Maintenance
									</li>
								</a>
								<?php if ($_SESSION['connected'])
								{
								?>
								<a href="index?p=sondage" class="link">
									<li>
										Sondages
									</li>
								</a>
								<?php
								}
								?>
							</ul>
						</li>
					</ul>
			        </td>
			        <td>
			        	<ul class="menu1">
						<li>
							Contenu
							<ul class="menu2">
								<a href="index?p=races" class="link">
									<li>
										Les Races
									</li>
								</a>
								<a href="index?p=guilds" class="link">
									<li>
										Les Groupes
									</li>
								</a>
								<a href="index?p=staffteam" class="link">
									<li>
										L'Equipe Admin'
									</li>
								</a>
							</ul>
						</li>
					</ul>
			        </td>
			         <?php if ($_SESSION['rank'] > 4)
			         {
			         ?>
			        <td>
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
			        <td>
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
				<td>
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
			       	<td>
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
			        ?>
      			</tr>
      		</tbody>
      	</table>
	
<?php 
}
?>
