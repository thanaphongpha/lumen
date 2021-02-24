<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News_Feed;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        //   $keyword = $request->keyword;
        // dd($request->all());

//        $testResponse = ['name' => 'Thanaphong',
//            'surname' => 'Phatthanasing'];

        $users = Users::all();
//
//        foreach ($people as $key => $item){
//           //$item ->age = rand(0,100);
//        }
//        //dd($people[0]->age);

        //   $people = people::where('name','=',$keyword)->orWhere('age','=',$keyword)->get();

        return response()->json($users);
    }




}
