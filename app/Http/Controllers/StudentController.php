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
    *         description="Devuelve un listado de estudiantes.",
    *            @OA\JsonContent(
    *               @OA\Property(property="current_page", type="integer", example=1),
    *               @OA\Property(property="total", type="integer", example=1),
    *               @OA\Property(property="per_page", type="string", example="1"),
    *               @OA\Property(property="last_page", type="integer", example=1),
    *               @OA\Property(property="from", type="integer", example=1),
    *               @OA\Property(property="to", type="integer", example=1),
    *               @OA\Property(property="data", type="array", collectionFormat="multi",
    *                    @OA\Items(ref="#/components/schemas/Student")
    *               )
    *            )
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
    * @OA\Post(
    *     path="/students",
    *     summary="Permite crear un estudiante.",
    *     tags={"Students"},
    *     @OA\RequestBody(
    *         required=true,
    *         description="Objeto de solicitud de datos del estudiante.",
    *         @OA\JsonContent(
    *           @OA\Property(property="name", type="string", example="string"),
    *           @OA\Property(property="last_name", type="string", example="string"),
    *           @OA\Property(property="birth_date", type="string", format="date-time", example="2019-02-25"),
    *           @OA\Property(property="gender", type="string", maxLength=1, example="F"),
    *           @OA\Property(property="code", type="string", maxLength=10, example="1234567890"),
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Devuelve una respuesta de creado.",
    *         @OA\JsonContent(
    *           @OA\Property(property="message", type="string", example="Registro creado con éxito")
    *         )
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function store(Request $request)
    {
        //
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
