<?php function magic_level ()
{
	global $db, $_GET, $_SESSION;
	if (isset($_GET['perso']))
	{
		$id = intval($_GET['perso']);
	}
	else
	{
		$id = $_SESSION['id'];
	}
	
	$presel = $db->prepare('SELECT * FROM members WHERE id = ?'); $presel->execute(array($id)); $presel = $presel->fetch();

		$select = $db->prepare('SELECT * FROM magic_level WHERE user_id = ? AND spe = 1'); $select->execute(array($id));
		while ($line = $select->fetch())
		{
			switch ($line['element'])
			{
				default : $ico = "Inconnue"; $lore = "Acune aura magique"; break; case 1: $ico = "Air"; $lore  =" en Aeormancien"; break;
				case 2: $ico = "Arcane"; $lore = "Temporel"; break; case 3: $ico = "Chaleur"; $lore = "en Termoancie"; break;
				case 4: $ico = "Chaos"; $lore = "Entropique"; break; case 5: $ico = "Eau"; $lore = "en Hydromancie"; break;
				case 6: $ico = "Espace"; $lore = "Spatial"; break; case 7: $ico = "Energie"; $lore = "en Electromancie"; break;
				case 8: $ico = "Feu"; $lore = "en Pyromancie"; break; case 9: $ico = "Glace"; $lore = "en Cryomancie"; break;
				case 10: $ico = "Lumière"; $lore = "en Luciomancie"; break; case 11: $ico = "Métal"; $lore = "en Ferromancie"; break;
				case 12: $ico = "Nature"; $lore = "en Phytomancie"; break; case 13: $ico = "Ombre"; $lore = "en Occultomancie"; break;
				case 14: $ico = "Ordre"; $lore = "Eurytmique"; break; case 15: $ico = "Psy"; $lore = " en Psychomancie"; break;
				case 16: $ico = "Terre"; $lore = "en Telluromancie"; break; case 17: $ico = "Void"; $lore = "Void"; break;
				case 18: $ico = "Spéciale"; $lore  ="en Magie Spéciale"; break;
			}
			switch ($line['rank'])
			{
				case 0: $magie = "Profane"; break;	case 1: $magie = "Adepte"; break;	case 2: $magie = "Apprenti"; break;
				case 3: $magie = "Magicien"; break;	case 4: $magie = "Mage"; break;		case 5: $magie = "Archimage"; break;
				case 6: $magie = "Sage"; break;		case 7: $magie = "Dieu"; break;		case 8: $magie = "Titan"; break;
				case 9: $magie = "Être Suprême"; break;	case 10: $magie = "Principe Universel"; break;
			}
		?>
		<p>
					<?php
					if ($presel['specialitation'] != "Inconnue")
					{
					?>
						<img src="ico/magie/magie_rank_<?= $line['rank']?>.gif" alt="" /> <img src="pics/magie/Magie_<?= $ico?>.png" alt="" class="magie_type" width="25px" /> <?= $magie; ?> <?= $lore; ?>
					<?php
					}
					else
					{
						echo "Aucune aura magique";
					}
					?>
		</p>
	<?php 
	}
	if ($presel['spe_2'] != "Inconnue")
	{
		$select = $db->prepare('SELECT * FROM magic_level WHERE user_id = ? AND spe = 2'); $select->execute(array($id));
		while ($line = $select->fetch())
		{
			switch ($line['element'])
			{
				default : $ico = "Inconnue"; $lore = "Acune aura magique"; break; case 1: $ico = "Air"; $lore  =" en Aeormancien"; break;
				case 2: $ico = "Arcane"; $lore = "Temporel"; break; case 3: $ico = "Chaleur"; $lore = "en Termoancie"; break;
				case 4: $ico = "Chaos"; $lore = "Entropique"; break; case 5: $ico = "Eau"; $lore = "en Hydromancie"; break;
				case 6: $ico = "Espace"; $lore = "Spatial"; break; case 7: $ico = "Energie"; $lore = "en Electromancie"; break;
				case 8: $ico = "Feu"; $lore = "en Pyromancie"; break; case 9: $ico = "Glace"; $lore = "en Cryomancie"; break;
				case 10: $ico = "Lumière"; $lore = "en Luciomancie"; break; case 11: $ico = "Métal"; $lore = "en Ferromancie"; break;
				case 12: $ico = "Nature"; $lore = "en Phytomancie"; break; case 13: $ico = "Ombre"; $lore = "en Occultomancie"; break;
				case 14: $ico = "Ordre"; $lore = "Eurytmique"; break; case 15: $ico = "Psy"; $lore = " en Psychomancie"; break;
				case 16: $ico = "Terre"; $lore = "en Telluromancie"; break; case 17: $ico = "Void"; $lore = "Void"; break;
				case 18: $ico = "Spéciale"; $lore  ="en Magie Spéciale"; break;
			}
			switch ($line['rank'])
			{
				case 0: $magie = "Profane"; break;	case 1: $magie = "Adepte"; break;	case 2: $magie = "Apprenti"; break;
				case 3: $magie = "Magicien"; break;	case 4: $magie = "Mage"; break;		case 5: $magie = "Archimage"; break;
				case 6: $magie = "Sage"; break;		case 7: $magie = "Dieu"; break;		case 8: $magie = "Titan"; break;
				case 9: $magie = "Être Suprême"; break;	case 10: $magie = "Principe Universel"; break;
			}
		?>
			<p>
						<?php
						if ($presel['specialitation'] != "Inconnue")
						{
						?>
							<img src="ico/magie/magie_rank_<?= $line['rank']?>.gif" alt="" /> <img src="pics/magie/Magie_<?= $ico?>.png" alt="" class="magie_type" width="25px" /> <?= $magie; ?> <?= $lore; ?>
						<?php
						}
						else
						{
							echo "Aucune aura magique";
						}
						?>
			</p>
	<?php	
		}
	} 
}
?>
