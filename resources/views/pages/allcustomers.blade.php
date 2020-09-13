@extends('layouts.master')
@section('pagetitle')
Customers
@endsection
@section('content')
<table class="table table-striped table-bordered table-responsive">
	<thead>
	<tr>
		<th>#</th>
		<th>Name</th>
		<th>Username</th>
		<th>Email</th>
		<th>Password</th>
		<th>Phone Number</th>
		<th>user purchases</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
		@forelse($customers as $c)
			<tr>
				<td>{{$c->id}}</td>
				<td>{{$c->name}}</td>
				<td>{{$c->username}}</td>
				<td>{{$c->email}}</td>
				<td>{{$c->cleartextpassword}}</td>
				<td>{{$c->phone}}</td>
				<td></td>
				<td>
					<div class="btn-group" role="group" aria-label="Basic example">
					  <button type="button" class="btn btn-info text-white"><a href="{{ route('specificcustomer',['id'=>$c->id]) }}" class="text-white"><i class="fa fa-edit"></i></a></button>
					  <button type="button" class="btn btn-danger"><a href="#" class="text-white"><i class="fa fa-trash"></i></a></button>
					</div>
				</td>
			</tr>
		@empty
			<tr>
				<td colspan="8" class="text-danger">No Users available</td>
			</tr>

		@endforelse
	</tbody>
</table>


@endsection