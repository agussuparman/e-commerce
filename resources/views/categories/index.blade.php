@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div style="margin-bottom: 10px;">
					{!! Form::open(['url' => 'categories', 'method' => 'get', 'class' => 'form-inline']) !!}
						<div class="form-group {{ $errors->has('q') ? 'has-error' : '' }}">
							{!! Form::text('q', isset($q) ? $q : null, ['class' => 'form-control', 'placeholder' => 'Type Category']) !!}
							{!! $errors->first('q', '<p class="help-block">:message</p>') !!}
						</div>
						{!! Form::submit('search', ['class' => 'btn btn-primary']) !!}
					{!! Form::close() !!}
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Cartegories</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed table-striped">
								<thead>
									<tr>
										<th>Title</th>
										<th>Parent</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach($categories as $category)
									<tr>
										<td>{{ $category->title }}</td>
										<td>{{ $category->parent ? $category->parent->title : '' }}</td>
										<td>
											{!! Form::model($category, ['route' => ['categories.destroy', $category], 'method' => 'delete', 'class' => 'form-inline']) !!}
												<a href="{{ route('categories.edit', $category->id) }}" class="btn btn-xs btn-warning">Edit</a>
												{!! Form::submit('Delete', ['class' => 'btn btn-xs btn-danger js-submit-confirm']) !!}
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
				  				<a href="{{ route('categories.create') }}" class="btn btn-primary">New Category</a>
				  			</div>
				  			<div class="pull-right">
				  				{{ $categories->appends(compact('q'))->links() }}
				  			</div>
				  		</div>
				  	</div>
				</div>
			</div>
		</div>
	</div>
@endsection