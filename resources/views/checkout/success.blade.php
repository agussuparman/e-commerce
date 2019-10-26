@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Berhasil</div>
					</div>
					<div class="panel-body">
						<p>Hai <strong>{{ session('order')->user->name }}</strong>,</p>
						<p></p>
						<p>Terima kasih telah belanja di Toko Online. <br>
							Untuk melakukan pembayaran dengan {{ config('bank-accounts')[session('order')->bank]['title'] }}:
						</p>
						<ol>
							<li>Silahkan transfer ke rekening <strong>{{ config('bank-accounts')[session('order')->bank]['bank'] }} {{ config('bank-accounts')[session('order')->bank]['number'] }} A/N. {{ config('bank-accounts')[session('order')->bank]['name'] }}</strong>.</li>
							<li>Ketika melakukan pembayaran sertakan nomor pesanan <strong>{{ session('order')->padded_id }}</strong>.</li>
							<li>Total Pembayaran <strong>Rp {{ number_format(session('order')->total_payment) }}</strong>.</li>
						</ol>
					</div>
					<div class="panel-footer">
						<a href="/">Lanjutkan Belanja</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection