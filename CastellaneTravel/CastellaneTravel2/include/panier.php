<?php
	if (isset($_POST['nameobject'])){
		$object= $_POST['nameobject'] ;
		$price= $_POST['priceobject'] ;
	}
	else{
		$object= "" ;
		$price=	"" ;
	};
?>
<div class="panel panel-success">
	<div class="panel-heading">Panel with panel-primary class</div>
	<div class="panel-body">
		<div class="table-responsive">          
			<table class="table">
				<thead>
					<tr>
						<th>Object</th>
						<th>Quantité</th>
						<th>prix</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td id="object"></td>
						<td>0</td>
						<td id="price"></td>
					</tr>
				</tbody>
			</table>
			<button type="button" class="btn btn-primary btn-sm">Finish</button>
		</div>
	</div>
</div>