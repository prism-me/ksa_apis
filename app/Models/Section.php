<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;


class Section extends Eloquent
{
    use HasFactory , SoftDeletes ;

    protected $table = 'sections';

    protected $guarded = [];



}
