<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCheckoutRequest;
use App\Http\Requests\StoreCheckoutRequest;
use App\Http\Requests\UpdateCheckoutRequest;
use App\Models\Checkout;
use App\Models\Contract;
use App\Models\ContractPeriod;
use App\Models\Currency;
use App\Models\HardwareItem;
use App\Models\User;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('checkout_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Checkout::with(['user', 'items'])->select(sprintf('%s.*', (new Checkout())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $editGate = '';
                $aproveGate = 'checkout_aprove';
                $viewGate = 'checkout_show';
                $editGate = 'checkout_edit';
                $deleteGate = 'checkout_delete';
                $crudRoutePart = 'checkouts';

                return view('partials.datatablesActions', compact(
                    'aproveGate',
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('user_email', function ($row) {
                return $row->user ? $row->user->email : '';
            });

            $table->editColumn('user.email', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->email) : '';
            });
            $table->editColumn('item', function ($row) {
                $labels = [];
                foreach ($row->items as $item) {
                    $labels[] = sprintf('<div class="d-flex justify-content-between font-xs">
                        <div class="mr-auto px-2">%s</div>

                        <div style="width: 55px;">%d days</div>
                        <div style="width: 48px;" class="px-2">%d%%</div>
                        <div style="width: 55px;" class="px-2">$%d</div>
                    </div>', $item->model, $item->period($item->pivot->period_id)->period, $item->pivot->percent, $item->pivot->price);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('status', function ($row) {
                return $row->status ?
                    '<small class="badge bg-success text-white">APROVED</small>' :
                    '<small class="badge bg-warning text-white">PENDING</small>';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'item', 'status']);

            return $table->make(true);
        }

        $users          = User::get();
        $hardware_items = HardwareItem::get();

        return view('admin.checkouts.index', compact('users', 'hardware_items'));
    }

    public function create()
    {
        abort_if(Gate::denies('checkout_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = HardwareItem::pluck('model', 'id');

        return view('admin.checkouts.create', compact('users', 'items'));
    }

    public function store(StoreCheckoutRequest $request)
    {
        $checkout = Checkout::create($request->all());
        $checkout->items()->sync($request->input('items', []));

        return redirect()->route('admin.checkouts.index');
    }

    public function edit(Checkout $checkout)
    {
        abort_if(Gate::denies('checkout_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = HardwareItem::pluck('model', 'id');

        $periods = ContractPeriod::all();

        $currencies = Currency::all();

        $checkout->load('user', 'items');

        return view('admin.checkouts.edit', compact('currencies', 'users', 'items', 'checkout', 'periods'));
    }

    public function update(UpdateCheckoutRequest $request, Checkout $checkout)
    {
        $checkout->update($request->all());
        $checkout->items()->sync($request->input('items', []));

        return redirect()->route('admin.checkouts.index');
    }

    public function aprove($id)
    {
        $total = 0;
        $currencies = Currency::whereActive(1)->get();
        $periods = ContractPeriod::get();
        $checkout = Checkout::findOrFail($id);
        $items = $checkout->items()->get();

        foreach($checkout->items as $item) {
            $total += $item->pivot->price;
        }

        $checkout->user->userTransactions()->create([
            'type' => 1,
            'amount' => $total / $currencies->find(1)->in_usd,
            'in_usd' => $total,
            'status' => 4,
            'currency_id' => 1,
        ]);

        foreach($items as $item) {
            Contract::create([
                'user_id' => $checkout->user->id,
                'hardware_id' => $item->id,
                'period_id' => $item->pivot->period_id,
                'currency_id' => $item->pivot->currency_id,
                'ended_at' => Carbon::now()->addDays( $periods->find( $item->pivot->period_id )->period ),
                'active' => 1,
                'percent' => $item->pivot->percent,
                'amount' => $item->pivot->price,
                'last_earn' => date('Y-m-d H:i:s'),
            ]);
        }

        $checkout->status = 1;
        $checkout->save();

        return redirect()->route('admin.checkouts.index');
    }

    public function show(Checkout $checkout)
    {
        abort_if(Gate::denies('checkout_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $checkout->load('user', 'items');

        return view('admin.checkouts.show', compact('checkout'));
    }

    public function destroy(Checkout $checkout)
    {
        abort_if(Gate::denies('checkout_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $checkout->delete();

        return back();
    }

    public function massDestroy(MassDestroyCheckoutRequest $request)
    {
        Checkout::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
