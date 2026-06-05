<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('email_verified_at');
            $table->string('google_id')->nullable()->after('points');
            $table->string('google_token')->nullable()->after('google_id');
            $table->string('google_refresh_token')->nullable()->after('google_token');
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'points')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['points', 'google_id', 'google_token', 'google_refresh_token']);
            });
        }

        \Illuminate\Support\Facades\DB::table('users')->whereNull('password')->update(['password' => '']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable(false)->change();
        });
    }
};
