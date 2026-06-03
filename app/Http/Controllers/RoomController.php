<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $rooms = Room::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('academic.scheduleload.rooms', [
            'rooms' => $rooms,
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Room::create($this->validateRoom($request));

        return redirect()
            ->route('academic.schedule-load.rooms')
            ->with('success', 'Room added successfully.');
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $room->update($this->validateRoom($request, $room));

        return redirect()
            ->route('academic.schedule-load.rooms')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();

        return redirect()
            ->route('academic.schedule-load.rooms')
            ->with('success', 'Room deleted successfully.');
    }

    private function validateRoom(Request $request, ?Room $room = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms', 'name')->ignore($room?->id),
            ],
        ], [
            'name.unique' => 'This room already exists.',
        ]);
    }
}
