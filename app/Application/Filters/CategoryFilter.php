<?php


namespace App\Application\Filters;


use Illuminate\Database\Query\Builder;

class CategoryFilter extends AbstractFilter
{
    public function applyFilter(Builder $query)
    {
        if ($this->request->has('filter')) {
            session()->forget('categoryNumberFrom');
            session()->forget('categoryNumberTo');
            session()->forget('categoryName');

            if ($this->request->filter == 'filter') {
                if ($this->request->categoryNumberFrom != "") {
                    $query->where('categoryNumber', '>=', $this->request->categoryNumberFrom);
                    session()->put('categoryNumberFrom', $this->request->categoryNumberFrom);
                }
                if ($this->request->categoryNumberTo != "") {
                    $query->where('categoryNumber', '<=', $this->request->categoryNumberTo);
                    session()->put('categoryNumberTo', $this->request->categoryNumberTo);
                }
                if ($this->request->categoryName != "") {
                    $query->where('categoryName', 'like', '%' . $this->request->categoryName . '%');
                    session()->put('categoryName', $this->request->categoryName);
                }
            }
        } else {
                if (session()->has('categoryNumberFrom')) {
                    $query->where('categoryNumber', '>=', session()->get('categoryNumberFrom'));
                }
                if (session()->has('categoryNumberTo')) {
                    $query->where('categoryNumber', '<=', session()->get('categoryNumberTo'));
                }
                if (session()->has('categoryName')) {
                    $query->where('categoryName', 'like', '%' . session()->get('categoryName') . '%');
                }
            }
        return $query;
    }
}
