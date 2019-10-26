@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">New Category</div>
					</div>
					<div class="panel-body">
						{!! Form::open(['route' => 'categories.store', 'class' => 'form-horizontal']) !!}
							@include('categories._form')
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection