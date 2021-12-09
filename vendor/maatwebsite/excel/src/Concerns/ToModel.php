<?php

namespace Maatwebsite\Excel\Concerns;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

interface ToModel
{
    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model(array $row);
}
