<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Cashier\Cashier;

class PlansController extends Controller
{
    public function index()
    {
        //        $plans= Cashier::stripe()->plans->all();
        $plans = Plan::all();

        return view('admin.plans.index', compact('plans'));
    }

    public function show(string $slug): View
    {
        $plan = Cache::remember('plan:'.$slug, 60 * 60 * 24, function () use ($slug) {
            return collect()
                ->put('gw', Cashier::stripe()->plans->retrieve($slug))
                ->put('plan', Plan::where('slug', $slug)->first());
        });

        return view('admin.plans.show', compact('plan'));
    }

    // Create a new plan
    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        //        // id: "gold",
        //        //    object: "plan",
        //        //    active: true,
        //        //    aggregate_usage: null,
        //        //    amount: 2000,
        //        //    amount_decimal: "2000",
        //        //    billing_scheme: "per_unit",
        //        //    created: 1686705324,
        //        //    currency: "usd",
        //        //    interval: "month",
        //        //    interval_count: 1,
        //        //    livemode: false,
        //        //    metadata: Stripe\StripeObject {#7985},
        //        //    nickname: null,
        //        //    product: "prod_O4s3w3EUq9QczZ",
        //        //    tiers_mode: null,
        //        //    transform_usage: null,
        //        //    trial_period_days: null,
        //        //    usage_type: "licensed",
        //        Cashier::stripe()->plans->create([
        //                'amount' => 2000,
        //                'interval' => 'month',
        //                'product' => [
        //                    'name' => 'Gold special',
        //                ],
        //                'currency' => 'usd',
        //                'id' => 'gold']
        //        );
        //        to_route('admin.plan.index');
        //        $this->validate($request,[
        //
        //        ]);
        $data = $request->only([
            'name',
            'description',
            'price',
            'price_decimal',
            'interval_count',
            'billing_period',
            'features',
            'currency',
        ]);

        try {
            Plan::create($data);
            flash()->addSuccess('Plano salvo com sucesso');
        } catch (\Throwable $throwable) {
            report($throwable);
            flash()->addError('Erro ao salvar o plano');
        }

        return to_route('admin.plan.index');
    }
}
