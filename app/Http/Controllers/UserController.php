<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function show($id)
    {
        return response()->json(User::find($id));
    }

    public function store(Request $data)
    {
        try {
            return response()->json(User::create($data->toArray()));
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }

    public function update($id, Request $data)
    {
        User::find($id)->update($data->toArray());

        return response()->json(User::find($id));
    }

    public function delete($id)
    {
        $deletedUser = User::find($id)->delete();

        if($deletedUser){
            return response("success");
        }else{
            return response("error");
        }
    }
}
