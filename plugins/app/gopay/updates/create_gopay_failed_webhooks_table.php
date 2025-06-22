<?php namespace App\Gopay\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateGopayFailedWebhooksTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('app_gopay_gopay_failed_webhooks', function ($table) {
            $table->id();
            $table->text('payload');
            $table->string('signature');
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('app_gopay_gopay_failed_webhooks');
    }
};
