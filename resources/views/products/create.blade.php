@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">New Product</div>
					</div>
					<div class="panel-body">
						{!! Form::open(['route' => 'products.store', 'files' => true, 'class' => 'form-horizontal']) !!}
							@include('products._form')
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection