<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;


/**
* 
    * @OA\Info(
    *    title="API estudiantes",
    *    version="1.0"
    * )
*
* @OA\Server(url="http://127.0.0.1:8000/api/v1")
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
    *         response=200,
    *         description="Devuelve una respuesta de éxito.",
    *         @OA\JsonContent(
    *           @OA\Property(property="message", type="string", example="Cambios realizados con éxito.")
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Devuelve una respuesta de éxito.",
    *         @OA\JsonContent(
    *           @OA\Property(property="message", type="string", example="Cambios realizados con éxito.")
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="El registro solicitado no existe.",
    *         @OA\JsonContent(
    *           @OA\Property(property="message", type="string", example="El registro solicitado no existe.")
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
        // requeridos
        $this->validate($request, [
            'name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'birth_date' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:M,F',
            'code' => 'required|max:10'
        ]);
        if($request->has('id')){
            $student = Student::find($request->input('id'));
            if($student == null)
                return response()->json(["message" => "El registro solicitado no existe."], 404);
            $student->update($request->all());
            return response()->json(["message" => "Cambios realizados con éxito."], 200);
        }
        Student::create($request->all());
        return response()->json(["message" => "Cambios realizados con éxito."], 201);
        
    }

    /**
    * @OA\Put(
    *     path="/students/{id}",
    *     summary="Permite crear un estudiante.",
    *     tags={"Students"},
    *     @OA\Parameter(
    *          name="id",
    *          description="Id del estudiante",
    *          in="path",
    *          required = true,
    *          @OA\Schema(
    *              type="integer"
    *          )
    *    ),
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
    *         response=200,
    *         description="Devuelve una respuesta de actualizado.",
    *         @OA\JsonContent(
    *           @OA\Property(property="message", type="string", example="Registro actualizado con éxito")
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="El registro solicitado no existe.",
    *         @OA\JsonContent(
    *           @OA\Property(property="message", type="string", example="El registro solicitado no existe.")
    *         )
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function update(Request $request, $id)
    {
        
        $student = Student::find($id);
        if($student == null)
            return response()->json(["message" => "El registro solicitado no existe."], 404);    
        $student->update($request->all());
        return response()->json(["message" => "Registro actualizado con éxito."], 200);
        
    }

    /**
    * @OA\Delete(
    *     path="/students/{id}",
    *     summary="Permite eliminar un estudiante.",
    *     tags={"Students"},
    *     @OA\Parameter(
    *          name="id",
    *          description="Id del estudiante",
    *          in="path",
    *          required = true,
    *          @OA\Schema(
    *              type="integer"
    *          )
    *    ),
    *     @OA\Response(
    *         response=200,
    *         description="Devuelve una respuesta de eliminado.",
    *         @OA\JsonContent(
    *           @OA\Property(property="message", type="string", example="Registro eliminado con éxito")
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="El registro solicitado no existe.",
    *         @OA\JsonContent(
    *           @OA\Property(property="message", type="string", example="El registro solicitado no existe.")
    *         )
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function destroy($id)
    {
        $student = Student::find($id);
        if($student == null)
            return response()->json(["message" => "El registro solicitado no existe."], 404);
        $student->delete();
        return response()->json(["message" => "Registro eliminado con éxito."], 200);
    }
}
