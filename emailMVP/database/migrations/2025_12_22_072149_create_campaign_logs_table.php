<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('campaign_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('campaign_id'); // FK but no constraint
            $table->unsignedBigInteger('lead_id');     // FK but no constraint

            $table->string('status'); // sent, failed, pending
            $table->text('error_message')->nullable();
            $table->string('email_account_used')->nullable();
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_logs');
    }
};
