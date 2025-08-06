<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAllocationsTable extends Migration
{
    public function up()
    {
        Schema::table('allocations', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id', 'school_fk_9373375')->references('id')->on('schools');
            $table->unsignedBigInteger('sublocation_id')->nullable();
            $table->foreign('sublocation_id', 'sublocation_fk_9373376')->references('id')->on('locations');
            $table->unsignedBigInteger('aaset_category_id')->nullable();
            $table->foreign('aaset_category_id', 'aaset_category_fk_9373377')->references('id')->on('categories');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_9373382')->references('id')->on('statuses');
            $table->unsignedBigInteger('custody_id')->nullable();
            $table->foreign('custody_id', 'custody_fk_9373404')->references('id')->on('employees');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9373387')->references('id')->on('teams');
        });
    }
}
