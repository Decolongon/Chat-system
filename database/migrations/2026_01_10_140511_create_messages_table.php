<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'sender_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'receiver_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->longText('message');
            $table->timestamp('sender_deleted_at')->nullable();
            $table->timestamp('receiver_deleted_at')->nullable();
            $table->timestamp('deleted_for_everyone_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
