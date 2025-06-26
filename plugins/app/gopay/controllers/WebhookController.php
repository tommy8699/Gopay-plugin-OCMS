<?php namespace App\Gopay\Controllers;

use App\Gopay\Models\GopayFailedWebhooks;
use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Webhook Controller Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class WebhookController extends Controller
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
    public $requiredPermissions = ['app.gopay.webhookcontroller'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('App.Gopay', 'gopay', 'webhookcontroller');
    }

    public function notify(Request $request)
    {
        $secret = env('GOPAY_SECRET');
        $rawBody = file_get_contents('php://input');
        $signature = hash_hmac('sha256', $rawBody, $secret);
        $incomingSignature = $request->header('X-GO-PAY-SIGNATURE');

        if (!hash_equals($signature, $incomingSignature)) {
            Log::warning('GoPay webhook: Invalid signature', [
                'expected' => $signature,
                'received' => $incomingSignature,
                'body' => $rawBody,
            ]);
            return response('Invalid signature', 403);
        }

        try {

        } catch (\Throwable $e) {
            GopayFailedWebhooks::create([
                'payload' => $rawBody,
                'signature' => $incomingSignature,
                'error' => $e->getMessage(),
            ]);
            Log::error('GoPay webhook failed', ['exception' => $e]);
            return response('Webhook processing failed', 500);
        }
    }
}
