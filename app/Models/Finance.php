<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $connection = 'mysql';


    protected $table      = 'finances';
    protected $primaryKey = 'id';
    public $incrementing  = true;

    public $timestamps = true;

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';


}
