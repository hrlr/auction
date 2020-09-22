<?php


namespace App\Application\Filters;


use Illuminate\Database\Query\Builder;

class ItemFilter extends AbstractFilter
{
    public function applyFilter(Builder $query) {
        if ($this->request->has('filter')) {
            session()->forget('itemNumberFrom');
            session()->forget('itemNumberTo');
            session()->forget('itemTitle');
            session()->forget('itemCategory');

            if ($this->request->filter == 'filter') {
                if ($this->request->itemNumberFrom != "") {
                    $query->where('itemNumber', '>=', $this->request->itemNumberFrom);
                    session()->put('itemNumberFrom', $this->request->itemNumberFrom);
                }
                if ($this->request->itemNumberTo != "") {
                    $query->where('itemNumber', '<=', $this->request->itemNumberTo);
                    session()->put('itemNumberTo', $this->request->itemNumberTo);
                }
                if ($this->request->itemTitle != "") {
                    $query->where('itemTitle', 'like', '%' . $this->request->itemTitle . '%');
                    session()->put('itemTitle', $this->request->itemTitle);
                }
            } else {
                if($this->request->filter == 'itemCategory') {
                    $query->where('itemCategory', $this->request->itemCategory);
                    session()->put('itemCategory', $this->request->itemCategory);
                }
            }
        } else {
            if (session()->has('itemNumberFrom')) {
                $query->where('itemNumber', '>=', session()->get('itemNumberFrom'));
            }
            if (session()->has('iitemNumberTo')) {
                $query->where('itemNumber', '<=', session()->get('itemNumberTo'));
            }
            if (session()->has('itemTitle')) {
                $query->where('itemTitle', 'like', '%' . session()->get('itemTitle') . '%');
            }
            if(session()->has('itemCategory')) {
                $query->where('itemCategory', session()->get('itemCategory'));
            }
        }
        return $query;
    }

}
