<?php

namespace App\Http\Controllers;


use App\Application\Filters\UserFilter;
use App\Application\Sorters\UserSorter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {
    protected $filter;
    protected $sort;

    public function __construct(UserFilter $filter, UserSorter $sort) {
        $this->filter = $filter;
        $this->sort = $sort;
    }

    public function index(Request $request) {
        $query = DB::table('tbl_user');
        $query = $this->filter->applyFilter($query);
        $query = $this->sort->applySort($query);

        $users = $query->paginate(6);

        return view('user.index', compact('users'));
    }

    public function create() {

        return view('user.create');
    }

    public function store(Request $request) {
        if($request->input('action') == 'Add') {
            $requestData = $this->validateUser($request);
            $user = new User();
            $maxUserNumber = DB::table('tbl_user')->max('userNumber');
            $user->userNumber = $maxUserNumber + 1;
            $user->userEmail = $requestData['userEmail'];
            $user->userName = $requestData['userName'];
            $user->userAddress1 = $requestData['userAddress1'];
            $user->userAddress2 = $requestData['userAddress2'];
            $user->userPostCode = $requestData['userPostCode'];
            $user->userCountry = $requestData['userCountry'];
            $user->userBirthDate = $requestData['userBirthDate'];
            if($requestData['userBirthDate']) {
                $user->userBirthDate = str_replace('T', ' ', $requestData['userBirthDate']);
            }
            $user->userStatus = $requestData['userStatus'];
            $user->save();
        }

        return redirect(route('user.index'))->with('completed', 'User has been saved!');
    }


    public function show(User $user) {
        return view('user.show', $user);
    }

    public function edit(User $user) {
        $userBirthDate = $user->userBirthDate;
        $user->userBirthDate = str_replace(' ', 'T', $userBirthDate);

        return view('user.edit');
    }


    public function update(Request $request, User $user) {
        if($request->input('action') == 'Save') {
            $requestData = $this->validateUser($request);
            if($requestData['userBirthDate']) {
                $user->userBirthDate = str_replace('T', ' ', $requestData['userBirthDate']);
            }
            $user->update($requestData);
        }

        return redirect(route('user.index'))->with('completed', 'User has been updated');
    }

    public function destroy(Request $request, User $user) {
        if($user->userNumber) {
            $user->delete();
        } else {
            $ids = json_decode($request->input('hiddenInput'));
            User::whereIn("userNumber", $ids)->delete();
        }

        return redirect('/user')->with('completed', 'User has been deleted');
    }

    private function validateUser(Request $request) {
        return $request->validate([
            'userEmail' => 'required|email|max:30',
            'userName' => 'required|string|max:20',
            'userAddress1' => 'required|string|max:30',
            'userAddress2' => 'nullable|string|max:30',
            'userPostCode' => 'required|zipcode|max:9',
            'userCountry' => 'nullable|string|56',
            'userBirthDate' => 'required|date|before_or_equal: now()',
            'userStatus' => 'required|min:0|max:9',
        ]);
    }
}


