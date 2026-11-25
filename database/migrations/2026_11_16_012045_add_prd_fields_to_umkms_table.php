
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->string('price_range')->nullable();
            $table->string('instagram')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn([
                'price_range',
                'instagram',
                'is_featured',
                'is_published',
            ]);
        });
    }
};
