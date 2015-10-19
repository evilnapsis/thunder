<div class="row">
	<div class="col-md-4">
	<?php 

	$u = UserData::getById(Session::getUID());

	echo "<h2>".$u->name." ".$u->lastname."</h2>"; ?>
	<br>
		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">&nbsp;</h3>
            </div>
        	<div class="list-group">
					<a href='index.php?view=security' class='list-group-item'><i class="glyphicon glyphicon-chevron-right"></i> Seguridad y privacidad</a>
			</div>
        </div>
	</div>
	<div class="col-md-8">


	</div>
</div>
<br><br><br><br><br><br><br><br><br>