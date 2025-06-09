<table class="table table-bordered" id="sortable">
	<thead>
		<tr>
			<th width="80px">#</th>
			<th>Product name</th>
			<th width="200px">Quantity in stock</th>
			<th width="200px">Price per item</th>
			<th width="100px">Date</th>
			<th width="100px">Total</th>
		</tr>
	</thead>
	<tbody>
		@php 
			$all_product_total_price = 0;
			$index = 1;
		@endphp
		
		@foreach($products as $key => $product)		
		
		@php
			$total_product_price = $product['quantity'] * $product['price'];
			$all_product_total_price += $total_product_price;
		@endphp
		
		<tr>
			<td><div id="priority_product_id_{{ $product['id'] }}">#{{ $index ++ }}</div></td>
			<td>{{ $product['name'] }}</td>
			<td>{{ $product['quantity'] }}</td>
			<td>{{ $product['price'] }}</td>
			<td>{{ date('Y-m-d', strtotime($product['created_at'])) }}</td>
			<td class="txt-r">{{ $total_product_price }}</td>
		</tr>
		@endforeach	
		
		@if(!empty($products))	
		<tr>
			<td colspan="5">Total</td>
			<td class="txt-r">{{ $all_product_total_price }}</td>
		</tr>
		@endif
	</tbody>
</table>