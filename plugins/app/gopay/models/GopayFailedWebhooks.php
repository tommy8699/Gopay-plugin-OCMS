<?php namespace App\Gopay\Models;

use Model;

/**
 * GopayFailedWebhooks Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class GopayFailedWebhooks extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $table = 'your_plugin_gopay_failed_webhooks';
    protected $fillable = ['payload', 'signature', 'error'];

    /**
     * @var string table name
     */
    public $table = 'app_gopay_gopay_failed_webhooks';

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
