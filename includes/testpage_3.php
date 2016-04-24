<?php function testpage_3 ()
{
?>
<style>
 ul ul {display: none; position: absolute;top: -1 li; left: -20px; margin: 0px; padding: 0px;}
li {list-style-type: none; position: relative;}
li:hover ul.menu2, li li:hover ul.niveau3 {display: block}
.menu1
{
	background-color: #8080ee;
	line-height: 20px;
	margin-top: 0;
	margin-bottom: 0px;
	padding: 10px;
	z-index: 2;
}
.menu2
{
	background-color: #a0a0ee;
	line-height: 20px;
	margin-top: 0;
	margin-bottom: 0px;
	padding: 0;
	width: 120%;
	padding: 10px;
	z-index: 3;
}
</style>
<div>
  <table cellspacing="0" cellpadding="0" style="background-color:white;" width="100%">
    <tbody>
      <tr>
      	<td>
      		<table cellspacing="0" cellpadding="0">
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
      		<table cellspacing="0" cellpadding="0" style="background-color:white; text-align:center;" width="100%">
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
								<a href="index?p=sondage" class="link">
									<li>
										Sondages
									</li>
								</a>
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
      			</tr>
      		</tbody>
      	</table>	
      	</td>
      </tr>
      <tr>
      	<td width="270">
      					Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />
      					Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />
      					Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />
      					Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />Beaucoup de noms<br />
      					
      				</td>
        <td>
          <div id="main" width="*">
          	<?php include('includes/home.php'); home();  ?>
          </div>
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
<?php 
}
?>
