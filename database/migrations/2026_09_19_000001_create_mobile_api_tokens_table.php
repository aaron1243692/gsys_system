<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mobile_api_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('account_type', 20);
            $table->unsignedBigInteger('account_id');
            $table->char('token_hash', 64)->unique();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();
            $table->index(['account_type', 'account_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_api_tokens');
    }
};
