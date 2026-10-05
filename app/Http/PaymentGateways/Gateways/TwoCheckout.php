<?php

namespace App\Http\PaymentGateways\Gateways;


use Exception;
use App\Enums\Activity;
use App\Models\Currency;
use App\Enums\GatewayMode;
use Tco\TwocheckoutFacade;
use App\Models\PaymentGateway;
use App\Services\PaymentService;
use App\Services\PaymentAbstract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Dipokhalder\Settings\Facades\Settings;

class TwoCheckout extends PaymentAbstract
{

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $paymentService = new PaymentService();
        parent::__construct($paymentService);
        $this->paymentGateway = PaymentGateway::with('gatewayOptions')->where(['slug' => 'twocheckout'])->first();
        if (!blank($this->paymentGateway)) {
            $this->paymentGatewayOption = $this->paymentGateway->gatewayOptions->pluck('value', 'option');
        }
    }

    public function payment($order, $request): \Illuminate\Http\RedirectResponse
    {
        try {

            $currencyCode = 'USD';
            $currencyId   = Settings::group('site')->get('site_default_currency');
            if (!blank($currencyId)) {
                $currency = Currency::find($currencyId);
                if ($currency) {
                    $currencyCode = $currency->code;
                }
            }

            if (env('DEMO')) {
                $currencyCode = 'USD';
            }
            $config = [
                'sellerId'          => $this->paymentGatewayOption['twocheckout_seller_id'],
                'secretKey'         => $this->paymentGatewayOption['twocheckout_secret_key'],
                'buyLinkSecretWord' => $this->paymentGatewayOption['twocheckout_buy_link_secret_word'],
                'jwtExpireTime'     => 30,
                'curlVerifySsl'     => 1
            ];
            $tco = new TwocheckoutFacade($config);
            $buyLinkParameters = [
                'name'             => $order->user?->name,
                'phone'            => $order->user->country_code . $order->user->phone,
                'email'            => $order->user?->email,
                'address'          => $order->address?->address,
                'prod'             => 'Food Items',
                'price'            => 2,
                'qty'              => 1,
                'type'             => 'PRODUCT',
                'tangible'         => 1,
                'currency'         => $currencyCode,
                'language'         => 'en',
                'return-url'       => route('payment.success', ['order' => $order, 'paymentGateway' => 'twocheckout']),
                'return-type'      => 'redirect',
                'order-ext-ref'    => $order->order_serial_no,
                'customer-ext-ref' => $order->user?->email,
                'merchant'         => $this->paymentGatewayOption['twocheckout_seller_id'],
                'expiration'       => time() + 3600,
                'test'             => $this->paymentGatewayOption['twocheckout_mode'] == GatewayMode::SANDBOX ? 1 : 0,
                'dynamic'          => 1,
                'src'              => 'phpLibrary',
            ];

            $buyLinkSignature = $tco->getBuyLinkSignature($buyLinkParameters);
            $buyLinkParameters['signature'] = $buyLinkSignature;
            $redirectTo = 'https://secure.2checkout.com/checkout/buy/?' . (http_build_query($buyLinkParameters));
            if ($redirectTo) {
                return redirect()->away($redirectTo);
            } else {
                return redirect()->route('payment.fail', ['order' => $order, 'paymentGateway' => 'twocheckout'])->with(
                    'error',
                    trans('all.message.something_wrong')
                );
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return redirect()->route('payment.index', ['order' => $order, 'paymentGateway' => 'twocheckout'])->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function status(): bool
    {
        $paymentGateways = PaymentGateway::where(['slug' => 'twocheckout', 'status' => Activity::ENABLE])->first();
        if ($paymentGateways) {
            return true;
        }
        return false;
    }

    public function success($order, $request): \Illuminate\Http\RedirectResponse
    {
        try {
            if (isset($request->refno)) {
                $this->paymentService->payment($order, 'twocheckout', $request->refno);
                return redirect()->route('payment.successful', ['order' => $order])->with('success', trans('all.message.payment_successful'));
            } else {
                return redirect()->route('payment.fail', [
                    'order' => $order,
                    'paymentGateway' => 'twocheckout'
                ])->with('error', trans('all.message.something_wrong'));
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return redirect()->route('payment.fail', ['order' => $order, 'paymentGateway' => 'twocheckout'])->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function fail($order, $request): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('payment.index', ['order' => $order])->with(
            'error',
            trans('all.message.something_wrong')
        );
    }

    public function cancel($order, $request): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('home')->with('error', trans('all.message.payment_canceled'));
    }
}
