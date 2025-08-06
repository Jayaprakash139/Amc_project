<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmcStatusAllocsTable extends Migration
{
    public function up()
    {
        Schema::create('amc_status_allocs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asset_id')->nullable();
            $table->string('school_id')->nullable();
            $table->string('location_id')->nullable();
            $table->string('sub_location_id')->nullable();
            $table->string('product_status_id')->nullable();
            $table->date('amc_date')->nullable();
            $table->string('amc_remarks')->nullable();
            $table->string('amc_multi_gallery')->nullable();
            $table->string('video')->nullable();
            $table->string('amc_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}