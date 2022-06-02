<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQiwiApiRequest;
use App\Http\Requests\UpdateQiwiApiRequest;
use App\Models\QiwiLink;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;
use Gate;
class QiwiController extends Controller
{
    public function index(Request $request)
    {
        $qiwiLinks = QiwiLink::all();

        return view('admin.qiwi.index', compact('qiwiLinks'));
    }

    public function create()
    {
        return view('admin.qiwi.create');
    }

    public function store(StoreQiwiApiRequest $request)
    {
        QiwiLink::create($request->all());

        return redirect()->route('admin.qiwi.index');
    }

    public function edit(QiwiLink $qiwi)
    {
        return view('admin.qiwi.edit', compact('qiwi'));
    }

    public function update(UpdateQiwiApiRequest $request, QiwiLink $qiwi)
    {
        $qiwi->update($request->all());

        return redirect()->route('admin.qiwi.index');
    }

    public function destroy(QiwiLink $qiwi)
    {
        $qiwi->delete();

        return back();
    }
}
