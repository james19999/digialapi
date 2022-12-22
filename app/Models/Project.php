<?php

namespace App\Models;

use App\Models\Costumer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [

        'name',
        'description',
        'costumer_id',
        'date_start',
        'date_end',
        'status',
    ];

    public function costumer() {

        return $this->belongsTo(Costumer::class,'costumer_id');
    }

    public function usersdevs() {
        return $this->belongsToMany(User::class,'project_user_devs','project_id');
    }
}