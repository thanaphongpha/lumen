<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\people;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
     //   $keyword = $request->keyword;
       // dd($request->all());

//        $testResponse = ['name' => 'Thanaphong',
//            'surname' => 'Phatthanasing'];

       $people = people::all();
//
//        foreach ($people as $key => $item){
//           //$item ->age = rand(0,100);
//        }
//        //dd($people[0]->age);

     //   $people = people::where('name','=',$keyword)->orWhere('age','=',$keyword)->get();

        return response()->json($people);
    }
    public function search(Request $request)
    {
           $keyword = $request->keyword;
        // dd($request->all());

//        $testResponse = ['name' => 'Thanaphong',
//            'surname' => 'Phatthanasing'];

        // $people = People::all();
//
//        foreach ($people as $key => $item){
//           //$item ->age = rand(0,100);
//        }
//        //dd($people[0]->age);

           $people = people::where('name','like' ,'%'.$keyword.'%' )->orWhere('age','=',$keyword)->get();

        return response()->json($people);
    }

    public function store(Request $request)
    {
        $name = $request->name;
        $gender = $request->gender;
        $university = $request->university;
        $profile_image = $request->profile_image;
        $age = $request->age;



        $people = new people;
        $people->name = $name;
        $people->gender = $gender;
        $people->university = $university;
        $people->profile_image = $profile_image;
        $people->age = $age;
        $people->save();


        return response()->json($people);
    }
    public function destroy($id)
    {
        $people = people::find($id)->delete();

        return response()->json($people);
    }
    public function update(Request $request, $id)
    {

        $name = $request->name;
        $gender = $request->gender;
        $age = $request->age;
        $university = $request->university;
        $profile_image = $request->profile_image;

        $people = people::find($id);

        $people->name = $name;
        $people->gender = $gender;
        $people->age = $age;
        $people->university = $university;
        $people->profile_image = $profile_image;
        $people->save();

        return response()->json($people);
    }

}
