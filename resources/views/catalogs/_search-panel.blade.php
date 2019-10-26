<div class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title">Cari Produk</div>
	</div>
	<div class="panel-body">
		{!! Form::open(['url' => 'catalogs', 'method' => 'get']) !!}
			<div class="form-group {{ $errors->has('q') ? 'has-error' : '' }}">
				{!! Form::label('q', 'Apa yang kamu cari?', ['class' => 'control-label']) !!}
				{!! Form::text('q', $q, ['class' => 'form-control']) !!}
				<strong>{{ $errors->first('q', '<p class="help-block">:message</p>') }}</strong>
			</div>
			{!! Form::hidden('cat', $cat) !!}
			{!! Form::submit('Cari', ['class' => 'btn btn-primary']) !!}
		{!! Form::close() !!}
	</div>
</div>