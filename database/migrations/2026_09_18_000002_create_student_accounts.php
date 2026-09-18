<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->unique()->constrained('students')->restrictOnDelete();
            $table->string('username')->unique();
            $table->string('email', 100)->nullable()->unique();
            $table->string('password');
            $table->string('name', 150)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('contact', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->unsignedBigInteger('requested_grlvl_id')->nullable();
            $table->unsignedBigInteger('requested_acady_id')->nullable();
            $table->string('status', 20)->default('PENDING')->index();
            $table->unsignedBigInteger('activated_by')->nullable();
            $table->dateTime('activated_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->unsignedBigInteger('deactivated_by')->nullable();
            $table->dateTime('deactivated_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });

        // These credentials and academic records already belonged to the same students.id.
        // Preserve that proven relationship, status, and password hash without name matching.
        DB::table('students')->orderBy('id')->chunkById(200, function ($students) {
            foreach ($students as $student) {
                $info = DB::table('stinfo')->where('student_id', $student->id)->first();
                DB::table('student_accounts')->insert([
                    'id' => $student->id,
                    'student_id' => $student->id, 'username' => $student->username,
                    'email' => $student->email, 'password' => $student->password,
                    'name' => $info?->name, 'birthdate' => $info?->birthdate,
                    'gender' => $info?->gender, 'contact' => $info?->contact,
                    'address' => $info?->address, 'requested_grlvl_id' => $info?->grlvl_id,
                    'requested_acady_id' => $info?->acady_id,
                    'status' => $student->status,
                    'activated_by' => $student->activated_by, 'activated_at' => $student->activated_at,
                    'rejected_by' => $student->rejected_by, 'rejected_at' => $student->rejected_at,
                    'deactivated_by' => $student->deactivated_by, 'deactivated_at' => $student->deactivated_at,
                    'rejection_reason' => $student->rejection_reason,
                    'created_at' => $student->created_at, 'updated_at' => $student->updated_at,
                ]);
            }
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Student account links must be preserved. Use a reviewed manual rollback.');
    }
};
