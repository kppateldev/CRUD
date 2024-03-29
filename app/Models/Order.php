<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = ['user_id', 'grand_total'];

    public function UserData(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}