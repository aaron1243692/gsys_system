<?php

namespace App\Services;

use App\Models\{Guardian, Student, StudentAccount, StudentInfo};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegistrationService
{
    public function messages(): array
    {
        return ['lrn.unique' => 'This LRN is already registered.', 'lrn.digits' => 'The LRN must be exactly 12 digits.'];
    }

    public function rules(string $role): array
    {
        $table = $role === 'student' ? 'student_accounts' : 'guardians';

        return [
            'username' => array_values(array_filter(['required', 'alpha_dash', 'max:100', 'unique:'.$table.',username', $role === 'student' ? 'unique:students,username' : null])),
            'email' => array_values(array_filter(['required', 'email', 'max:100', 'unique:'.$table.',email', $role === 'student' ? 'unique:students,email' : null])),
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'same:password'],
            'name' => ['required', 'string', 'max:150'],
            'contact' => [$role === 'student' ? 'required' : 'nullable', 'string', 'max:100'],
            'address' => [$role === 'student' ? 'required' : 'nullable', 'string', 'max:255'],
            'terms' => ['accepted'],
            'privacy' => ['accepted'],
        ] + ($role === 'student' ? [
            'lrn' => ['required', 'digits:12', Rule::unique('stinfo', 'lrn')],
            'birthdate' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:Female,Male'],
            'grlvl_id' => ['required', 'integer', 'exists:grlvl,id'],
            'acady_id' => ['required', 'integer', 'exists:acady,id'],
        ] : []);
    }

    public function register(string $role, array $data): Model
    {
        return DB::transaction(function () use ($role, $data) {
            if ($role === 'student') {
                $student = Student::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                ]);
                $student->forceFill(['status' => 'PENDING'])->save();

                StudentInfo::create([
                    'student_id' => $student->id,
                    'lrn' => $data['lrn'],
                    'name' => $data['name'],
                    'birthdate' => $data['birthdate'],
                    'gender' => $data['gender'],
                    'contact' => $data['contact'] ?? null,
                    'address' => $data['address'] ?? null,
                    'grlvl_id' => $data['grlvl_id'],
                    'acady_id' => $data['acady_id'],
                    'admited' => 0,
                ]);

                $account = new StudentAccount;
                $account->fill($this->accountAttributes($data));
                $account->fill([
                    'student_id' => $student->id,
                    'requested_grlvl_id' => $data['grlvl_id'],
                    'requested_acady_id' => $data['acady_id'],
                ]);
            } else {
                $account = new Guardian;
                $account->fill($this->accountAttributes($data));
            }

            $account->status = 'PENDING';
            $account->save();

            foreach (['terms', 'privacy'] as $document) {
                DB::table('agreement_records')->insert([
                    'account_type' => $role,
                    'account_id' => $account->id,
                    'document_type' => $document,
                    'document_version' => config('school.'.$document.'_version'),
                    'accepted_at' => now(),
                ]);
            }

            Audit::record($role, $account->id, 'registration.created', $account);

            return $account->setRelation('student', $role === 'student' ? $student : null);
        });
    }

    private function accountAttributes(array $data): array
    {
        return array_intersect_key($data, array_flip([
            'username', 'email', 'password', 'name', 'contact', 'address', 'birthdate', 'gender',
        ]));
    }
}
