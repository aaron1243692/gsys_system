<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\GuardianChild;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\{DB, Gate};
use App\Services\Audit;
use Illuminate\View\View;

class GuardianController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $guardians = Guardian::query()
            ->with(['children' => fn ($query) => $query->where('status', 'VERIFIED')
                ->with('student.info.gradeLevel', 'student.info.schoolClass', 'student.info.academicYear')])
            ->withCount([
                'children as children_count' => fn ($query) => $query->where('status','VERIFIED'),
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.accounts.guardians', [
            'guardians' => $guardians,
            'students' => Student::query()->with('info.gradeLevel', 'info.schoolClass', 'info.academicYear')->orderBy('id')->get(),
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('guardians', 'username')],
            'email' => ['nullable', 'email', 'max:100', Rule::unique('guardians', 'email')],
            'name' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ], [
            'username.unique' => 'This username already exists.',
            'email.unique' => 'This email already exists.',
        ]);

        Guardian::create($validated);

        return redirect()
            ->route('configuration.accounts.guardians')
            ->with('success', 'Guardian added successfully.');
    }

    public function update(Request $request, Guardian $guardian): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('guardians', 'username')->ignore($guardian->id)],
            'email' => ['nullable', 'email', 'max:100', Rule::unique('guardians', 'email')->ignore($guardian->id)],
            'name' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
        ], [
            'username.unique' => 'This username already exists.',
            'email.unique' => 'This email already exists.',
        ]);

        $guardian->update($validated);

        return redirect()
            ->route('configuration.accounts.guardians')
            ->with('success', 'Guardian updated successfully.');
    }

    public function destroy(Guardian $guardian): RedirectResponse
    {
        $guardian->delete();

        return redirect()
            ->route('configuration.accounts.guardians')
            ->with('success', 'Guardian deleted successfully.');
    }

    public function resetPassword(Request $request, Guardian $guardian): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        $guardian->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('configuration.accounts.guardians')
            ->with('success', 'Guardian password reset successfully.');
    }

    public function storeChild(Request $request, Guardian $guardian): RedirectResponse
    {
        Gate::forUser($request->user('web'))->authorize('manage-registrations');
        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'relationship' => ['required', Rule::in(['Mother', 'Father', 'Legal Guardian', 'Other'])],
            'confirm' => ['required', 'accepted'],
        ]);
        DB::transaction(function () use ($guardian, $validated, $request) {
            Guardian::whereKey($guardian->id)->lockForUpdate()->firstOrFail();
            $existing = GuardianChild::where('guardian_id', $guardian->id)->where('student_id', $validated['student_id'])->first();
            if ($existing?->status === 'VERIFIED') throw ValidationException::withMessages([
                'student_id' => 'This student is already linked to this guardian.',
            ]);
            $link = $existing ?? new GuardianChild(['guardian_id' => $guardian->id, 'student_id' => $validated['student_id']]);
            $link->forceFill(['relationship' => $validated['relationship'], 'status' => 'VERIFIED',
                'verified_by' => $request->user('web')->id, 'verified_at' => now()])->save();
            Audit::record('web', $request->user('web')->id, 'child.linked', $link,
                ['reused_existing_link' => $existing !== null]);
        });

        return redirect()
            ->route('configuration.accounts.guardians')
            ->with('success', 'Child linked successfully.')
            ->with('open_modal', 'childs-guardian-' . $guardian->id);
    }

    public function destroyChild(Request $request, GuardianChild $guardianChild): RedirectResponse
    {
        Gate::forUser($request->user('web'))->authorize('manage-registrations');
        DB::transaction(function () use ($guardianChild, $request) {
            $guardianChild->delete();
            Audit::record('web', $request->user('web')->id, 'child.removed', $guardianChild);
        });

        return redirect()
            ->route('configuration.accounts.guardians')
            ->with('success', 'Child removed from guardian successfully.');
    }
}
