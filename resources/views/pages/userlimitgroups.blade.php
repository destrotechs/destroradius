@extends('layouts.master')

@section('content')
<div class="card p-4">
	<div class="card-title"><h4>User Limit Groups</h4></div><hr>
	@if (session('success'))
		    <div class="alert alert-success">
		        {{ session('success') }}
		    </div>
		@endif
	<form method="post" action="{{ route('postnewgrouplimit') }}">
		{{ csrf_field() }}
		
		<div class="card-body">
			<div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Group Name</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" placeholder="input group name" autofocus="autofocus" name="groupname">
		    </div>
		  </div>
		</div>
		<hr>
		<div class="row">
	  			<div class="col-md-11">
	  				<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <label class="input-group-text" for="inputGroupSelect01">Limit Name</label>
					  </div>
					  <select class="custom-select" id="attrselect">
					    <option value="">Choose limit...</option>
					    @forelse($limitattributes as $l)
					    	<option value="{{ $l->limitname }}">{{ $l->limitname }}</option>
					    @empty
					    	<option value="">No Limits available</option>
					    @endforelse
					  </select>
					</div>
	  			</div>
	  			<div class="col-md-1">
	  				<a href="#" class="btn btn-success add"><i class="fa fa-plus"></i></a>
	  			</div>
	  			
				<hr>
				</div>
		<hr>
		<div class="attrs">
					
		</div>
		<hr>
		<button type="submit" class="btn btn-success">Save</button>
	</form>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".add").click(function(){
			var attributevalue=$("#attrselect").val();
			var attribute="<div class='row col-md-12 mb-3 p-3'><div class='col-md-4'><input name='attribute[]' class='form-control' type='text' value='"+attributevalue+"'></div><div class='col-md-4'><input type='text' name='value[]' class='form-control' placeholder='value'></div><div class='col-md-2'><select class='custom-select' name='op[]'><option value=':='>:=</option><option value='='>=</option></select></div><div class='col-md-2'><select class='custom-select' name='type[]'><option value='reply'>reply</option><option value='check'>check</option></select></div></div>";
			$(".attrs").append(attribute);
		})
	})
</script>
@endsection