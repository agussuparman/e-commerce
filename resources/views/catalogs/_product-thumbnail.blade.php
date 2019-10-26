<div class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title">{{ $product->name }}</div>
	</div>
	<div class="panel-body">
		<div class="thumbnail">
			<img src="{{ $product->photo_path }}" class="img-rounded">
		</div>
		<p>Model: {{ $product->model }}</p>
		<p>Harga: <strong>Rp{{ number_format($product->price, 2) }}</strong></p>
		<p>Category:
			@foreach($product->categories as $category)
				<span class="label label-primary">
					<i class="fa fa-btn fa-tags"></i>
					{{ $category->title }}</span>
			@endforeach
		</p>

		@include('layouts._customer-feature', ['partial_view' => 'catalogs._add-product-form', 'data' => compact('product')])
	</div>
</div>