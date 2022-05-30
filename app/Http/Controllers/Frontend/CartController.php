<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCartRequest;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Models\HardwareItem;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cart_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carts = Cart::with(['user', 'items'])->get();

        return view('frontend.carts.index', compact('carts'));
    }

    public function create()
    {
        abort_if(Gate::denies('cart_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = HardwareItem::pluck('model', 'id');

        return view('frontend.carts.create', compact('users', 'items'));
    }

    public function store(StoreCartRequest $request)
    {
        $cart = Cart::create($request->all());
        $cart->items()->sync($request->input('items', []));

        return redirect()->route('frontend.carts.index');
    }

    public function edit(Cart $cart)
    {
        abort_if(Gate::denies('cart_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = HardwareItem::pluck('model', 'id');

        $cart->load('user', 'items');

        return view('frontend.carts.edit', compact('users', 'items', 'cart'));
    }

    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $cart->update($request->all());
        $cart->items()->sync($request->input('items', []));

        return redirect()->route('frontend.carts.index');
    }

    public function show(Cart $cart)
    {
        abort_if(Gate::denies('cart_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cart->load('user', 'items');

        return view('frontend.carts.show', compact('cart'));
    }

    public function destroy(Cart $cart)
    {
        abort_if(Gate::denies('cart_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cart->delete();

        return back();
    }

    public function massDestroy(MassDestroyCartRequest $request)
    {
        Cart::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
