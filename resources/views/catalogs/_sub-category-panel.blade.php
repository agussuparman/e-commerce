<div class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title">Sub Kategori Untuk {{ $current_category->title }}</div>
	</div>
	<div class="list-group">
		@foreach($current_category->childs as $category)
			<a href="{{ url('/catalogs?cat=' . $category->id) }}" class="list-group-item">{{ $category->title }}
			{!! $category->total_products > 0 ? '<span class="badge">' . $category->total_products . '</span>' : '' !!}</a>
		@endforeach
	</div>
</div>