<?php function sorts ()
{
  global $_POST, $_GET, $_SESSION, $db;
  
?>
  <h2>Page Test pour les Incantations</h2>
  
	<?php
	if (isset($_GET['i']))
	{
		if ($_GET['i'] == "valid")
		{
			if(isset($_GET['search']))
			{
				$perso = htmlspecialchars($_GET['search']);
        
					if ($_SESSION['rank'] > 4)
					{
					?>
						<h3>Liste des sorts Validés</h3>
						<?php if (!empty($_GET['search'])) { ?>
							Recherche des sorts validés de <?= $perso,'.'; } else { echo '<span style="color:red;">Tu es sûr que tu n\'as pas oublié de noter un nom quelque part ? Réessaie.</span>';} ?>
							<form action="index.php" method="GET">
								<p>
									Recherche par personnage :
									<input type="hidden" value="sorts" name="p" />
									<input type="hidden" value="valid" name="i" />
									<input name="search" />
									<input type="submit" value="Rechercher" />	
								</p>
							</form>
							<p>
								<a href="index?p=sorts&i=unvalid&search=<?= $perso?>">
									[Voir les sorts invalidés du personnage.]
								</a>
							</p>
						<?php 
						$name = $db->prepare('SELECT id, name FROM members WHERE name = ?');
						$name->execute(array($perso)); 
						if ($name = $name->fetch())
						{
							$id = $name['id'];
							$verif = $db->prepare('SELECT COUNT(*) AS count FROM incan_get WHERE user_id = ? AND valid = 1');
							$verif->execute(array($id)); $verif = $verif->fetch();
							if ($verif['count'] != 0)
							{
								$irank = 8;
								while ($irank > 0)
								{
      
									$select = $db->prepare('SELECT COUNT(*) AS verif FROM incan_get
									RIGHT JOIN incan_list ON incan_list.id = incan_get.incan_id
									WHERE incan_get.user_id = ? AND incan_list.level = ? AND incan_get.valid = 1');
									$select->execute(array($id, $irank)); $count = $select->fetch();
									if ($count['verif'] != 0)
									{
										$incan = $db->prepare('SELECT ig.id, ig.user_id, ig.incan_id, ig.valid,
										il.id AS il_id, il.name, il.desc, il.type, il.cost, il.command, il.level
										FROM incan_get ig
										RIGHT JOIN incan_list il ON il.id = ig.incan_id
										WHERE ig.user_id = ? AND il.level = ? AND ig.valid = 1
										ORDER BY level DESC, type ASC, name ASC');
										$incan->execute(array($id, $irank));
										?>
    
										<table cellspacing="0" cellpadding="0" align="center">
											<tbody>
												<tr>
													<td>
														<img src="pics/ico/magiepapertop.png" alt="" />
													</td>
												</tr>
													<tr>
														<td>
															<?php while ($line = $incan->fetch())
															{
																switch ($line['type'])
																{
																case 13: $type	= "Terre" ; break; case 12: $type = "Psy" ; break; case 11: $type = "Ombre" ; break; case 10:  $type = "Nature" ; break; case 9:  $type = "Métal" ; break;
																case 8: $type = "Lumière" ; break; case 7: $type = "Glace" ; break; case 6: $type = "Feu" ; break; case 5: $type = "Energie" ; break;
																case 4: $type = "Eau" ; break; case 3: $type = "Chaos" ; break; case 2: $type = "Arcane" ; break; case 1: $type = "Air" ; break; case 0: $type = "Inconnue" ; break; 
																}
																switch ($line['level'])
																{
																case 8: $level = "X"; break;	case 7:  $level = "S"; break; case 6:  $level = "A"; break; case 5:  $level = "B"; break; case 4:  $level = "C"; break; case 3:  $level = "D"; break; 
																case 2:  $level = "E"; break; case 1:  $level = "F"; break;
																}
																?>
																	<table width="640px" background="/pics/ico/magiepapercenter.png" align="center" style="padding-bottom:10%; padding-left:6%; padding-right:6%;">
																		<tbody>
																			<tr>
																				<td style="text-align:center;">
																					<p class="name1"><?= $line['name']?></p>
																				</td>
																			</tr>
																		<tr>
																			<td style="text-align:center;">
																				<img src="pics/magie/Magie_<?= $type?>.png" alt="" width="60" class="magie_type" /> <img src="pics/magie/Magie_<?= $level?>.png" alt="" width="60" class="magie" />
																			</td>
																		</tr>
																		<tr>
																			<td style="text-align:center;">
																				<?= $line['desc']?>
																			</td>
																		</tr>
																		<tr>
																			<td style="text-align:center;">
																				<?= $line['cost']?> Points.
																			</td>
																		</tr>
																		<tr>
																			<td style="text-align:center;">
																				<a href="index?p=sorts&launch=<?=$line['incan_id']?>&for=<?=$id?>" class="name5">[Lancer le sort !]</a>
																			</td>
																		</tr>
																		</tbody>
																	</table>
																<?php
															}
															?>
														</td>
													</tr>
												<tr>
													<td>
														<img src="/pics/ico/magiepapebottom.png" alt="">
													</td>
												</tr>
											</tbody>
										</table>
										<?php
									}
									$irank-- ;
								}
							}
							else
							{
							?>
								<table cellspacing="0" cellpadding="0" align="center">
									<tbody>
										<tr>
											<td>
												<img src="pics/ico/magiepapertop.png" alt="" />
											</td>
										</tr>
										<tr>
											<td background="pics/ico/magiepapercenter.png">
											<p	 style="text-align:center;">Ce personnage ne possède aucun sort validé !</p>
											</td>
										</tr>
										<tr>
											<td>
												<img src="/pics/ico/magiepapebottom.png" alt="">
											</td>
										</tr>
									</tbody>
								</table>
							<?php
							}
						}
						else
						{
							echo '<p style="text-align:center;">Désolé, mais ce personnage n\'existe pas !</p>';
						}
					}
					else
					{
						echo 'Vous n\'avez pas le niveau pour voir ette partie de la page (bien tenté !)';
					}
			}
		}
	}
	elseif ($_GET['i'] ==  "unvalid")
	{
		if(isset($_GET['search']))
		{
			$perso = htmlspecialchars($_GET['search']);
			if ($_SESSION['rank'] > 4)
			{
				?>
				<h3>Liste des sorts Invalidés</h3>
				<?php if (!empty($_GET['search']))
				{ ?>
					Recherche des sorts invalidés de <?= $perso,'.';
				}
				else
				{
					echo '<span style="color:red;">Tu es sûr que tu n\'as pas oublié de noter un nom quelque part ? Réessaie.</span>';
				} ?>
				<form action="index.php" method="GET">
					<p>
						Recherche par personnage :
						<input type="hidden" value="sorts" name="p" />
						<input type="hidden" value="unvalid" name="i" />
						<input name="search" />
						<input type="submit" value="Rechercher" />	
					</p>
				</form>
				<p>
					<a href="index?p=sorts&i=valid&search=<?= $perso?>">
						[Voir les sorts validés du personnage.]
					</a>
				</p>
				<?php 
				$name = $db->prepare('SELECT id, name FROM members WHERE name = ?');
				$name->execute(array($perso));
				if ($name = $name->fetch())
				{
					$id = $name['id'];
					$verif = $db->prepare('SELECT COUNT(*) AS count FROM incan_get WHERE user_id = ? AND valid = 0');
					$verif->execute(array($id)); $verif = $verif->fetch();
					if ($verif['count'] != 0)
					{
						$irank = 8;
						while ($irank > 0)
						{
							$name = $db->prepare('SELECT id, name FROM members WHERE name = ?');
							$name->execute(array($perso)); $name = $name->fetch();
							$id = $name['id'];
							$select = $db->prepare('SELECT COUNT(*) AS verif FROM incan_get
							RIGHT JOIN incan_list ON incan_list.id = incan_get.incan_id
							WHERE incan_get.user_id = ? AND incan_get.valid = 0  AND incan_list.level = ?');
							$select->execute(array($id, $irank)); $count = $select->fetch();
							if ($count['verif'] != 0)
							{
								$incan = $db->prepare('SELECT ig.id, ig.user_id, ig.incan_id, ig.valid,
								il.id AS il_id, il.name, il.desc, il.type, il.cost, il.command, il.level
								FROM incan_get ig
								RIGHT JOIN incan_list il ON il.id = ig.incan_id
								WHERE ig.user_id = ? AND il.level = ? AND ig.valid = 0
								ORDER BY level DESC, type ASC, name ASC');
								$incan->execute(array($id, $irank));
								?>
								<table cellspacing="0" cellpadding="0" align="center">
									<tbody>
										<tr>
											<td>
												<img src="pics/ico/magiepapertop.png" alt="" />
											</td>
										</tr>
										<tr>
											<td>
												<?php while ($line = $incan->fetch())
												{
													switch ($line['type'])
													{
													case 13: $type	= "Terre" ; break; case 12: $type = "Psy" ; break; case 11: $type = "Ombre" ; break; case 10:  $type = "Nature" ; break; case 9:  $type = "Métal" ; break;
													case 8: $type = "Lumière" ; break; case 7: $type = "Glace" ; break; case 6: $type = "Feu" ; break; case 5: $type = "Energie" ; break;
													case 4: $type = "Eau" ; break; case 3: $type = "Chaos" ; break; case 2: $type = "Arcane" ; break; case 1: $type = "Air" ; break; case 0: $type = "Inconnue" ; break; 
													}
													switch ($line['level'])
													{
													case 8: $level = "X"; break;	case 7:  $level = "S"; break; case 6:  $level = "A"; break; case 5:  $level = "B"; break; case 4:  $level = "C"; break; case 3:  $level = "D"; break; 
													case 2:  $level = "E"; break; case 1:  $level = "F"; break;
													}
													?>
													<table width="640px" background="/pics/ico/magiepapercenter.png" align="center" style="padding-bottom:10%; padding-left:6%; padding-right:6%;">
														<tbody>
															<tr>
																<td style="text-align:center;">
																	<p class="name1"><?= $line['name']?></p>
																</td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<img src="pics/magie/Magie_<?= $type?>.png" alt="" width="60" class="magie_type" /> <img src="pics/magie/Magie_<?= $level?>.png" alt="" width="60" class="magie" />
																</td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<?= $line['desc']?>
																</td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<?= $line['cost']?> Points.
																</td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<a href="index?p=sorts&valid=<?=$line['incan_id']?>&for=<?=$id?>" class="name5">[Valider le sort !]</a>
																</td>
															</tr>
														</tbody>
													</table>
												<?php
												}
												?>
											</td>
										</tr>
										<tr>
											<td>
												<img src="/pics/ico/magiepapebottom.png" alt="">
											</td>
										</tr>
									</tbody>
								</table>
							<?php
							}
						$irank-- ;
						}
					}
					else
					{
					?>
						<table cellspacing="0" cellpadding="0" align="center">
							<tbody>
								<tr>
									<td>
										<img src="pics/ico/magiepapertop.png" alt="" />
									</td>
								</tr>
								<tr>
									<td background="pics/ico/magiepapercenter.png">
										<p style="text-align:center;">Ce personnage ne possède aucun sort invalidé !</p>
									</td>
								</tr>
								<tr>
									<td>
										<img src="/pics/ico/magiepapebottom.png" alt="">
									</td>
								</tr>
							</tbody>
						</table>
					<?php
					}
				}
				else
				{
				echo '<p style="text-align:center;">Désolé, mais ce personnage n\'existe pas !</p>';
				}
			}
			else
			{
			echo 'Vous n\'avez pas le niveau pour voir ette partie de la page (bien tenté !)';
			}
		}
	}
	elseif (isset($_GET['launch']))
	{
		$sort = intval($_GET['launch']);
		if (isset($_GET['for']))
		{
			$to = intval($_GET['to']);
		}
		else
		{
			echo '<p>Uhm.... Tu es sûr que tu n\'as pas oublié de préciser qui lançait le sort ?</p>';
		}
	}
	else
	{
	?>
		<h3>Mes sorts</h3>
		<?php
		$verif = $db->prepare('SELECT COUNT(*) AS count FROM incan_get WHERE user_id = ?');
		$verif->execute(array($_SESSION['id'])); $verif = $verif->fetch();
		if ($verif['count'] != 0)
		{
			$irank = 8;
			while ($irank > 0)
			{
				$select = $db->prepare('SELECT COUNT(*) AS verif FROM incan_get
				RIGHT JOIN incan_list ON incan_list.id = incan_get.incan_id
				WHERE incan_get.user_id = ? AND incan_list.level = ?');
				$select->execute(array($id, $irank)); $count = $select->fetch();
				if ($count['verif'] != 0)
				{
					$incan = $db->prepare('SELECT ig.id, ig.user_id, ig.incan_id, ig.valid,
					il.id AS il_id, il.name, il.desc, il.type, il.cost, il.command, il.level
					FROM incan_get ig
					RIGHT JOIN incan_list il ON il.id = ig.incan_id
					WHERE ig.user_id = ? AND il.level = ?
					ORDER BY level DESC, type ASC, name ASC');
					$incan->execute(array($id, $irank));
					?>
					<table cellspacing="0" cellpadding="0" align="center">
						<tbody>
							<tr>
								<td>
									<img src="pics/ico/magiepapertop.png" alt="" />
								</td>
							</tr>
							<tr>
								<td>
								<?php while ($line = $incan->fetch())
								{
									switch ($line['type'])
									{
									case 13: $type = "Terre" ; break; case 12: $type = "Psy" ; break; case 11: $type = "Ombre" ; break; case 10:  $type = "Nature" ; break; case 9:  $type = "Métal" ; break;
									case 8: $type = "Lumière" ; break; case 7: $type = "Glace" ; break; case 6: $type = "Feu" ; break; case 5: $type = "Energie" ; break;
									case 4: $type = "Eau" ; break; case 3: $type = "Chaos" ; break; case 2: $type = "Arcane" ; break; case 1: $type = "Air" ; break; case 0: $type = "Inconnue" ; break; 
									}
									switch ($line['level'])
									{
									case 8: $level = "X"; break; case 7:  $level = "S"; break; case 6:  $level = "A"; break; case 5:  $level = "B"; break; case 4:  $level = "C"; break; case 3:  $level = "D"; break; 
									case 2:  $level = "E"; break; case 1:  $level = "F"; break;
									}
									?>
									<table width="640px" background="/pics/ico/magiepapercenter.png" align="center" style="padding-bottom:10%; padding-left:6%; padding-right:6%;">
										<tbody>
											<tr>
												<td style="text-align:center;">
													<p class="name1"><?= $line['name']?></p>
												</td>
											</tr>
											<tr>
												<td style="text-align:center;">
													<img src="pics/magie/Magie_<?= $type?>.png" alt="" width="60" class="magie_type" /> <img src="pics/magie/Magie_<?= $level?>.png" alt="" width="60" class="magie" />
												</td>
											</tr>
											<tr>
												<td style="text-align:center;">
													<?= $line['desc']?>
												</td>
											</tr>
											<tr>
												<td style="text-align:center;">
													<?= $line['cost']?> Points.
												</td>
											</tr>
											<tr>
												<td style="text-align:center;">
													<?php if ($line['valid'] == 1)
													{ ?>
														<p class="name5">Sort validé</p><?php
													}
													else
													{ ?>
														<p class="name7">Sort non validé</p>
													<?php 
													}
													?>
												</td>
											</tr>
										</tbody>
									</table>
								<?php
								}
								?>
								</td>
							<tr>
								<td>
									<img src="/pics/ico/magiepapebottom.png" alt="">
								</td>
							</tr>
						</tbody>
					</table>
				<?php
				}
			$irank-- ;
			}  
		}
		else
		{
			?>
			<table cellspacing="0" cellpadding="0" align="center">
				<tbody>
					<tr>
						<td>
							<img src="pics/ico/magiepapertop.png" alt="" />
						</td>
					</tr>
					<tr>
						<td background="pics/ico/magiepapercenter.png">
							<p style="text-align:center;">Vous ne possédez aucun sort ! TEST CHANGEMENT MOTHER FUCKER !
							</p>
						</td>
					</tr>
					<tr>
						<td>
						<	img src="/pics/ico/magiepapebottom.png" alt="">
						</td>
					</tr>
				</tbody>
			</table>
			<?php
		}
	}
}
?>
