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
            $category->tags = $request->tags;
            $category->overview = $request->overview;
            $category->article = $request->article;
            $category->save();

            // Update category status
            if(in_array($request->status, ['Activo', 'Inactivo']))
            {
                $category->status = $request->status;
            }

            // Update programming status
            $category->publish_date = substr($request->get('publish_date'), 0, 16);
            $category->programmed = ($request->get('programmed')) ? 1 : 0;

            $category->updatePublishStatus();
            $category->save();
        }

        return $this->view('categories.edit', [
            'category' => $category
        ]);

    }

    public function upload(Request $request)
    {
        $response = [
            'result' => 'error'
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $category = Category::find($request->get('category_id'));

            if (!is_null($category))
            {
                $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
                $filename = $request->file('file')->getClientOriginalName();

                switch ($request->get('type'))
                {
                    case 'image':
                        if (in_array($ext, ['jpg', 'jpeg', 'png']))
                        {
                            $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'categories', 'category_');
                            $category->image = $newFile;
                            $category->save();
                            $response['result'] = 'ok';
                            $response['file'] = $category->image;
                        }
                        else
                        {
                            $response['result'] = 'error_type';
                            $response['message'] = 'Only jpg and png images allowed';
                        }
                        break;
                }
            }
            else
            {
                $response['result'] = 'error_article';
            }
        }
        return $response;
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
            $newCategory->article = '';
            $newCategory->publish_date = \DB::raw('NOW()');

            $newCategory->save();
        }

        return redirect($this->base);
    }

}
