<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWalletNetworkRequest;
use App\Http\Requests\StoreWalletNetworkRequest;
use App\Http\Requests\UpdateWalletNetworkRequest;
use App\Models\WalletNetwork;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WalletNetworkController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('wallet_network_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walletNetworks = WalletNetwork::all();

        return view('admin.walletNetworks.index', compact('walletNetworks'));
    }

    public function create()
    {
        abort_if(Gate::denies('wallet_network_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletNetworks.create');
    }

    public function store(StoreWalletNetworkRequest $request)
    {
        $walletNetwork = WalletNetwork::create($request->all());

        return redirect()->route('admin.wallet-networks.index');
    }

    public function edit(WalletNetwork $walletNetwork)
    {
        abort_if(Gate::denies('wallet_network_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletNetworks.edit', compact('walletNetwork'));
    }

    public function update(UpdateWalletNetworkRequest $request, WalletNetwork $walletNetwork)
    {
        $walletNetwork->update($request->all());

        return redirect()->route('admin.wallet-networks.index');
    }

    public function show(WalletNetwork $walletNetwork)
    {
        abort_if(Gate::denies('wallet_network_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletNetworks.show', compact('walletNetwork'));
    }

    public function destroy(WalletNetwork $walletNetwork)
    {
        abort_if(Gate::denies('wallet_network_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walletNetwork->delete();

        return back();
    }

    public function massDestroy(MassDestroyWalletNetworkRequest $request)
    {
        WalletNetwork::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
