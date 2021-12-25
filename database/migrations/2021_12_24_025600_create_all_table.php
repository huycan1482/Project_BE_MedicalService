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
        Schema::create('provinces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->unsignedBigInteger('province_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->unsignedBigInteger('districts_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('districts_id')->references('id')->on('districts')->onDelete('cascade');
        });
        
        Schema::create('diseases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('producers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('country', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('vaccines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->unsignedBigInteger('disease_id');
            $table->unsignedBigInteger('producer_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');
            $table->foreign('producer_id')->references('id')->on('producers')->onDelete('cascade');
        });

        Schema::create('packs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255);
            $table->unsignedBigInteger('vaccine_id');
            $table->dateTime('EXP');
            $table->dateTime('MFG');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vaccine_id')->references('id')->on('vaccines')->onDelete('cascade');
        });

        Schema::create('injected_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location', 255);
            $table->unsignedBigInteger('disease_id');
            $table->integer('quantity');
            $table->integer('actual_quantity');
            $table->integer('status');
            $table->dateTime('vaccination_date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');
        });


        Schema::create('tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('table_permission', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('permission_id');
            $table->integer('is_active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->unsignedBigInteger('parent_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255)->unique();
            $table->string('identity_card', 255)->unique();
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('phone', 255)->nullable();
            $table->string('address', 255);
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('ward_id');
            $table->string('workplace', 255)->nullable();
            $table->text('description')->nullable();
            $table->integer('is_active');

            $table->unsignedBigInteger('org_role_id')->nullable();

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
        });

        Schema::create('organization_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


        Schema::create('user_permission', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('table_permission_id');
            $table->unsignedBigInteger('org_role_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('table_permission_id')->references('id')->on('table_permission')->onDelete('cascade');
            $table->foreign('org_role_id')->references('id')->on('organization_role')->onDelete('cascade');
        });


        Schema::create('injections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->integer('dose');
            $table->unsignedBigInteger('pack_id');
            $table->dateTime('vaccination_date');
            $table->unsignedBigInteger('session_id');
            $table->string('location', 255);
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pack_id')->references('id')->on('packs')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('injected_sessions')->onDelete('cascade');
            
        });

        Schema::create('epidemics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('disease_id');
            $table->date('infected_date');
            $table->date('cured_date')->nullable();
            $table->date('isolated_date');
            $table->string('isolated_address', 255);
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');
            
        });

        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('wards');
        Schema::dropIfExists('diseases');
        Schema::dropIfExists('producers');
        Schema::dropIfExists('vaccines');
        Schema::dropIfExists('packs');
        Schema::dropIfExists('injected_sessions');
        Schema::dropIfExists('tables');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('table_permission');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('users');
        Schema::dropIfExists('organization_role');
        Schema::dropIfExists('user_permission');
        Schema::dropIfExists('injections');
        Schema::dropIfExists('epidemics');
    }
}
