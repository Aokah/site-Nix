<?php function testpage_3 ()
{
?>
<style>
ul ul
	{
		display: none; 
		position: absolute; 
		left: 144px; top: -1px; 
		margin:0px;
		padding: 0px;
		border: 1px solid grey;
		
	}
  li 
  {
  	list-style-type: none; 
  	position: relative; 
  	width: 140px; 
  	background-color: #E0E0E0; 
  	padding: 2px; 
  	margin: 0px
  	
  }
  li:hover
  {
  	background-color: #FFFF70;
  	
  }
  li:hover ul.niveau2, li li:hover ul.niveau3 
  {
  	display: block
  	
  }
  li.plus
  {
  	background-position:right;
  	background-repeat: no-repeat; border-bottom: 1px solid grey;
  	
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
      	<table cellspacing="0" cellpadding="0" style="background-color:white;" width="100%">
      		<tbody>
      			<tr>
      				<td class="menud">
			        	<ul class="niveau1">
						<li>
							Menu
								<ul class="niveau2">
									<li>
										Extras
											<ul class="niveau3">
												<li>Demander la note</li>
												<li>Draguer la serveuse</li>
											</ul>
									</li>
									<li>Entrée</li>
									<li>Plat</li>
									<li>Dessert</li>
									<li>Café</li>
								</ul>
						</li>
					</ul>
			        </td>
			        <td>
			        	menu B
			        </td>
			        <td>
			        	menu C
			        </td>
			        <td>
			        	menu D
			        </td>
      			</tr>
      		</tbody>
      	</table>
      </tr>
      <tr>
        <td>
          Contenu
        </td>
      </tr>
      <tr>
        <td>
          Pied de page
        </td>
      </tr>
    </tbody>
  </table>
</div>
<?php 
}
?>
