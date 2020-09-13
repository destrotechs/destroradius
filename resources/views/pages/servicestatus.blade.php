@extends('layouts.master')
@section('content')
<h4>Services Status</h4><br>
<?php
function check_service($sname) {
	if ($sname != '') {
		system("pgrep ".escapeshellarg($sname)." >/dev/null 2>&1", $ret_service);
		if ($ret_service == 0) {
			return "Enabled";
		} else {
			return "Disabled";
		}
	} else {
		return "no service name";
	}
}

?>
<div class="card">
<div class="card-body">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Service</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Radius</td>
				<td><?php echo check_service('radius');?></td>
			</tr>
			<tr>
				<td>Mysql</td>
				<td><?php echo check_service('mysql');?></td>
			</tr>
		</tbody>
	</table>
</div>

</div>

@endsection