<?php

namespace App\Gopay\Models;

use Model;

/**
 * GopayLogs Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class GopayLogs extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'app_gopay_gopay_logs';

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
