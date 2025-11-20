<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique();
            $table->foreignId('donation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('donor_name');
            $table->string('donor_email')->nullable();
            $table->string('donor_phone')->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', ['bank_transfer', 'qris', 'cash', 'other'])->default('bank_transfer');
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['donation_id', 'status']);
            $table->index('transaction_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_transactions');
    }
};
