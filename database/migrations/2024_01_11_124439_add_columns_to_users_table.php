<?php

use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname')->after('id');
            $table->string('lastname')->after('id');
            $table->enum('role', array_map(fn($case) => $case->value, UserRole::cases()))->default(UserRole::GUEST->value)->after('password');
            $table->enum('status', array_map(fn($case) => $case->value, UserStatus::cases()))->default(UserStatus::INACTIVE->value)->after('password');
            $table->dropColumn('name');
            $table->timestamp('last_login_at', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('role');
            $table->dropColumn('status');
            $table->string('name');
            $table->dropColumn('last_login_at');
        });
    }
};
