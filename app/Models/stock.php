<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    protected $table = "stock";
 
    protected $fillable = ['stock_id','user_id','shelf_id','product_id','product_amount','type','datetime','ending_amount','description'];
}

