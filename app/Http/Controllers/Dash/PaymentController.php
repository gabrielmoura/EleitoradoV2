<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;

class PaymentController extends Controller
{
    public function index()
    {
        // Listar os Planos
        $this->authorize('invoicing');
        $plans = Plan::all();

        return view('dash.payment.plans.index', compact('plans'));
    }

    public function show(Plan $plan, Request $request)
    {
        // Checkout, escolhido o plano ir para esta pagina
        $intent = auth()->user()->createSetupIntent();

        return view('dash.payment.plans.show', compact('plan', 'intent'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $user->createOrGetStripeCustomer();

        $paymentMethod = $request->payment_method ?? null;
        if ($paymentMethod != null) {
            $paymentMethod = $user->addPaymentMethod($paymentMethod);
        }
        $plan = $request->plan_id;

        try {
            $user->newSubscription(
                'default', $plan
            )->create($paymentMethod != null ? $paymentMethod->id : '');
        } catch (\Exception $ex) {
            return back()->withErrors([
                'error' => 'Unable to create subscription due to this issue '.$ex->getMessage(),
            ]);
        }

        $request->session()->flash('alert-success', 'You are subscribed to this plan');

        return to_route('payment.success');
    }

    public function subscriptionSuccess(Request $request)
    {

        return view('dash.payment.plans.success');
    }

    public function paymentMethod(): void
    {
        $this->authorize('invoicing');

        Cashier::stripe()->plans->create([
            'amount' => 2000,
            'interval' => 'month',
            'product' => [
                'name' => 'Gold special',
            ],
            'currency' => 'usd',
            'id' => 'gold']
        );
    }

    public function allSubscriptions()
    {
        if (auth()->user()->onTrial('default')) {
            dd('trial');
        }

        $subscriptions = Subscription::where('user_id', auth()->id())->get();

        return view('dash.payment.subscriptions.index', compact('subscriptions'));
    }

    public function cancelSubscriptions(Request $request)
    {
        $subscriptionName = $request->subscriptionName;
        if ($subscriptionName) {
            $user = auth()->user();
            $user->subscription($subscriptionName)->cancel();

            return 'subsc is canceled';
        }

        return response()->json(['error' => 'Subscription not found'], 404);
    }

    public function resumeSubscriptions(Request $request)
    {
        $user = auth()->user();
        $subscriptionName = $request->subscriptionName;
        if ($subscriptionName) {
            $user->subscription($subscriptionName)->resume();

            return 'subsc is resumed';
        }

        return response()->json(['error' => 'Subscription not found'], 404);
    }
}
