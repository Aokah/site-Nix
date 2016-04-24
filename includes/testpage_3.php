<?php function testpage_3 ()
{
?>
<style>
	.menud 
	{
		background-color: blue;
	}
	.menud:hover
	{
		background-color: aqua;
	}
	.menudd
	{
		display: none;
	}
	.menudd:hover
	{
		display: block;
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
			        	<ul>
			        		<li>Menu A1</li>
			        		<li class="menudd">Menu A2</li>
			        		<li class="menudd">Menu A3</li>
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
