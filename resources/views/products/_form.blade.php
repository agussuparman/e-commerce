<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
	{!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
	<div class="col-md-6">
		{!! Form::text('name', null, ['class' => 'form-control']) !!}
		<strong>{!! $errors->first('name', '<p class="help-block">:message</p>') !!}</strong>
	</div>
</div>

<div class="form-group {{ $errors->has('model') ? 'has-error' : '' }}">
	{!! Form::label('model', 'Model', ['class' => 'col-md-2 control-label']) !!}
	<div class="col-md-6">
		{!! Form::text('model', null, ['class' => 'form-control']) !!}
		<strong>{!! $errors->first('model', '<p class="help-block">:message</p>') !!}</strong>
	</div>
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
	{!! Form::label('price', 'Harga', ['class' => 'col-md-2 control-label']) !!}
	<div class="col-md-6">
		{!! Form::number('price', null, ['class' => 'form-control']) !!}
		<strong>{!! $errors->first('price', '<p class="help-block">:message</p>') !!}</strong>
	</div>
</div>

<div class="form-group {{ $errors->has('weight') ? 'has-error' : '' }}">
	{!! Form::label('weight', 'Berat (gram)', ['class' => 'col-md-2 control-label']) !!}
	<div class="col-md-6">
		{!! Form::number('weight', null, ['class' => 'form-control']) !!}
		<strong>{!! $errors->first('weight', '<p class="help-block">:message</p>') !!}</strong>
	</div>
</div>

<div class="form-group {{ $errors->has('category_lists') ? 'has-error' : '' }}">
	{!! Form::label('category_lists', 'Catagories', ['class' => 'col-md-2 control-label']) !!}
	<div class="col-md-6">
		{!! Form::select('category_lists[]', [''=>'']+App\Category::lists('title', 'id')->all(), null, ['class' => 'form-control js-selectize', 'multiple']) !!}
		<strong>{!! $errors->first('category_lists', '<p class="help-block">:message</p>') !!}</strong>
	</div>
</div>

<div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
	{!! Form::label('photo', 'Product Photo (jpeg, jpg, png)', ['class' => 'col-md-2 control-label']) !!}
	<div class="col-md-6">
		{!! Form::file('photo', ['class' => 'filestyle']) !!}
	</div>
	<strong>{{ $errors->first('photo', '<p class="help-block">:message</p>') }}</strong>
	@if(isset($model) && $model->photo !== '')
	<div class="row">
		<div class="col-md-6">
			<p>Current Photo:</p>
			<div class="thumbnail">
				<img src="{{ url('/img/' . $model->photo) }}" class="img-rounded">
			</div>
		</div>
	</div>
	@endif
</div>

<div class="form-group">
	<div class="col-md-4 col-md-offset-2">		
		{!! Form::submit(isset($model) ? 'Update' : 'Save', ['class' => 'btn btn-primary']) !!}
	</div>
</div>