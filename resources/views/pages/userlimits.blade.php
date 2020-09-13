@extends('layouts.master')

@section('content')
<?php

$attributes = array(
	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),

	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),
	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),
	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),
	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),
	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),

	 );
?>
	<div class="card">
		<div class="card-header"><h4>Limit Attributes</h4></div>
		<div class="card-body">
			<table class="table table-striped table-bordered table-md">
				<thead>
					<tr>
						<th>Limit name</th>
						<th>Vendor</th>
						<th>Op</th>
						<th>Type</th>
						<th>Table</th>
					</tr>
				</thead>
				<tbody>
					<?php
					for ($i=0; $i <count($attributes) ; $i++) { 
							echo "<tr><td>".$attributes[$i]['limitname']."</td></tr>";
				
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection