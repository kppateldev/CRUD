<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = ['order_id', 'name', 'qty', 'amount', 'total'];

    public function UserData(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}