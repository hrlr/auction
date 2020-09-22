<?php

namespace App\Http\Controllers;

use App\Application\Filters\CategoryFilter;
use App\Application\Sorters\CategorySorter;
use App\Category;
use App\Helpers\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller {
    protected $filter;
    protected $sort;
    protected $tree;

    public function __construct(CategoryFilter $filter, CategorySorter $sort, Tree $tree) {
        $this->filter = $filter;
        $this->sort = $sort;
        $this->tree = $tree;
    }

    public function index(Request $request) {
        $query = DB::table('tbl_category');

        $categories = $query->get()->toArray();
        $boom = $this->tree->maakBoom($categories);

        $pages = $query->paginate(7);

        return view('category.index', compact('categories', 'pages', 'boom'));
    }

    public function create() {

        return view('category.create');
    }

    public function store(Request $request) {
        if($request->input('action') == 'Add') {
            $requestData = $this->validateCategory($request);
            $category = new Category();
            $maxCategoryNumber = DB::table('tbl_category')->max('categoryNumber');
            $category->categoryNumber = $maxCategoryNumber + 1;
            $category->categoryName = $requestData['categoryName'];
            $category->categoryParent = $requestData['categoryParent'];
            $category->categoryVisibility = false;

            $category->save();
        }

        return redirect(route('category.index'));

    }


    public function show(Request $request, Category $category) {

        return view('category.show', $category);
    }

    public function edit(Category $category) {

        return view('category.edit');
    }

    public function update(Request $request, Category $category) {
        if($request->input('action') == 'Save') {
            $requestData = $this->validateCategory($request);

            $category->update($requestData);
        }

        if($request->input('action') == 'visible') {
            $category->categoryVisible = !$category->categoryVisible;

            $category->update();
        }

        return redirect(route('category.index'));
    }

    public function destroy(Request $request, Category $category) {
        if($category->categoryNumber) {
            $category->delete();
        } else {
            $ids = json_decode($request->input('hiddenInput'));
            Category::whereIn("categoryNumber", $ids)->delete();
        }

        return redirect('/category');
    }

    private function validateCategory(Request $request) {
        return $request->validate([
        ]);
    }

}


