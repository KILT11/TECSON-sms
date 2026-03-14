<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scholarship extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'slots',
        'deadline',
        'status',
        'requirements',
    ];

    protected $casts = [
        'requirements' => 'array',
        'deadline'     => 'date',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}