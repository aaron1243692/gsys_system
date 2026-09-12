<form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
    @foreach($adminReport ? ['academic_year', 'grade_level', 'class', 'subject', 'teacher', 'student'] : ['academic_year'] as $field)
        <label class="text-sm font-semibold">{{ $field === 'academic_year' ? 'School Year' : ucfirst(str_replace('_', ' ', $field)) }}
            <select name="{{ $field }}_id" class="mt-1 block max-w-56 rounded-lg border border-slate-300 bg-white p-2">
                <option value="">All</option>
                @foreach($options[$field] as $option)
                    <option value="{{ $option->{$field.'_id'} }}" @selected((string) ($filters[$field.'_id'] ?? '') === (string) $option->{$field.'_id'})>{{ $option->{$field.'_name'} }}</option>
                @endforeach
            </select>
        </label>
    @endforeach
    @if($adminReport)
        <label class="text-sm font-semibold">Quarter<select name="quarter" class="mt-1 block rounded-lg border border-slate-300 p-2"><option value="">All</option>@foreach([1,2,3] as $q)<option value="{{ $q }}" @selected((int) ($filters['quarter'] ?? 0) === $q)>Q{{ $q }}</option>@endforeach</select></label>
        <label class="text-sm font-semibold">Search<input name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Student or subject" class="mt-1 block rounded-lg border border-slate-300 p-2"></label>
    @endif
    <button class="rounded-full bg-blue-700 px-4 py-2 text-white">Apply</button>
    <a class="rounded-full border border-slate-300 px-4 py-2" href="{{ url()->current() }}">Reset</a>
</form>
<p class="mb-3 text-sm text-slate-600">Stored final quarter grades. — means no grade recorded for the selected filters.</p>
<div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
    <table class="w-full text-left text-sm">
        <thead class="bg-blue-700 text-white"><tr>@if($adminReport)<th class="p-3">Student</th>@endif<th class="p-3">Class / Grade Level</th><th class="p-3">School Year</th><th class="p-3">Subject</th>@foreach([1,2,3] as $q)<th class="p-3">Q{{ $q }}</th>@endforeach</tr></thead>
        <tbody>
            @forelse($grades as $record)
                <tr class="border-b border-slate-200">
                    @if($adminReport)<td class="p-3">{{ $record->student_name }}</td>@endif
                    <td class="p-3">{{ $record->class_name }}<div class="text-slate-500">{{ $record->grade_level_name }}</div></td>
                    <td class="p-3">{{ $record->academic_year_name }}</td><td class="p-3">{{ $record->subject_name }}</td>
                    @foreach([1,2,3] as $q)
                        <td class="p-3"><span class="font-bold">{{ $record->{'q'.$q} ?? '—' }}</span><div class="text-slate-600">{{ $record->{'remarks'.$q} }}</div>@if($adminReport)<div class="text-xs text-slate-500">{{ $record->{'teacher'.$q} }}</div>@endif</td>
                    @endforeach
                </tr>
            @empty
                <tr><td colspan="{{ $adminReport ? 7 : 6 }}" class="p-5 text-center">No recorded grades found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $grades->links() }}</div>
