<?php


namespace App\Application\Filters;


use Illuminate\Database\Query\Builder;

class BidFilter extends AbstractFilter
{
    public function applyFilter(Builder $query) {
        if ($this->request->has('filter')) {
            session()->forget('bidAmountFrom');
            session()->forget('bidAmountTo');
            session()->forget('bidUser');

            if ($this->request->filter == 'filter') {
                if ($this->request->bidAmountFrom != "") {
                    $query->where('bidAMount', '>=', $this->request->bidAmountFrom);
                    session()->put('bidAmountFrom', $this->request->bidAmountFrom);
                }
                if ($this->request->bidAmountTo != "") {
                    $query->where('bidAmount', '<=', $this->request->bidAmountTo);
                    session()->put('bidAmountTo', $this->request->bidAmountTo);
                }
                if ($this->request->bidUser != "") {
                    $query->where('bidUser', 'like', '%' . $this->request->bidUser . '%');
                    session()->put('bidUser', $this->request->bidUser);
                }
            }
        } else {
            if (session()->has('bidAmountFrom')) {
                $query->where('bidAmount', '>=', session()->get('bidAmountFrom'));
            }
            if (session()->has('bidAmountTo')) {
                $query->where('bidAmount', '<=', session()->get('bidAmountTo'));
            }
            if (session()->has('bidUser')) {
                $query->where('bidUser', 'like', '%' . session()->get('bidUser') . '%');
            }
        }
        return $query;
    }

}
