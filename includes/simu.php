<?php function simu ()
{
	global $_GET, $_POST, $db, $_SESSION;
	
	$user = intval($_GET['for']);
				$sort = intval($_GET['launch']);
				
				$verif = $db->prepare('SELECT * FROM incan_get WHERE user_id = ? AND incan_id = ? AND valid = 1');
				$verif->execute(array($user, $sort));
				$verif2 = $db->prepare('SELECT * FROM incan_get WHERE user_id = ? AND incan_id = ?');
				$verif2->execute(array($user, $sort));
				if ($verif2->fetch())
				{
					if ($verif-> fetch())
					{
						$select = $db->prepare('SELECT * FROM members WHERE id = ?');
						$select->execute(array($user));
						$select = $select->fetch();
						$incan = $db->prepare('SELECT * FROM incan_list WHERE id = ?');
						$incan->execute(array($sort));
						$incan = $incan->fetch();
						
						$pm = $select['E_magique'];
						$pv = $select['E_vitale'];
						$cost = $incan['cost'];
						$points = $pm + $pv;
						
						
						
						if ($points > $cost)
						{
							$norma = $db->prepare('SELECT id, puis_norma,race, exp FROM members WHERE id = ?'); $norma->execute(array($user));
							$norma = $norma->fetch();
							$incan = $db->prepare('SELECT id, norma, cost FROM incan_list WHERE id = ?'); $incan->execute(array($sort));
							$incan = $incan->fetch();
							
							if ($norma['race'] == "Orque") { $coef = 0.5; } elseif ($norma['race'] == "Elfe" OR $norma['race'] == "Zaknafein") { $coef = 2; } 
							elseif ($norma['race'] == "Ernelien") { $coef = 3; } elseif ( $norma['race'] == "Dragon") { $coef = 4; }  else { $coef = 1; }
							$bonus = $incan['norma'] * $coef;
							$result = $norma['puis_norma'] + $bonus; 
							$pcs = $incan['cost'] / 3 ;
							$pcs = $pcs * $coef;
							$pcs = number_format($pcs, 0);
							$pcs = $norma['exp'] + $pcs; 
							
							$update = $db->prepare('UPDATE members SET puis_norma = ?, exp = ? WHERE id = ?'); $update->execute(array($result, $pcs, $user));
	
							if ($pm > $cost)
							{
								$result = $pm - $cost;
								$update = $db->prepare('UPDATE members SET E_magique = ? WHERE id = ?');
								$update->execute(array($result, $user));
								echo '<p>Le sort a bien été lancé pour un retrait de ', $cost, ' Points Magiques !';
							}
							else
							{
								$cost = $cost - $pm;
								$result = $pv - $cost;
								
								$update = $db->prepare('UPDATE members SET E_magique = 0, E_vitale = ? WHERE id = ?');
								$update->execute(array($result, $user));
								echo '<p>Le sort a bien été lancé pour un retrait de ', $pm, ' Points Magiques et de ', $cost, ' Points Vitaux !';
							}
						}
						else
						{
							echo 'Le personnage n\'a pas assez de points magique et / ou vitaux pour lancer ce sort !';
						}
					}
					else
					{
						echo 'Navré mais ce personnage n\'a pas encore validé ce sort !';
					}
				}
				else
				{
					echo 'Navré, mais ce personnage ne connait pas ce sort !';
				}
	
}
?>
