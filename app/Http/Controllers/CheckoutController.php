<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CheckoutLoginRequest;
use Illuminate\Support\MessageBag;
use App\User;
use App\Http\Requests\CheckoutAddressRequest;
use Auth;
use App\Address;
use App\Product;
use App\Support\CartService;
use App\Order;
use App\OrderDetail;

class CheckoutController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;

        $this->middleware('checkout.have-cart', [
            'only' => ['login', 'postLogin', 'address', 'postAddress', 'payment', 'postPayment']
        ]);

        $this->middleware('checkout.login-step-done', [
            'only' => ['address', 'postPayment', 'payment', 'postPayment']
        ]);

        $this->middleware('checkout.address-step-done', [
            'only' => ['payment', 'postPayment']
        ]);

        $this->middleware('checkout.payment-step-done', [
            'only' => ['success']
        ]);
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect('/checkout/address');
        } else {
            return view('checkout.login');
        }
    }

    public function postLogin(CheckoutLoginRequest $request)
    {
    	$email = $request->get('email');
    	$password = $request->get('checkout_password');
    	$is_guest = $request->get('is_guest') > 0;

    	if ($is_guest) {
    		return $this->guestCheckout($email);
    	}

    	return $this->authenticatedCheckout($email, $password);
    }

    protected function guestCheckout($email)
    {
        if ($user = User::where('email', $email)->first()) {
            if ($user->hasPassword()) {
                $errors = new MessageBag();
                $errors->add('checkout_password', 'Alamat email "' . $email . '" sudah terdaftar, silahkan masukan password.');
                return redirect('checkout/login')->withErrors($errors)
                    ->withInput(compact('email') + ['is_guest' => 0]);
            }

            session()->flash('email', $email);
            return view('checkout.reset-password');
        }

        session(['checkout.email' => $email]);
        return redirect('checkout/address');
    }

    protected function authenticatedCheckout($email, $password)
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            $errors = new MessageBag();
            $errors->add('email', 'Data user yang dimasukkan salah');
            return redirect('checkout/login')
                ->withInput(compact('email', 'password') + ['is_guest' => 0])
                ->withErrors($errors);
        }

        $deleteCartCookie = $this->cart->merge();
        return redirect('checkout/address')->withCookie($deleteCartCookie);
    }

    public function address()
    {
        return view('checkout.address');
    }

    public function postAddress(CheckoutAddressRequest $request)
    {
        if (Auth::check()) return $this->authenticatedAddress($request);
        return $this->guestAddress($request);
    }

    protected function authenticatedAddress(CheckoutAddressRequest $request)
    {
        $address_id = $request->get('address_id');
        session()->forget('checkout.address');
        if ($address_id == 'new-address') {
            $this->saveAddressSession($request);
        } else {
            session(['checkout.address.address_id' => $address_id]);
        }
        return redirect('checkout/payment');
    }

    protected function guestAddress(CheckoutAddressRequest $request)
    {
        $this->saveAddressSession($request);
        return redirect('checkout/payment');
    }

    protected function saveAddressSession(CheckoutAddressRequest $request)
    {
        session([
            'checkout.address.name' => $request->get('name'),
            'checkout.address.detail' => $request->get('detail'),
            'checkout.address.province_id' => $request->get('province_id'),
            'checkout.address.regency_id' => $request->get('regency_id'),
            'checkout.address.district_id' => $request->get('district_id'),
            'checkout.address.phone' => $request->get('phone')
        ]);
    }

    public function payment()
    {
        return view('checkout.payment');
    }

    public function postPayment(Request $request)
    {
        $this->validate($request, [
            'bank_name' => 'required|in:' . implode(',', array_keys(config('bank-accounts'))),
            'sender' => 'required'
        ]);

        session([
            'checkout.payment.bank' => $request->get('bank_name'),
            'checkout.payment.sender' => $request->get('sender')
        ]);

        if (Auth::check()) return $this->authenticatedPayment($request);
        return $this->guestPayment($request);
    }

    protected function authenticatedPayment(Request $request)
    {
        $user = Auth::user();
        $bank = session('checkout.payment.bank');
        $sender = session('checkout.payment.sender');
        $address = $this->setupAddress($user, session('checkout.address'));
        $order = $this->makeOrder($user->id, $bank, $sender, $address, $this->cart->details());
        session()->forget('checkout');
        $this->cart->clearCartRecord();
        return redirect('checkout/success')->with(compact('order'));
    }

    protected function guestPayment(Request $request)
    {
        $user = $this->setupCustomer(session('checkout.email'), session('checkout.address.name'));

        $bank = session('checkout.payment.bank');
        $sender = session('checkout.payment.sender');
        $address = $this->setupAddress($user, session('checkout.address'));

        $order = $this->makeOrder($user->id, $bank, $sender, $address, $this->cart->details());

        session()->forget('checkout');
        $deleteCartCookie = $this->cart->clearCartCookie();
        return redirect('checkout/success')->with(compact('order'))
            ->withCookie($deleteCartCookie);
    }

    protected function setupCustomer($email, $name)
    {
        $user = User::create(compact('email', 'name'));
        $user->role = 'customer';
        $user->save();
        return $user;
    }

    protected function setupAddress(User $customer, $addressSession)
    {
        if (Auth::check() && isset($addressSession['address_id'])) {
            return Address::find($addressSession['address_id']);
        }
        return Address::create([
            'user_id' => $customer->id,
            'name' => $addressSession['name'],
            'detail' => $addressSession['detail'],
            'regency_id' => $addressSession['regency_id'],
            'phone' => $addressSession['phone']
        ]);
    }

    protected function makeOrder($user_id, $bank, $sender, Address $address, $cart)
    {
        $status = 'waiting-payment';
        $address_id = $address->id;
        $order = Order::create(compact('user_id', 'address_id', 'bank', 'sender', 'status'));
        foreach ($cart as $product) {
            OrderDetail::create([
                'order_id' => $order->id,
                'address_id' => $address->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['detail']['price'],
                'fee' => Product::find($product['id'])->getCostTo($address->regency_id)
            ]);
        }
        return Order::find($order->id);
    }

    public function success()
    {
        return view('checkout.success');
    }
}
