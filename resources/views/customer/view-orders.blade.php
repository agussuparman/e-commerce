@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div style="margin-bottom: 10px;">
					{!! Form::open(['url' => 'home/orders', 'method' => 'get', 'class' => 'form-inline']) !!}
						<div class="form-group {!! $errors->has('q') ? 'has-error' : '' !!}">
							{!! Form::text('q', isset($q) ? $q : null, ['class' => 'form-control', 'placeholder' => 'Order ID']) !!}
							<strong>{!! $errors->first('q', '<p class="help-block">:message</p>') !!}</strong>
						</div>

						<div class="form-group {!! $errors->has('status') ? 'has-error' : '' !!}">
							{!! Form::select('status', ['' => 'Semua Status']+App\Order::statusList(), isset($status) ? $status : null, ['class' => 'form-control']) !!}
							<strong>{!! $errors->first('status', '<p class="help-block">:message</p>') !!}</strong>
						</div>
						{!! Form::submit('Cari', ['class' => 'btn btn-primary']) !!}
					{!! Form::close() !!}
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Daftar Order</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed table-striped">
								<thead>
									<tr>
										<th>Order #</th>
										<th>Tanggal Order</th>
										<th>Status</th>
										<th>Pembayaran</th>
										<th>Detail</th>
									</tr>
								</thead>
								<tbody>
									@forelse($orders as $order)
										<tr>
											<td>{{ $order->padded_id }}</td>
											<td>{{ $order->created_at }}</td>
											<td>{{ $order->human_status }}</td>
											<td>
												Total: <strong>Rp {{ number_format($order->total_payment) }}</strong> <br>
												Transfer ke: {{ config('bank-accounts')[$order->bank]['bank'] }} A/N {{ config('bank-accounts')[$order->bank]['name'] }} {{ config('bank-accounts')[$order->bank]['number'] }} <br>
												Dari: {{ $order->sender }}
											</td>
											<td>
												@include('orders._details', compact('order'))
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="4">Tidak ada order yang ditemukan</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>	
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="pull-left">
								{!! $orders->appends(compact('q', 'status'))->links() !!}		
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection