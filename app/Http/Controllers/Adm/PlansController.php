<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Laravel\Cashier\Cashier;

class PlansController extends Controller
{
    public function index()
    {
        return view('adm.plans.index');
    }

    public function store()
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
        Cashier::stripe()->plans->create([
            'amount' => 2000,
            'interval' => 'month',
            'product' => [
                'name' => 'Gold special',
            ],
            'currency' => 'usd',
            'id' => 'gold']
        );
        to_route('adm.plans.index');
    }
}
