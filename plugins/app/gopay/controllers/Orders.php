<?php

namespace App\Gopay\Controllers;

use App\Gopay\Classes\PaymentGateway;
use App\Gopay\Models\Order;
use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Http\Request;

/**
 * Orders Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class Orders extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array required permissions
     */
    public $requiredPermissions = ['app.gopay.orders'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('App.Gopay', 'gopay', 'orders');
    }

    public function startPayment($id)
    {
        $order = Order::findOrFail($id);
        $gateway = new PaymentGateway();

        return redirect($gateway->start($order));
    }

    public function handleCallback(Request $request)
    {
        $gateway = new PaymentGateway();
        $result = $gateway->handleCallback($request);

        if ($result['status'] === 'paid') {
            $order = Order::find($result['order_id']);
            if ($order && $order->status !== 'paid') {
                $order->status = 'paid';
                $order->save();
            }
        }

        return response('OK', 200);
    }
}
