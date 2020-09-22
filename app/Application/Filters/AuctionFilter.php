<?php


namespace App\Application\Filters;


use Illuminate\Database\Query\Builder;

class AuctionFilter extends AbstractFilter
{
    public function applyFilter(Builder $query) {
        if ($this->request->has('filter')) {
            session()->forget('auctionNumberFrom');
            session()->forget('auctionNumberTo');
            session()->forget('auctionTitle');
            session()->forget('user_userNumber');

            if ($this->request->filter == 'filter') {
                if ($this->request->auctionNumberFrom != "") {
                    $query->where('auctionNumber', '>=', $this->request->auctionNumberFrom);
                    session()->put('auctionNumberFrom', $this->request->auctionNumberFrom);
                }
                if ($this->request->auctionNumberTo != "") {
                    $query->where('auctionNumber', '<=', $this->request->auctionNumberTo);
                    session()->put('auctionNumberTo', $this->request->auctionNumberTo);
                }
                if ($this->request->auctionTitle != "") {
                    $query->where('auctionTitle', 'like', '%' . $this->request->auctionTitle . '%');
                    session()->put('auctionTitle', $this->request->auctionTitle);
                }
            } else {
                if($this->request->filter == 'user') {
                    $query->where('auctionSeller', $this->request->user_userNumber);
                    session()->put('user_userNumber', $this->request->user_userNumber);
                }
            }
        } else {
            if (session()->has('auctionNumberFrom')) {
                $query->where('auctionNumber', '>=', session()->get('auctionNumberFrom'));
            }
            if (session()->has('auctionNumberTo')) {
                $query->where('auctionNumber', '<=', session()->get('auctionNumberTo'));
            }
            if (session()->has('auctionTitle')) {
                $query->where('auctionTitle', 'like', '%' . session()->get('auctionTitle') . '%');
            }
            if(session()->has('user_userNumber')) {
                $query->where('auctionSeller', session()->get('user_userNumber'));
            }
        }
        return $query;
    }

}
