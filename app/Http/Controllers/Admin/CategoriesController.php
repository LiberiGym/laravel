<?php

namespace App\Http\Controllers\Admin;

use Tejuino\Adminbase\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Categories\Category;
use Tejuino\Adminbase\Files;

class CategoriesController extends AdminController
{

    public function __construct()
    {
        $this->middleware('admin');
        $this->section = 'Categories';
        $this->base .= 'categories/';
    }

    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return $this->view('categories.list', [
            'categories' => $categories
        ]);
    }

    public function edit(Request $request, $id, $title)
    {
        $category = Category::find($id);
        if(is_null($category))
        {
            return redirect($this->base);
        }

        if($request->has('title'))
        {
            $category->title = $request->title;
            $category->save();

            // Update category status
            if(in_array($request->status, ['Activo', 'Inactivo']))
            {
                $category->status = $request->status;
            }
            $category->save();
        }

        return $this->view('categories.edit', [
            'category' => $category
        ]);

    }

    public function delete(Request $request, $id)
    {
        $delCategory = Category::find($id);

        if(!is_null($delCategory))
        {
            $delCategory->delete();
        }

        return redirect($this->base);
    }

    public function create(Request $request)
    {
        if($request->get('title'))
        {
            $newCategory = new Category();

            $newCategory->title = $request->title;

            $newCategory->save();
        }

        return redirect($this->base);
    }

}
