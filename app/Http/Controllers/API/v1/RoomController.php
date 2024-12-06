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
}
