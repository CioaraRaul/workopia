<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //clear the existing data in the job_listings table
        DB::table('job_listings')->truncate();

        Schema::table('job_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');

            $table->integer('salary');
            $table->string('strings')->nullable();
            $table->enum('job_type', ['full-time', 'part-time', 'contract','temporary', 'internship', 'volunteer', 'on-call'])->default('full-time');
            $table->boolean('remote')->default(false);
            $table->string('requirements')->nullable();
            $table->string('benefits')->nullable();
            $table->string('address')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zipcode')->nullable();
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->string('company_name');
            $table->text('company_description')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_website')->nullable();

            // Define the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn(['salary', 'strings', 'job_type', 'remote', 'requirements', 'benefits', 'address', 'city', 'state', 'zipcode', 'contact_email', 'contact_phone', 'company_name', 'company_description', 'company_logo', 'company_website']);
            $table->dropForeign(['user_id']);
        });
    }
};
