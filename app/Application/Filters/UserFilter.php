<?php


namespace App\Application\Filters;


use Illuminate\Database\Query\Builder;

class UserFilter extends AbstractFilter
{
    public function applyFilter(Builder $query)
    {
        if ($this->request->has('filter')) {
            session()->forget('userNumberFrom');
            session()->forget('userNumberTo');
            session()->forget('userName');

            if ($this->request->filter == 'filter') {
                if ($this->request->userNumberFrom != "") {
                    $query->where('userNumber', '>=', $this->request->userNumberFrom);
                    session()->put('userNumberFrom', $this->request->userNumberFrom);
                }
                if ($this->request->userNumberTo != "") {
                    $query->where('userNumber', '<=', $this->request->userNumberTo);
                    session()->put('userNumberTo', $this->request->userNumberTo);
                }
                if ($this->request->userName != "") {
                    $query->where('userName', 'like', '%' . $this->request->userName . '%');
                    session()->put('userName', $this->request->userName);
                }
            }
        } else {
            if (session()->has('userNumberFrom')) {
                $query->where('userNumber', '>=', session()->get('userNumberFrom'));
            }
            if (session()->has('userNumberTo')) {
                $query->where('userNumber', '<=', session()->get('userNumberTo'));
            }
            if (session()->has('userName')) {
                $query->where('userName', 'like', '%' . session()->get('userName') . '%');
            }
        }
        return $query;
    }
}
