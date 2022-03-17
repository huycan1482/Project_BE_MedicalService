<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nationalities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('abbreviation', 255);
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->unsignedBigInteger('province_id');
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->unsignedBigInteger('district_id');
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
        
        Schema::create('diseases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('producers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('vaccines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('vaccine_disease', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vaccine_id');
            $table->unsignedBigInteger('disease_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vaccine_id')->references('id')->on('vaccines')->onDelete('cascade');
            $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');
        });

        Schema::create('vaccine_producer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vaccine_id');
            $table->unsignedBigInteger('producer_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vaccine_id')->references('id')->on('vaccines')->onDelete('cascade');
            $table->foreign('producer_id')->references('id')->on('producers')->onDelete('cascade');
        });

        // Schema::create('packs', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('code', 255);
        //     $table->unsignedBigInteger('vaccine_id');
        //     $table->dateTime('EXP');
        //     $table->dateTime('MFG');
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('vaccine_id')->references('id')->on('vaccines')->onDelete('cascade');
        // });

        // Schema::create('injected_sessions', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('location', 255);
        //     $table->unsignedBigInteger('disease_id');
        //     $table->integer('quantity');
        //     $table->integer('actual_quantity');
        //     $table->integer('status');
        //     $table->dateTime('vaccination_date');
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');
        // });

        Schema::create('priorities', function (Blueprint $table) {
            // nhóm người ưu tiên
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::create('tables', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('name', 255);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        // Schema::create('permissions', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('name', 255);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        // Schema::create('table_permission', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('table_id');
        //     $table->unsignedBigInteger('permission_id');
        //     $table->integer('is_active');
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
        //     $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        // });

        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->integer('level');
            $table->unsignedBigInteger('ward_id');
            $table->text('description');
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
        });

        // Schema::create('organizations', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('name', 255);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('phone', 255);
            $table->string('identity_card', 255);
            $table->integer('gender');
            $table->unsignedBigInteger('ward_id');
            $table->string('address', 255);
            $table->text('description')->nullable();

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();

            $table->unsignedBigInteger('role_id');
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
        });

        Schema::create('residents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('phone', 255);
            $table->integer('gender');
            $table->string('identity_card', 255);
            $table->string('health_insurance_card', 255)->nullable();
            $table->unsignedBigInteger('nationality_id');
            $table->unsignedBigInteger('ward_id');
            $table->string('address', 255);
            $table->string('job', 255)->nullable();
            $table->string('work_place', 255)->nullable();
            $table->text('description')->nullable();
            $table->integer('is_active');

            $table->unsignedBigInteger('role_id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
        });

        // Schema::create('organization_role', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('organization_id');
        //     $table->unsignedBigInteger('role_id');
        //     $table->unsignedBigInteger('user_id')->nullable();
        //     $table->unsignedBigInteger('parent_id')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        //     $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // });

        // Schema::create('user_permission', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('table_permission_id');
        //     $table->unsignedBigInteger('org_role_id');
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('table_permission_id')->references('id')->on('table_permission')->onDelete('cascade');
        //     $table->foreign('org_role_id')->references('id')->on('organization_role')->onDelete('cascade');
        // });

        // Schema::create('list_injection', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('user_id');
        //     $table->unsignedBigInteger('session_id');
        //     $table->integer('status');
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('session_id')->references('id')->on('injected_sessions')->onDelete('cascade');
        // });

        Schema::create('sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start_at');
            $table->date('end_at');
            $table->string('address', 255);
            $table->integer('quantity');
            $table->integer('actual_quantity');
            $table->integer('status_id');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('objects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('resident_id');
            $table->text('description')->nullable();
            $table->integer('status_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });

        Schema::create('injections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vaccine_id');
            $table->unsignedBigInteger('resident_id');
            $table->unsignedBigInteger('object_id');
            $table->unsignedBigInteger('priority_id');
            $table->integer('type');
            $table->integer('dose');
            $table->text('description')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vaccine_id')->references('id')->on('vaccines')->onDelete('cascade');
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
            $table->foreign('object_id')->references('id')->on('objects')->onDelete('cascade');
            $table->foreign('priority_id')->references('id')->on('priorities')->onDelete('cascade');
        });

        // Schema::create('epidemics', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('user_id');
        //     $table->unsignedBigInteger('disease_id');
        //     $table->date('infected_date');
        //     $table->date('cured_date')->nullable();
        //     $table->date('isolated_date');
        //     $table->string('isolated_address', 255);
        //     $table->text('description')->nullable();

        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');
            
        // });

        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
