<?php


namespace App\Application\Filters;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

abstract class AbstractFilter
{
    protected $request;
    // protected $model;

    public function __construct(Request $request) {
        $this->request = $request;
        // $this->mode = $model;
    }

    public function applyFilter(Builder $query) {

    }

}
