<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $code = $request->input('code');
        $perPage = $request->input('perPage');
        $order = filter_var($request->input('order'), FILTER_VALIDATE_BOOLEAN);
        $students = Student::where('code', 'like', "%$code%")->orderBy('id', $order ? 'ASC' : 'DESC')->paginate($perPage)->toArray();
        return $students;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // requeridos
        $this->validate($request, [
            'name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'birth_date' => 'required|date_format:Y-m-d',
            'gender' => 'required|in: F, M',
            'code' => 'required|max:10'
        ]);

        $students = Student::all();
        
        $students->save();
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);
        return $student;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        if($student == null)
            return ["message" => "El registro solicitado no existe."];
        $student->delete();
        return ["message" => "Registro eliminado con éxito."];
    }
}
