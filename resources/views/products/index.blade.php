@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div style="margin-bottom: 10px;">
					{!! Form::open(['url' => 'products', 'method' => 'get', 'class' => 'form-inline']) !!}
						<div class="form-group {{ $errors->has('q') ? 'has-error' : '' }}">
							{!! Form::text('q', isset($q) ? $q : null, ['class' => 'form-control', 'placeholder' => 'Type Category']) !!}
							{!! $errors->first('q', '<p class="help-block">:message</p>') !!}
						</div>
						{!! Form::submit('search', ['class' => 'btn btn-primary']) !!}
					{!! Form::close() !!}
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Products</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed table-striped">
								<thead>
									<tr>
										<th>Nama</th>
										<th>Model</th>
										<th>Category</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach($products as $product)
									<tr>
										<td>{{ $product->name }}</td>
										<td>{{ $product->model }}</td>
										<td>
											@foreach($product->categories as $category)
												<span class="label label-primary">
													<i class="fa fa-btn fa-tags"></i>
													{{ $category->title }}</span>
											
											@endforeach
										</td>
										<td>
											{!! Form::model($product, ['route' => ['products.destroy', $product], 'method' => 'delete', 'class' => 'form-inline']) !!}
												<a href="{{ route('products.edit', $product->id) }}" class="btn btn-xs btn-warning">Edit</a>
												{!! Form::submit('delete', ['class' => 'btn btn-xs btn-danger js-submit-confirm']) !!}
											{!! Form::close() !!}
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
				  	</div>
				  	<div class="panel-footer">
				  		<div class="row">
				  			<div class="pull-left">
				  				<a href="{{ route('products.create') }}" class="btn btn-primary">New Product</a>
				  			</div>
				  			<div class="pull-right">
				  				{{ $products->appends(compact('q'))->links() }}
				  			</div>
				  		</div>
				  	</div>
				</div>
			</div>
		</div>
	</div>
@endsection