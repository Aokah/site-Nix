<?php function aside()
{
	global $db, $_POST, $_GET, $_SESSION;
	if ($_SESSION["rank"] >= 3) { 
			
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
		&bull; Zelenan</p>
	<?php
	include ('includes/loggedIn.php');	loggedIn();
}
?>
