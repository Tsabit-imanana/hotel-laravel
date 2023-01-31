<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function show(){
        $room = Rooms::all();
        return response()->json($room);
    }



    public function detail($id)
    {
        $room = Rooms::find($id);

        $room_id = $room->room_id;
        $room_number = $room->room_number;
        $type_id = $room->type_id;
        $status = $room->status;  

        $data = Type::find($type_id);

        $type_name = $data->type_name;
        $price = $data->price;
        $desc = $data->desc;

        
        return response()->json([
            'room_id' => $room_id,
            'room_number' =>   $room_number,
            'type_id'=> $type_id,
            'status'=> $status,
            'type_name' => $type_name,
            'price' => $price,
            'desc' => $desc
        ]);
    }



    public function store(Request $request){
        $this->validate($request,[
            'type_id' => 'required',
            'room_number' => 'required',
            'status' => 'required',
        ]);
        Rooms::create([
            'type_id' => $request->type_id,
            'room_number' => $request->room_number,
            'status' => $request->status,
        ]);
        return response()->json([
            'message' => 'Success!!',
            'data' => Rooms::all()
        ]);
    }

    public function destroy($id)
    {
        $data = Rooms::find($id);
        $data->delete();

        return response()->json([
            'message' => "Data deleted",
        ]);
    }

    public function update(Request $request,$id){

        $this->validate($request,[
            'room_number' => 'required',
            'status' => 'required',
            'type_id' => 'required',
        ]);

        Rooms::where('room_id',$id)->update([
            'room_number'    =>$request->room_number,
            'status'    =>$request->status,
            'type_id'    =>$request->type_id,
        ]);
        
 

        return response()->json([
            'message' => 'Success Update Data!',
            'data' => Rooms::find($id)
        ]);


    }


}