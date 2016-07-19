<?php function showPage ()
{
	
	global $db, $_POST, $_GET, $_SESSION;

	$answer = $db->query("SELECT * FROM members");
	$line = $answer->fetch();
	$answer->closeCursor();
	
	$page = (isset($_GET['p'])) ? $_GET['p'] : '';

	if ($_SESSION['connected'])
	{
		$account = $db->prepare('SELECT * FROM members WHERE id = ?');
		$account->execute(array($_SESSION['id']));
		$account = $account->fetch();
		
		if ($account['ban'] == 1 OR $account['removed'] == 1)
		{
			$_SESSION['connected'] = false;
		}
	}
	?>
	
<div>
  <table cellspacing="0" cellpadding="0" width="100%" background="http://pre05.deviantart.net/181d/th/pre/i/2014/048/6/9/broken_wings_by_t1na-d76uf1r.jpg">
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
						<?php include('includes/news.php'); news('disp'); echo ' ';?>
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
					<div>
						<?php include('includes/aside.php'); 	aside(); ?>
					</div>
      				</td>
				 <td valign="top" width="100%">
				 	<!--<div class="bigalert">
						<h1>Contenu Bêta</h1>
						<p>Certaines fonctionnalités du site sont encore en cours d'élaboration, RPNix n'en est qu'à la version bêta mais reste tout de même libre d'entrée !<br />
						Vous pouvez toujours vous tenir au courant des mises à jour à venir ou des fonctions futures auprès des membres du Staff concernés !</p>
					</div>-->
					<?php 
						include('includes/alert.php'); 		alert();
						include('includes/a_alerts.php');	a_alerts();
					?>
					<div id="main">
					<?php
				        	switch ($page)
						{
							case '' : 				{	include('includes/home.php'); 					home(); 				break; }
							case 'login': 				{	include('includes/login.php'); 					login(); 				break; }
							case 'testb': 				{	include('includes/testb.php'); 					testb(); 				break; }
							case 'report': 				{	include('includes/report.php'); 					report(); 				break; }
							case 'register':			{	include('includes/register.php'); 				register(); 			break; }
							case 'a': 				{ 	include('includes/activate.php'); 				activate(); 			break; }
							case 'credits': 			{ 	include('includes/credits.php'); 				credits(); 				break; }
							case 'members': 			{ 	include('includes/members.php'); 				members(); 				break; }
							case 'chatbox': 			{ 	include('includes/chatbox/chatboxPage.php'); 	chatboxPage(); 			break; }
							case 'chatboxmj': 			{ 	if ($_SESSION['rank'] >= rank_cbm) { 	include('includes/chatbox_mj/chatboxPage.php');
							chatboxPage(); 				} 	else { 	?><p>Vous n'aves pas accès à cette page</p><?php 	} 			break; }
							case 'forum': 				{ 	include('includes/forum.php'); 					forum(); 				break; }
							case 'event': 				{ 	include('includes/event.php'); 					event(); 				break; }
							case 'perso': 				{ 	include('includes/perso.php'); 					perso(); 				break; }
							case 'rules': 				{ 	include('includes/rules.php'); 					rules(); 				break; }
							case 'account': 			{ 	include('includes/account.php'); 				account(); 				break; }
							case 'guilds': 				{ 	include('includes/guilds.php'); 				guilds(); 				break; }
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
							case 'background': 			{ 	include('includes/background.php'); 			background(); 		break; }
							case 'rulesmj': 			{ 	include('includes/rulesmj.php'); 				rulesmj(); 				break; }
						//Erreur 404 
							case '404': 				{ 					?><p>Page inexistante.</p><?php 						break; }
							default : 				{ 					?><p>Page inexistante.</p><?php 						break; }
							case 'chrono': 				{ 	include('includes/chrono.php'); 				chrono(); 				break; }
							case 'bg_admin': 			{ 	include('includes/bg_admin.php'); 				bg_admin(); 			break; }
							case 'bg_package': 			{ 	include('includes/bg_package.php'); 			bg_package(); 			break; }
							case 'bg_class': 			{ 	include('includes/bg_class.php'); 				bg_class();				break; }
							case 'bg_category': 			{ 	include('includes/bg_category.php'); 			bg_category(); 			break; }
							case 'bg_sub': 				{ 	include('includes/bg_sub.php'); 				bg_sub(); 				break; }
							case 'bg_content': 			{	include('includes/bg_content.php'); 			bg_content(); 			break; }
							case 'update': 				{ 	include('includes/update.php'); 				update(); 				break; }
							case 'sondage': 			{ 	include('includes/sondage.php'); 				sondage(); 				break; }
							case 'sorts': 				{ 	include('includes/sorts.php'); 				sorts(); 				break; }
							case 'nikho76': 			{ 	include('includes/regeneration.php'); 				regeneration(); 				break; }
							case 'herobrinesg': 			{ 	include('includes/private.php'); 				privated(); 				break; }
							case 'dev': 				{ 	include('includes/dev.php'); 				dev(); 				break; }
							case 'skills': 				{ 	include('includes/skills.php'); 				skills(); 				break; }
							case 'enca': 				{ 	include('includes/enca.php'); 				enca(); 				break; }
							case 'translate': 			{ 	include('includes/translate.php'); 				translate(); 				break; }
							case 'relics': 				{ 	include('includes/relics.php'); 				relics(); 				break; }
						} 
						?>
					</div>
					<div id="main" style="margin-top:20px;">
						<?php include('includes/chatbox/chatboxPagemini.php'); chatboxminiPage(); ?>
					</div>
				  </td>
      			</tr>
      		</tbody>
      	</table>
      	</td>
      </tr>
      <tr>
        <td id="footer">
        	<div>
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
