@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Edit {{ $category->title }}</div>
					</div>
					<div class="panel-body">
						{!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'patch', 'class' => 'form-horizontal']) !!}
							@include('categories._form', ['model' => $category])
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection