<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Türkçe locale'ı ekle (eğer yoksa)
        $exists = DB::table('locales')->where('code', 'tr')->exists();

        if (!$exists) {
            DB::table('locales')->insert([
                'code' => 'tr',
                'name' => 'Turkish',
                'direction' => 'ltr',
                'logo_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('locales')->where('code', 'tr')->delete();
    }
};
