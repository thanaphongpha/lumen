<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;

class TraineeController extends Controller
{
    public function index()
    {
        $people = People::all();
        return response()->json($people);


    }

    public function store(Request $request)
    {
        $name = $request->name;
        $gender = $request->gender;
        $university = $request->university;
        $profile_image = $request->profile_image;



        $people = new People;
        $people->name = $name;
        $people->gender = $gender;
        $people->university = $university;
        $people->profile_image = $profile_image;
        $people->save();


        return response()->json($people);
    }
}
