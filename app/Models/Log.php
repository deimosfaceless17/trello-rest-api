<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Log extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = ['date_time', 'user_id', 'operation', 'table_name', 'record_id', 'modifications'];
}
