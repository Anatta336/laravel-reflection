<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Laravel migrations intentionally have no namespace
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * Migration to create the Users database table.
 *
 * @package User
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('canEditCompany');
            $table->boolean('canDeleteCompany');
            $table->boolean('canCreateCompany');
            $table->boolean('canEditEmployee');
            $table->boolean('canDeleteEmployee');
            $table->boolean('canCreateEmployee');
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
