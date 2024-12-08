<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }

    public function show(Room $room)
    {
        return response()->json($room);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room' => 'required'
        ]);

        $room = Room::create($data);

        return response()->json($room, 201);
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'room' => 'required'
        ]);

        $room->fill($data)
            ->save();

        return response()->json($room);
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json(null, 204);
    }

    public function reservations(Room $room)
    {
        $reservations = $room->reservations;

        return response()->json($reservations);
    }
}
