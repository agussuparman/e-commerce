<table class="table table-hover table-condensed">
	<thead>
		<tr>
			<th style="width: 50%">Produk</th>
			<th style="width: 20%" class="text-center">Jumlah</th>
			<th style="width: 30%" class="text-right">Harga</th>
		</tr>
	</thead>
	<tbody>
		@foreach($order->details as $detail)
		<tr>
			<td data-th="Produk">{{ $detail->product->name }}</td>
			<td data-th="Jumlah" class="text-center">{{ $detail->quantity }}</td>
			<td data-th="Harga" class="text-right">Rp {{ number_format($detail->price) }}</td>
		</tr>
		<tr>
			<td data-th="Subtotal">Ongkos Kirim</td>
			<td data-th="Subtotal" class="text-right" colspan="2">Rp {{ number_format($detail->fee) }}</td>
		</tr>
		<tr>
			<td data-th="Subtotal">Subtotal</td>
			<td data-th="Subtotal" class="text-right" colspan="2">Rp {{ number_format($detail->total_price) }}</td>
		</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td><strong>Total</strong></td>
			<td class="text-right" colspan="2"><strong>Rp{{ number_format($order->total_payment) }}</strong></td>
		</tr>
	</tfoot>
</table>