<?php function showPage ()
{
	
	global $db, $_POST, $_GET, $_SESSION;

	$answer = $db->query("SELECT * FROM members");
	$line = $answer->fetch();
	$answer->closeCursor();
	
	$page = (isset($_GET['p'])) ? $_GET['p'] : '';

	
	?>
	<div id="site">
			
			<table>
				<tbody>
					<tr>
						<table>
							<tbody>
								<tr>
									<td width="20%">
										<a href="index.php"><img src="pics/logo1.gif" alt="" /></a>
									</td>
									<td style="text-align: right;" width="600%">
										<p>
											<?php include('includes/news.php'); news('disp');?>
										</p>
									</td>
									<td width="10%">
										<img src="http://herobrine.fr/blapproved.php?bid=3" title="Approved by BL">
									</td>
									<td width="10%x">
										<a href="https://minecraft.net/" target=_blank><img src="http://herobrine.fr/pics/mc1.png" alt="" /></a>
									</td>
								</tr>
							</tbody>
						</table>
					</tr>
						
					<tr>
					
						<table id="main_c" cellspacing="20" cellpadding="0">
							<tbody>
								<tr>
									<td width="270" valign="top">
										<?php
											//include('includes/nav.php'); 		nav();
											//include('includes/loggedIn.php'); 	loggedIn();
										?>
									</td>
									<td width="*" valign="top">
										<div class="bigalert">
											<h1>Contenu Bêta</h1>
											<p>Certaines fonctionnalités du site sont encore en cours d'élaboration, RPNix n'en est qu'à la version bêta mais reste tout de même libre d'entrée !<br />
											Vous pouvez toujours vous tenir au courant des mises à jour à venir ou des fonctions futures auprès des membres du Staff concernés !</p>
										</div>
										
											<?php 
												include('includes/alert.php'); 		alert();
											?>
										
										
										<? 
									if ($_SESSION['connected'])
									{
										$id = $_SESSION['id'];
										$sel = $db->prepare('SELECT COUNT(*) AS plus FROM hrpavis WHERE target_id = ? AND avis = 1 AND sender_rank <= 4');
										$sel->execute(array($id)); $sel = $sel->fetch();
										$sel1 = $db->prepare('SELECT COUNT(*) AS plusstaff FROM hrpavis WHERE target_id = ? AND avis = 1 AND sender_rank > 4');
										$sel1->execute(array($id)); $sel1 = $sel1->fetch();
										$sel2 = $db->prepare('SELECT COUNT(*) AS moins FROM hrpavis WHERE target_id = ? AND avis = 0 AND sender_rank <= 4');
										$sel2->execute(array($id)); $sel2 = $sel2->fetch();
										$sel3 = $db->prepare('SELECT COUNT(*) AS moinsstaff FROM hrpavis WHERE target_id = ? AND avis = 0 AND sender_rank > 4');
										$sel3->execute(array($id)); $sel3 = $sel3->fetch();
										$countj = $sel1['plus'] - $sel2['moins'];
										$plus = $sel1['plusstaff'] * 2; $moins = $sel3['moinsstaff'] * 2;
										$counts = $plus - $moins; $hrpavis = $countj + $counts;
										$sel4 = $db->prepare('SELECT * FROM members WHERE id = ?');
										$sel4->execute(array($id)); $sel4 = $sel4->fetch();
										if ($sel4['E_magique'] <= 30 AND $sel4['E_magique'] > 0){ ?>
										<div class="alert">
										<h3>Fatigue grandissante du personnage</h3>
										<p>Du fait de la perte de presque la totalité de ses Points de Magie (PM), votrepersonnage souffre d'une fatigue assez prenoncée, il devient moins endurant, irritable, et il est compliqué pour lui de rester concentré sur des tâches complexes.
										</p><p>La restauration des flux magique de votre personnage sera naturelle. Aussi bien faites attention la prochaine fois que vous abusez des sorts.</p>
										</div>
										<? } if ($sel4['E_magique'] == 0) {?>
										<div class="alert">
										<h3>Perte des ressources magiques</h3>
										<p>Après la perte de la totalité de vos Points de Magie (PM) votre persnne se voit très régulièrement épuisé, si de nouveaux sorts sont tentés, le coût de ces derniers impactera
										les Points Vitaux (PV) de votre personnage.<br />
										Il n'est jamais bon de voir cette jauge atteindre zéro.</p>
										<p>La restauration des flux magique de votre personnage sera naturelle. Aussi bien faites attention la prochaine fois que vous abusez des sorts.</p>
										</div>
										<? } if ($sel4['E_vitale'] <= 50 AND $sel4['E_vitale'] > 0) {?>
										<div class="alert">
										<h3>Points Vitaux faibles</h3>
										<p>Après la perte de plus de 75% de ses Points Vitaux (PV), votre personnage perd peu à peu pied dans la réalité, il somnole de manière chronique, et est victime de troubles de
										la concentration aigües.</p>
										<p>La restauration des flux vitaux est relativement longue, la prudence sera de mise à l'avenir aux yeux du personnage.</p>
										</div>
										<? } if ($sel4['E_vitale'] == 0) { ?> <div class="alert">
										<h3>Perte total des repères</h3>
										<p>Suite à la perte totale des Points Magiques puis Vitaux (PM) (PV) votre personnage perd totalement la raison, il sera incapable d'aligner trois phrases cohérentes et impossible d'effectuer le moindre sort.<br />
										Il peut arriver que le récent perdu ne sache plus faire la différence entre allié et ennemi.</p>
										<p>La restauration des flux vitaux est relativement longue, la prudence sera de mise à l'avenir aux yeux du personnage.</p>
										</div>
										<?  }
										if ($hrpavis >= 10 OR $sel4['rank'] > 2 ) {
										if ($sel4['buildok'] == 0 AND $page != "testb")
										{
										?>
										<div class="alert">
										<h3>Test de construction</h3>
										<p>Vous pouvez maintenant remplir le questionnaire qui vous permettra de demander à un Membre du Staff le mode survie.</p>
										<p>
											<a href="index?p=testb">Cliquez ici</a> pour vous rendre à la page du questionnaire.
										</p>
										</div>
										<?php } }
										if ($sel4['race'] == "Inconnue" AND $line['rank'] > 1)
										{
										?>
										<div class="alert">
										<h3>Choix de race.</h3>
										<p>Vous n'avez pas encore choisi la race de votre personnage, il est nécessaire que vous la définissiez au plus vite afin de vous garantir les avantages
										des races en question ainsi que les Membres du Staff puisent vous encadrer correctement.</p>
										<p>Pour choisir votre race, rendez-vous sur <a href="index?p=perso">cette page</a>.</p>
										</div>
										<?php
										}
									}?>
										
										<div id="main">
											<?php
											if ($_SESSION['connected'] && $page != 'login' && $_SESSION['ban'] == 1) {
												include('includes/ban_page.php'); ban_page(); ?>
											<?php
											}
											else
											{

											switch ($page)
											{
												case '' : 				{	include('includes/home.php'); 					home(); 				break; }
												case 'login': 				{	include('includes/login.php'); 					login(); 				break; }
												case 'testb': 				{	include('includes/testb.php'); 					testb(); 				break; }
												case 'glennforum':			{	include('includes/glennforum.php');				glennforum(); 			break; }
												case 'glenngroups':			{	include('includes/glenngroups.php');			glenngroups(); 			break; }
												case 'register':			{	include('includes/register.php'); 				register(); 			break; }
												case 'a': 				{ 	include('includes/activate.php'); 				activate(); 			break; }
												case 'members': 			{ 	include('includes/members.php'); 				members(); 				break; }
												case 'chatbox': 			{ 	include('includes/chatbox/chatboxPage.php'); 	chatboxPage(); 			break; }
												case 'chatboxmj': 			{ 	if ($_SESSION['rank'] >= rank_cbm) { 	include('includes/chatbox_mj/chatboxPage.php');
												chatboxPage(); 				} 	else { 	?><p>Vous n'aves pas accès à cette page</p><?php 	} 			break; }
												case 'forum': 				{ 	include('includes/forum.php'); 					forum(); 				break; }
												case 'perso': 				{ 	include('includes/perso.php'); 					perso(); 				break; }
												case 'rules': 				{ 	include('includes/rules.php'); 					rules(); 				break; }
												case 'account': 			{ 	include('includes/account.php'); 				account(); 				break; }
												case 'guilds': 				{ 	include('includes/guilds.php'); 				guilds(); 				break; }
												case 'incantations_admin': 		{ 	include('includes/incantations_admin.php'); 	incantations_admin(); 	break; }
												case 'pnj_list': 			{ 	include('includes/pnj_list.php'); 				pnj_list(); 			break; }
												case 'pm': 				{ 	include('includes/pm.php'); 					pm(); 					break; }
												case 'news': 				{ 													news('page'); 			break; }
												case 'races': 				{ 	include('includes/races.php'); 					races(); 				break; }
												case 'chat_ig': 			{ 	include('includes/interface/chat_ig.php'); 		chat_ig(); 				break; }
												case 'whitelist': 			{ 	include('includes/interface/whitelist.php'); 	whitelist_page(); 		break; }
												case 'serv_admin': 			{ 	include('includes/interface/serv_admin.php'); 	serv_admin(); 			break; }
												case 'groups': 				{ 	include('includes/groups.php'); 				groups(); 				break; }
												case 'candid': 				{ 	include('includes/candid.php'); 				candid(); 				break; }
												case 'server': 				{ 	include('includes/server.php'); 				server(); 				break; }
												case 'magie_admin': 			{ 	include('includes/magie_admin.php'); 			magie_admin(); 			break; }
												case 'testpage': 			{ 	include('includes/testpage.php'); 				testpage(); 			break; }
												case 'testpage_3': 			{ 	include('includes/testpage_3.php'); 			testpage_3(); 			break; }
												case 'testpage_2': 			{ 	include('includes/testpage_2.php');				testpage_2(); 			break; }
												case 'staffteam': 			{ 	include('includes/staffteam.php'); 				staffteam(); 			break; }
												case 'staffcontent': 			{ 	include('includes/staffcontent.php'); 			staffcontent(); 		break; }
												case 'rulesmj': 			{ 	include('includes/rulesmj.php'); 				rulesmj(); 				break; }
												//Erreur 404 
												case '404': 				{ 					?><p>Page inexistante.</p><?php 						break; }
												default : 				{ 					?><p>Page inexistante.</p><?php 						break; }
												case 'chrono': 				{ 	include('includes/chrono.php'); 				chrono(); 				break; }
												case 'incantations': 			{ 	include('includes/incantations.php'); 			incantations(); 		break; }
												case 'bg_admin': 			{ 	include('includes/bg_admin.php'); 				bg_admin(); 			break; }
												case 'bg_package': 			{ 	include('includes/bg_package.php'); 			bg_package(); 			break; }
												case 'bg_class': 			{ 	include('includes/bg_class.php'); 				bg_class();				break; }
												case 'bg_category': 			{ 	include('includes/bg_category.php'); 			bg_category(); 			break; }
												case 'bg_sub': 				{ 	include('includes/bg_sub.php'); 				bg_sub(); 				break; }
												case 'bg_content': 			{	include('includes/bg_content.php'); 			bg_content(); 			break; }
												case 'update': 				{ 	include('includes/update.php'); 				update(); 				break; }
												case 'sondage': 			{ 	include('includes/sondage.php'); 				sondage(); 				break; }
												case 'sorts': 			{ 	include('includes/sorts.php'); 				sorts(); 				break; }
												case 'nikho76': 			{ 	include('includes/regeneration.php'); 				regeneration(); 				break; }
												case 'herobrinesg': 			{ 	include('includes/private.php'); 				privated(); 				break; }
											} 
											}
											?>
											
										</div>
										<?php  if ($page != "chatbox" OR $page != "login" OR $page != "chatboxmj") { ?>
										<div id="main" style="margin-top:20px;">
										<?php include('includes/chatbox/chatboxPagemini.php'); chatboxminiPage(); ?>
										</div>	
										<?php
										}
										?>
									</td>
								</tr>
							
							</tbody>
						</table>
					</tr>
					<tr>
						<div id="footer">
							<p>Nix est un site communautaire à destination des joueurs de Minecraft. Le contenu de ce site internet est une fiction - 2015</p>
						</div>
					</tr>
				</tbody>
			</table>
		</div>
	
	<div>
  <table cellspacing="0" cellpadding="0" style="background-color:white;" width="100%" background="pics/Nix.jpg">
    <tbody>
      <tr>
      	<td>
      		<table cellspacing="0" cellpadding="0" style="background-color: white;">
      			<tbody>
      				<td width="20%">
					<a href="index.php"><img src="pics/logo1.gif" alt="" /></a>
				</td>
				<td style="text-align: right;" width="600%">
					<p>
						News
					</p>
				</td>
				<td width="10%">
					<img src="http://herobrine.fr/blapproved.php?bid=3" title="Approved by BL">
				</td>
				<td width="10%">
					<a href="https://minecraft.net/" target=_blank><img src="http://herobrine.fr/pics/mc1.png" alt="" /></a>
				</td>
      			</tbody>
      		</table>
      	</td>
      </tr>
      <tr>
      	<td>
      		<?php include ('includes/nav.php'); nav(); ?>
      	</td>
      </tr>
      <tr>
      	<td>
      		<table cellspacin="20" cellpadding="20">
      		<tbody>
      			<tr>
				<td width="270" valign="top">
					<div style="background-color: white;">
						<?php include('includes/loggedIn.php'); 	loggedIn(); ?>
					</div>
      				</td>
				 <td>
					   <div id="main" width="*">
				          	Contenu
				          </div>
				  </td>
      			</tr>
      		</tbody>
      	</table>
      	</td>
      </tr>
      <tr>
        <td>
        	<div id="footer">
			<p>Nix est un site communautaire à destination des joueurs de Minecraft. Le contenu de ce site internet est une fiction - 2015</p>
		</div>
        </td>
      </tr>
    </tbody>
  </table>
</div>	
	<script>
		var button = document.getElementById('button_menu');
		var header = document.getElementById('header');
		var pageAside = document.getElementById('page_aside');
		var content = document.getElementById('cell_main');
		var dispMenu = false;

		button.addEventListener('click', function () {
			if (dispMenu)
			{
				pageAside.style.display = 'none';
				header.style.display = 'none';
				content.style.display = 'block';
				dispMenu = false;
			}
			else
			{
				pageAside.style.display = 'block';
				header.style.display = 'block';
				content.style.display = 'none';
				dispMenu = true;
			}
		}, false);
	</script>
	
		<!-- Site créé par Alwine pour Nix, maintenu par Nikho, serveur de roleplay sur Minecraft.-->

	<?php
}
?>
