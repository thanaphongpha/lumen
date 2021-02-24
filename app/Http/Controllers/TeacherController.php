<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
  public function index()
  {
    $teacher = Teacher::where('age', '>=', 50)
      ->orwhere('age', '>=', 25)
      ->get();
    return response()->json($teacher);
  }

  public function store(Request $request)
  {
    $name = $request->name;
    $age = $request->age;





    $teacher = new Teacher();
    $teacher->name = $name;
    $teacher->age = $age;

    $teacher->save();


    return response()->json($teacher);
  }
  public function update(Request $request, $id)
  {
    $name = $request->name;

    $teacher = Teacher::find($id);

    $teacher->name = $name;
    $teacher->save();

    return response()->json($teacher);
  }
  public function destroy($id)
  {
    $teacher = Teacher::find($id)->delete();

    return response()->json($teacher);
  }
}
