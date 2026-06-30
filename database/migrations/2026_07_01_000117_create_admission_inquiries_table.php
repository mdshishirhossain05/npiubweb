<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admission_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->string('program_label')->nullable();
            $table->text('message')->nullable();
            // new | contacted | enrolled | closed
            $table->string('status')->default('new')->index();
            $table->timestamp('handled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admission_inquiries');
    }
};
