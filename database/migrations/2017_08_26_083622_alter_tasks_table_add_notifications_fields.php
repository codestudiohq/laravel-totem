<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTasksTableAddNotificationsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('totem.table_prefix').'tasks', function (Blueprint $table) {
            $table->string('notification_phone_number')->nullable()->after('notification_email_address');
            $table->string('notification_slack_webhook')->nullable()->after('notification_phone_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('totem.table_prefix').'tasks', function (Blueprint $table) {
            $table->dropColumn('notification_phone_number');
        });

        Schema::table(config('totem.table_prefix').'tasks', function (Blueprint $table) {
            $table->dropColumn('notification_slack_webhook');
        });
    }
}
