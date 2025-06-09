@extends('layout')

@section('content')
<div class="container">	
	<div id="product_form_container">
		<h2 id="form_label">Add product</h2>
		<form id="product_form" method="post" action="{{route('products.store')}}">
			<input type="hidden" id="product_id" name="product_id" value="">
			@csrf()
			
			<div id="message_div" class="alert alert-info d-none"></div>

			<div class="row">
				<div class="col-md-5 form-group">
					<label for="name">Product name:</label>
					<input type="text" class="form-control" id="name"  placeholder="Enter product name" name="name">
					<p class="errors" id="error_name"></p>
				</div>
				<div class="col-md-3 form-group">
					<label for="quantity">Quantity in stock:</label>
					<input type="text" class="form-control" id="quantity" placeholder="Enter product quantity" name="quantity">
					<p class="errors" id="error_quantity"></p>
				</div>
				<div class="col-md-2 form-group">
					<label for="price">Price per item:</label>
					<input type="text" class="form-control" id="price" placeholder="Enter product price" name="price">
					<p class="errors" id="error_price"></p>
				</div>
				<div class="col-md-2 form-group txt-r">
					<label for="" style="visibility: hidden;">Hidden</label>
					<div style="dispay:flex;">
						<button id="form_save_button" type="submit" class="btn btn-success" style="display: inline-block;">Submit</button>
						<a id="form_cancel_button" href="javascript:void(0)" class="btn btn-warning" style="display: none;">Cancel</a>
					</div>
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
var add_product_label = "Add product";
var update_product_label = "Update product";

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

$('#product_form').submit(function(e) {
	e.preventDefault();
	
	var form_data = new FormData($('#product_form')[0]);
	
	$.ajax({
		url: "{{route('products.store')}}",
		method: "post",
		data: form_data,
		processData: false, 
		contentType: false,
		dataType: 'json',
		success: function(response) {			
			if(response.status == 0) {					
				$.each(response.errors, function(key, value) {
					console.log(key, value);
					$.each(value, function(error_key, error_value) {
						$("#error_"+key).html("<span>"+error_value+"</span>");
					});
				});
			} else {
				show_success_message(response.message);	
				reset_form();			 
				get_table_data();
			}			
		},
	});	
});

$(document).on('click', '.edit-product', function() {	
	$('#form_label').html(update_product_label);
	$('#form_save_button').html('Update');
	$('#form_cancel_button').show();
	
	$('#product_id').val($(this).data('id'));
	$('#name').val($(this).data('name'));
	$('#quantity').val($(this).data('quantity'));
	$('#price').val($(this).data('price'));
});

$(document).on('click', '#form_cancel_button', function() {
	reset_form();
});

function show_success_message(msg) {
	$('#message_div').html(msg);
	$('#message_div').show();
	
	setTimeout(function() {
		$('#message_div').html('');
		$('#message_div').hide();
	}, 2000);
}

function reset_form() {
	$('#form_label').html(add_product_label);
	$('#form_save_button').html('Save');
	$('#form_cancel_button').hide();
	
	$('#product_id').val('');
	$('#product_form')[0].reset();
	
	clear_errors();
}

function clear_errors() {
	$("#error_name").html("");
	$("#error_quantity").html("");
	$("#error_price").html("");
}

</script>
@endsection