<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Setiap kolom dicek dulu supaya aman dijalankan ulang
        // walaupun sebagian kolom sudah pernah ditambahkan.
        Schema::table('profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('profiles', 'tagline')) {
                $table->string('tagline')->nullable()->after('slug');
            }
            if (! Schema::hasColumn('profiles', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('profiles', 'instagram')) {
                $table->string('instagram')->nullable();
            }
            if (! Schema::hasColumn('profiles', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (! Schema::hasColumn('profiles', 'youtube')) {
                $table->string('youtube')->nullable();
            }
            if (! Schema::hasColumn('profiles', 'tiktok')) {
                $table->string('tiktok')->nullable();
            }
            if (! Schema::hasColumn('profiles', 'population')) {
                $table->unsignedInteger('population')->nullable();
            }
            if (! Schema::hasColumn('profiles', 'households')) {
                $table->unsignedInteger('households')->nullable();
            }
            if (! Schema::hasColumn('profiles', 'area_hectares')) {
                $table->decimal('area_hectares', 10, 2)->nullable();
            }
        });

        Schema::table('officials', function (Blueprint $table) {
            if (! Schema::hasColumn('officials', 'phone')) {
                $table->string('phone')->nullable()->after('photo_path');
            }
        });
    }

    public function down(): void
    {
        $profileColumns = array_filter(
            ['tagline', 'whatsapp', 'instagram', 'facebook', 'youtube', 'tiktok', 'population', 'households', 'area_hectares'],
            fn (string $column) => Schema::hasColumn('profiles', $column),
        );

        if ($profileColumns) {
            Schema::table('profiles', fn (Blueprint $table) => $table->dropColumn(array_values($profileColumns)));
        }

        if (Schema::hasColumn('officials', 'phone')) {
            Schema::table('officials', fn (Blueprint $table) => $table->dropColumn('phone'));
        }
    }
};