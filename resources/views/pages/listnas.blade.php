@extends('layouts.master')

@section('content')
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Nas Ip</th>
			<th>Nas shortname</th>
			<th>Nas Type</th>
			<th>Nas Secret</th>
			<th>Nas Server</th>
			<th>Nas Community</th>
			<th>Nas Description</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@forelse($nas as $n)
		<tr>
			<td>{{ $n->id }}</td>
			<td>{{ $n->nasname }}</td>
			<td>{{ $n->shortname }}</td>
			<td>{{ $n->type }}</td>
			<td>{{ $n->secret }}</td>
			<td>{{ $n->server }}</td>
			<td>{{ $n->community }}</td>
			<td>{{ $n->description }}</td>
			<td>
				<div class="btn-group" role="group" aria-label="Basic example">
				  	<a href="{{ route('editnas',['id'=>$n->id]) }}" class="btn btn-info text-white"><i class="fas fa-edit"></i></a>
				  	<a href="#" class="btn btn-danger text-white"><i class="fas fa-trash"></i></a>
				 
				</div>
			</td>
		</tr>
		@empty
		<tr>
			<td class="text-danger" colspan="8">No nas added yet</td>
		</tr>
		@endforelse
	</tbody>
</table>
@endsection