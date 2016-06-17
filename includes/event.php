<?php function event ()
{
global $db, $_SESSION, $_POST, $_GET;
   if ($_SESSION['connected'])
   {
     if ($_SESSION['rank'] > 4)
     {
      ?>
      <h2>Evènements Nix</h2>
      <p>Ici sont écrits en plus amples détails tout ce qui a à savoir sur tel ou tel évènement lié au serveur !</p>
      <?php
        $select = $db->query('SELECT * FROM events ORDER BY name ASC');
        ?>
        <table cellspacing="0">
        	<tbody>
        		<tr>
        			<th>Intitulé</th>
        			<th>Nature</th>
        			<th>Lancement</th>
        		</tr>
        		<?php
        		while ($line = $select->fetch())
		        {
		        ?>
		        <tr>
		        	<td><a href="index?p=event&e=<?=$line['id']?>"><?=$line['name']?></a></td>
		        	<td><?=$type?></td>
		        	<td><?=$begin?></td>
		        </tr>
		        <?php
    			 }
    			 ?>
        	</tbody>
        </table>
        <?php
        
     }
     else
     {
       echo '<p<Navré, mais vous n\'avez pas le niveau suffisant pour visionner cette page.</p>';
     }
   }
   else
   {
     echo '<p>Veuillez vous connecter pour accéder à cette page.</p>';
   }
}
?>
