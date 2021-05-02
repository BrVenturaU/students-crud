<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;


/**
* 
    * @OA\Info(
    *    title="API estudiantes",
    *    version="1.0"
    * )
*
* @OA\Server(url="http://127.0.0.1:8000/api")
*/

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      /**
    * @OA\Get(
    *     path="/students",
    *     summary="Muestra un listado de estudiantes paginado.",
    *     tags={"Students"},
    *     @OA\Parameter(
    *          name="code",
    *          description="Código del estudiante",
    *          in="query",
    *          @OA\Schema(
    *              type="string"
    *          )
    *    ),
    *    @OA\Parameter(
    *          name="page",
    *          description="Página de datos",
    *          in="query",
    *          @OA\Schema(
    *              type="integer",
    *              default=1
    *          )
    *    ),
    *    @OA\Parameter(
    *          name="perPage",
    *          description="Cantidad de datos por página",
    *          in="query",
    *          @OA\Schema(
    *              type="integer",
    *              default=4
    *          )
    *    ),
    *    @OA\Parameter(
    *          name="order",
    *          description="Orden ascendiente (true) o descendiente (false)",
    *          in="query",
    *          @OA\Schema(
    *              type="boolean",
    *              default=true
    *          )
    *    ),
    *     @OA\Response(
    *         response=200,
    *         description="Devuelve un listado de estudiantes."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Ha ocurrido un error."
    *     )
    * )
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
        //
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
