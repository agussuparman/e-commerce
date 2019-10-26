{!! Form::open(['url' => '/password/email', 'method' => 'post', 'class' => 'form-horizontal']) !!}
	<div class="form-group {{ $errors->has('email' ? 'has-error' : '') }}">
		{!! Form::label('email', 'Alamat Email', ['class' => 'col-md-4 control-label']) !!}
		<div class="col-md-6">
			{!! Form::email('email', session()->has('email') ? session('email') : null, ['class' => 'form-control']) !!}
			<p class="help-block">Sepertinya Anda pernah berbelanja di Toko. Klik "Kirim Link Reset Password" untuk meminta password baru.</p>
			<strong>{!! $errors->first('email', '<p class="help-block">:message</p>') !!}</strong>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			{!! Form::button('<i class="fa fa-btn fa-envelope"></i> Kirim Link Reset Password', array('type' => 'Submit', 'class' => 'btn btn-primary')) !!}
		</div>
	</div>
{!! Form::close() !!}