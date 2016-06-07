<?php function account ()
{
	global $db, $_SESSION, $_GET, $_POST;

	if ($_SESSION['connected'])
	{
		$action = (isset($_GET['action'])) ? $_GET['action'] : false;
		
		switch($action)
		{
			case 'chagepsw':
			{
				include('includes/account/chgPwd.php');
				chgPwd();
				break;
			}
			
			case 'chagemc':
			{
				include('includes/account/changemc.php');
				changemc();
				break;
			}

			case 'chageemail':
			{
				include('includes/account/chgEmail.php');
				chgEmail();
				break;
			}	
		
			default :
			{
		
			?>
				<h2>Mon Compte</h2>
				  <p>Sur cette page vous trouverez toutes les informatiosn relatives à votre comtpe RPNix.com.</p>
				  
				<h3>Adresse Mail</h3>
				  <p>Vous souhaitez changer votre adresse mail ? <a href="index?p=account&action=changemail">C'est par ici</a> !</p>
				  
				<h3>Changer de mot de passe</h3>
				  <p>Besoin de sécurité ou simple doute ? <a href="index?p=account&action=changepsw">Changez votre mot de passe ici</a> !</p>
				  
				<h3>Compte Minecraft</h3>
				  <p>Le nom du compte Minecraft que vous utilisez est nécessaire pour profiter d'un maximum de chose en jeu, si vous souhaitez lier un novueau compte, <a href="index?p=account&action=changemc">c'est par ici</a> !</p>
			<?php
			}
		}
	}
}
?>
