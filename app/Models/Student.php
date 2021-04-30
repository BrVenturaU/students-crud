<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
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
