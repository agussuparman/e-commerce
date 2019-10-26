<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
	{!! Form::label('title', 'Title', ['class' => 'col-md-2 control-label']) !!}
	<div class="col-md-6">
		{!! Form::text('title', null, ['class' => 'form-control']) !!}
		<strong>{!! $errors->first('title', '<p class="help-block">:message</p>') !!}</strong>
	</div>
</div>

<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
	{!! Form::label('parent_id', 'Parent', ['class' => 'col-md-2 control-label']) !!}
	<div class="col-md-6">
		{!! Form::select('parent_id', [''=>'']+App\Category::lists('title', 'id')->all(), null, ['class' => 'form-control js-selectize']) !!}
		<strong>{!! $errors->first('parent_id', '<p class="help-block">:message</p>') !!}</strong>
	</div>
</div>

<div class="form-group">
	<div class="col-md-4 col-md-offset-2">		
		{!! Form::submit(isset($model) ? 'Update' : 'Save', ['class' => 'btn btn-primary']) !!}
	</div>
</div>