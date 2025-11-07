<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rescuers', function (Blueprint $table) {
            $table->string('cv_path')->nullable()->after('cv_documentado');
        });
        Schema::table('veterinarians', function (Blueprint $table) {
            $table->string('cv_path')->nullable()->after('cv_documentado');
        });
    }

    public function down(): void
    {
        Schema::table('rescuers', function (Blueprint $table) {
            $table->dropColumn('cv_path');
        });
        Schema::table('veterinarians', function (Blueprint $table) {
            $table->dropColumn('cv_path');
        });
    }
};


