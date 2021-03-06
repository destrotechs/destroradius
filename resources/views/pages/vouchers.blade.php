@extends('layouts.master')
@section('content')
<div class="card">
	<div class="card-header"><h5>Vouchers</h5></div>
	<div class="card-body">
		<div class="err"></div>
		@if (session('success'))
			    <div class="alert alert-success">
			        {{ session('success') }}
			    </div>
			@endif
			@if (session('error'))
			    <div class="alert alert-danger">
			        {{ session('error') }}
			    </div>
			@endif
			@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
		<div class="row">
			<div class="col-md-4">
				<form class="mt-5">
					<div class="form-group">
					    <label for="exampleInputEmail1">Number of Vouchers</label>
					    <input type="digit" class="form-control" id="novouchers" value="1">
					</div>
					<div class="form-group">
					    <label for="exampleFormControlSelect1">Choose Plan</label>
					    <select class="form-control" id="plan">
					      <option value="">Select plan ...</option>
					      @foreach($plans as $p)
					      	<option value="{{ $p->planname }}">{{ $p->plantitle }}</option>
					      @endforeach
					    </select>
					  </div>
					<hr>
					<input type="button" name="generatevoucher" class="btn btn-outline-primary btn-md" value="Generate Vouchers" id="generate">
					<input type="button" name="clearvouchers" class="btn btn-outline-danger btn-md" value="Clear Vouchers" id="clear">
				</form>
			</div>
			<div class="col-md-8">
				<form method="post" action="{{ route('postvouchers') }}">
					<input type="hidden" name="cost" id="amount">
					<button class="btn btn-info d-none btn-md float-right print" type="submit">Print Vouchers&nbsp;<i class="fas fa-print"></i></button><button class="btn btn-success d-none btn-md float-right save" type="submit">Save Vouchers</button><br>
				<div class="row mt-5" id="voucherdiv">
					
				</div>
				{{ csrf_field() }}
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		var amount=0;
		$("#generate").click(function(){
			var vouchernum=parseInt($("#novouchers").val());
			var plan=$("#plan").val();
			if(plan!=""){
				$(".err").empty().removeClass("alert alert-danger");
				for(var i=0;i<vouchernum;i++){
					var username=generateUsername();
					var password=generatePassword();
					var serialnumber=generateSerialNum();

					var voucher='<div class="col-md-5"><div class="card"><div class="card-body"><div class="card-title"><h3>KES.'+amount+'<span class="badge badge-info float-right">'+plan+'</span></h3></div><p class="card-text"><b>Username </b>'+username+'</p><br><p><b>Password </b>'+password+'</p></div><input name="username[]" type="hidden" value="'+username+'"><input name="password[]" type="hidden" value="'+password+'"><input name="serialnumber[]" type="hidden" value="'+serialnumber+'"><input name="plan[]" type="hidden" value="'+plan+'"><i><small class="p-3">#'+serialnumber+'</small></i></div></div>';
					$("#voucherdiv").append(voucher);
				}
			$(".save").removeClass("d-none");
			$(".print").removeClass("d-none");
			}else{
				$("#voucherdiv").empty();
				$(".save").addClass("d-none");
				$(".err").html("Choose a plan to generate vouchers").addClass("alert alert-danger");
			}
			

		})

		$("#clear").click(function(){
			$("#voucherdiv").empty();
			$(".save").addClass("d-none");
			$(".print").addClass("d-none");
		})
		$(".print").click(function(){
			printVouchers();
		})
		$("#plan").change(function(){
			var plan = $(this).val();
			if(plan=='50mbs'){
				$("#amount").val(10);
				amount=10;
			}else if(plan=='100mbs'){
				$("#amount").val(20);
				amount=20;
			}else if(plan=='250mbs'){
				$("#amount").val(30);
				amount=30;
			}else if(plan=='500mbs'){
				$("#amount").val(50);
				amount=50;
			}else if(plan=='1gb'){
				$("#amount").val(100);
				amount=100;
			}else if(plan=='2gb'){
				$("#amount").val(200);
				amount=200;
			}
		})
		function generateUsername(){
			var text = "";
			var possible = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjklmnpqrstuvwxyz23456789";

		  	for (var i = 0; i < 6; i++)
		    text += possible.charAt(Math.floor(Math.random() * possible.length));

		  	return text;
		}
		function generatePassword(){
			var text = "";
			var possible = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";

		  	for (var i = 0; i < 5; i++)
		    text += possible.charAt(Math.floor(Math.random() * possible.length));

		  	return text;
		}
		function generateSerialNum(){
			var text = "";
			var possible = "0123456789";

		  	for (var i = 0; i < 12; i++)
		    text += possible.charAt(Math.floor(Math.random() * possible.length));

		  	return text;
		}
		function printVouchers(){
			var origPage=document.body.innerHTML;
			var printcont=document.getElementById('voucherdiv').innerHTML;
			document.body.innerHTML=printcont;
			window.print();
			document.body.innerHTML=origPage;
		}
	})
</script>
@endsection