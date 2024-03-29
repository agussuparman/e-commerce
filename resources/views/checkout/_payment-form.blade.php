{!! Form::open(['url' => '/checkout/payment', 'method' => 'post', 'class' => 'form-horizontal']) !!}
	<div class="form-group {{ $errors->has('bank_name') ? 'has-error' : '' }}">
		{!! Form::label('bank_name', 'Pilih Bank yang ingin Anda gunakan', ['class' => 'col-md-4 control-label']) !!}
		<div class="col-md-6">
			{!! Form::select('bank_name', bankList(), null, ['class' => 'form-control js-selectize']) !!}
			<strong>{!! $errors->first('bank_name', '<p class="help-block">:message</p>') !!}</strong>
		</div>
	</div>

	<div class="form-group {{ $errors->has('sender') ? 'has-error' : '' }}">
		{!! Form::label('sender', 'Nama Pengirim', ['class' => 'col-md-4 control-label']) !!}
		<div class="col-md-6">
			{!! Form::text('sender', null, ['class' => 'form-control']) !!}
			<strong>{!! $errors->first('sender', '<p class="help-block">:message</p>') !!}</strong>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			{!! Form::button('<i class="fa fa-handshake-o"></i> Konfirmasi Pesanan', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
		</div>
	</div>
{!! Form::close() !!}