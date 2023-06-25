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
        Schema::table('loan_amortization_schedules', function (Blueprint $table) {
            $table->decimal('extra_repayment_made', 10, 2)->default(0)->after('interest_component');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_amortization_schedules', function (Blueprint $table) {
            Schema::table('loan_amortization_schedules', function (Blueprint $table) {
                $table->dropColumn('extra_repayment_made');
            });
        });
    }
};
