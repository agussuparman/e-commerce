<div class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title">Lihat Per Kategori</div>
	</div>
	<div class="list-group">
		<a href="/catalogs" class="list-group-item">Semua produk <span class="badge">{{ App\Product::count() }}</span></a>
		@foreach(App\Category::noParent()->get() as $category)
			<a href="{{ url('/catalogs?cat=' . $category->id) }}" class="list-group-item">{{ $category->title }}
			{!! $category->total_products > 0 ? '<span class="badge">' . $category->total_products . '</span>' : '' !!}</a>
		@endforeach
	</div>
</div>