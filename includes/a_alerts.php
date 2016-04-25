<?php function a_alerts()
{
	global $_SESSION, $db, $_GET;
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
		if ($sel4['E_magique'] <= 30 AND $sel4['E_magique'] > 0){ ?>
		<div class="alert">
			<h3>Fatigue grandissante du personnage</h3>
			<p>Du fait de la perte de presque la totalité de ses Points de Magie (PM), votrepersonnage souffre d'une fatigue assez prenoncée, il devient moins endurant, irritable, et il est compliqué pour lui de rester concentré sur des tâches complexes.</p>
			<p>La restauration des flux magique de votre personnage sera naturelle. Aussi bien faites attention la prochaine fois que vous abusez des sorts.</p>
		</div>
		<? }
		if ($sel4['E_magique'] == 0) 
		{
		?>
			<div class="alert">
				<h3>Perte des ressources magiques</h3>
				<p>Après la perte de la totalité de vos Points de Magie (PM) votre persnne se voit très régulièrement épuisé, si de nouveaux sorts sont tentés, le coût de ces derniers impactera
				les Points Vitaux (PV) de votre personnage.<br />
				Il n'est jamais bon de voir cette jauge atteindre zéro.</p>
				<p>La restauration des flux magique de votre personnage sera naturelle. Aussi bien faites attention la prochaine fois que vous abusez des sorts.</p>
			</div>
		<? }
		if ($sel4['E_vitale'] <= 50 AND $sel4['E_vitale'] > 0)
		{
		?>
			<div class="alert">
				<h3>Points Vitaux faibles</h3>
				<p>Après la perte de plus de 75% de ses Points Vitaux (PV), votre personnage perd peu à peu pied dans la réalité, il somnole de manière chronique, et est victime de troubles de
				la concentration aigües.</p>
				<p>La restauration des flux vitaux est relativement longue, la prudence sera de mise à l'avenir aux yeux du personnage.</p>
			</div>
		<? } 
		if ($sel4['E_vitale'] == 0)
		{ 
		?>
			<div class="alert">
				<h3>Perte total des repères</h3>
				<p>Suite à la perte totale des Points Magiques puis Vitaux (PM) (PV) votre personnage perd totalement la raison, il sera incapable d'aligner trois phrases cohérentes et impossible d'effectuer le moindre sort.<br />
				Il peut arriver que le récent perdu ne sache plus faire la différence entre allié et ennemi.</p>
				<p>La restauration des flux vitaux est relativement longue, la prudence sera de mise à l'avenir aux yeux du personnage.</p>
			</div>
		<?  }
		$sel4 = $db->prepare('SELECT * FROM members WHERE id = ?');
		$sel4->execute(array($id)); $sel4 = $sel4->fetch();
		if ($hrpavis >= 10 OR $sel4['rank'] > 2 ) 
		{
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
			<?php	
		} 	
		}
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
	}
}
?>
