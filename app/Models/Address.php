<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Eloquent
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $collection = 'addresses';
    protected $primaryKey ='_id';
    protected $table = 'addresses';

    public function getRouteKeyName(){
        return 'route';
    }
}
