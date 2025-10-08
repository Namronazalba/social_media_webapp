<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update the ENUM to include 'unfriend'
        DB::statement("ALTER TABLE friendships MODIFY COLUMN status ENUM('pending', 'accepted', 'unfriend') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Rollback to original ENUM (without 'unfriend')
        DB::statement("ALTER TABLE friendships MODIFY COLUMN status ENUM('pending', 'accepted') NOT NULL DEFAULT 'pending'");
    }
};
