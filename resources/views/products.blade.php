@extends('layout')

@section('content')
<div class="container">	
	<div id="product_form">
		<h2 id="form_label">Add product</h2>
		<form id="product_form" method="post" action="{{route('products.store')}}">
			@csrf()
			
			@if(session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
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
				<div class="col-md-5 form-group">
					<label for="name">Product name:</label>
					<input type="text" class="form-control" id="name"  placeholder="Enter product name" name="name">
				</div>
				<div class="col-md-3 form-group">
					<label for="quantity">Quantity in stock:</label>
					<input type="text" class="form-control" id="quantity" placeholder="Enter product quantity" name="quantity">
				</div>
				<div class="col-md-3 form-group">
					<label for="price">Price per item:</label>
					<input type="text" class="form-control" id="price" placeholder="Enter product price" name="price">
				</div>
				<div class="col-md-1 form-group txt-r">
					<label for="" style="visibility: hidden;">Hidden</label>
					<button id="form_save_button" type="submit" class="btn btn-success" style="display: block;">Submit</button>
				</div>
			</div>
		</form>
	</div>
	
	<hr>
	
	<div id="products_table_container">
		
	</div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
	get_table_data();	
});

function get_table_data() {
	$.ajax({
		url: "{{route('get-lsiting')}}",
		data: {},
		dataType: 'json',
		success: function(response) {
			console.log(response);
			
			$('#products_table_container').html(response.html);
		}
	});
}
</script>
@endsection