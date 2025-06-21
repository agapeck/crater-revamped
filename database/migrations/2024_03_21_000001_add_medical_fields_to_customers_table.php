<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMedicalFieldsToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('age')->nullable()->after('phone');
            $table->string('next_of_kin')->nullable()->after('age');
            $table->string('next_of_kin_phone')->nullable()->after('next_of_kin');
            $table->text('diagnosis')->nullable()->after('next_of_kin_phone');
            $table->text('treatment')->nullable()->after('diagnosis');
            $table->string('attended_by')->nullable()->after('treatment');
            $table->date('review_date')->nullable()->after('attended_by');

            // Add indexes for frequently queried fields
            $table->index('age');
            $table->index('review_date');
            $table->index('attended_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'age',
                'next_of_kin',
                'next_of_kin_phone',
                'diagnosis',
                'treatment',
                'attended_by',
                'review_date'
            ]);
        });
    }
} 