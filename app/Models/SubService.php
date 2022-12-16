<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubService extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'service_id',
    ];
    public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'subscriptions','user_id','sub_service_id')->withTimestamps ();
    }


}