<div class="row">
	<div class="col-xs-12">
		<ul class="nav nav-pills nav-justified thumbnail setup-panel">
			<li class="{{ Request::is('checkout/login') ? 'active' : 'disabled' }}"><a href="">
				<div class="list-group-item-heading">Login</div>
			</a></li>
			<li class="{{ Request::is('checkout/address') ? 'active' : 'disabled' }}"><a href="">
				<div class="list-group-item-heading">Alamat</div>
			</a></li>
			<li class="{{ Request::is('checkout/payment') ? 'active' : 'disabled' }}"><a href="">
				<div class="list-group-item-heading">Pembayaran</div>
			</a></li>
		</ul>
	</div>
</div>