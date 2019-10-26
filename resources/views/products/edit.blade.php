@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Edit {{ $product->name }}</div>
					</div>
					<div class="panel-body">
						{!! Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'patch', 'files' => true, 'class' => 'form-horizontal']) !!}
							@include('products._form', ['model' => $product])
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection