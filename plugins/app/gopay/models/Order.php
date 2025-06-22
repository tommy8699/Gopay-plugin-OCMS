<?php namespace App\Gopay\Models;

use Model;

/**
 * Order Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'app_gopay_orders';

    /**
     * @var array rules for validation
     */
    public $rules = [];

    protected $fillable = ['total', 'status', 'customer_email', 'payment_id'];

    public $timestamps = true;
}
