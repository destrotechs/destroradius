@extends('layouts.master')

@section('content')
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>username</th>
			<th>plan bought</th>
			<th>amount</th>
			<th>transaction id</th>
			<th>phone</th>
			<th>payment date</th>
		</tr>
	</thead>
	<tbody>
		@forelse($payments as $n)
		<tr>
			<td>{{ $n->id }}</td>
			<td>{{ $n->username }}</td>
			<td>{{ $n->plan }}</td>
			<td>{{ $n->amount }}</td>
			<td>{{ $n->transaction_id }}</td>
			<td>{{ $n->phone_number }}</td>
			<td>{{ date('Y/m/d', strtotime(substr($n->transaction_date,0,8)))}}</td>
		</tr>
		@empty
		<tr>
			<td class="text-danger" colspan="8">No nas added yet</td>
		</tr>
		@endforelse
	</tbody>
</table>
@endsection