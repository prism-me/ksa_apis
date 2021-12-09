<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
class Upload extends Eloquent
{
    use HasFactory ;
    use SoftDeletes;

    protected $table = 'uploads';

    protected $primaryKey = '_id';

    protected $guarded = [];

    // public function getRouteKeyName()
    // {
    //     return '_id';
    // }
    // public function uploads(){
    //     return $this->hasMany(Media::class ,)
    // }

}
