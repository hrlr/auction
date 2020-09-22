<?php


namespace App\Application\Sorters;


use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class AbstractSorter
{
    protected $request;
    // protected $model;

    public function __construct(Request $request) {
        $this->request = $request;
        // $this->mode = $model;
    }

    public function applySort(Builder $query) {

    }

}
