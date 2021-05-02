<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
*
* @OA\Schema(
*   @OA\Xml(name="Student"),
*   @OA\Property(property="id", type="integer", example="1"),
*   @OA\Property(property="name", type="string", example="string"),
*   @OA\Property(property="last_name", type="string", example="string"),
*   @OA\Property(property="birth_date", type="string", format="date-time", example="2019-02-25"),
*   @OA\Property(property="gender", type="string", maxLength=1, example="F"),
*   @OA\Property(property="code", type="string", maxLength=10, example="1234567890"),
*   @OA\Property(property="full_name", type="string", example="string"),
*   @OA\Property(property="age", type="integer", example="1")
* )
*
* Class Student
*
*/
class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'last_name',
        'birth_date',
        'gender',
        'code'
    ];

    protected $appends = [
        'full_name',
        'age'
    ];

    // Accessors

    public function getFullNameAttribute(){
        return $this->name . ' ' . $this->last_name;
    }

    public function getAgeAttribute(){
        $birth_date = $this->birth_date;
        $now = Carbon::now();
        $age = $now->diffInYears($birth_date);
        return $age;
    }
}
