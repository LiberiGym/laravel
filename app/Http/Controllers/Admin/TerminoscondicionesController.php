<?php

namespace App\Http\Controllers\Admin;

use Tejuino\Adminbase\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Terminoscondiciones\Terminocondicion;
use Tejuino\Adminbase\Files;

class TerminoscondicionesController extends AdminController
{

    public function __construct()
    {
        $this->middleware('admin');
        $this->section = 'Terminoscondiciones';
        $this->base .= 'terminoscondiciones/';
    }

    public function index()
    {
        $terminoscondiciones = Terminocondicion::orderBy('id', 'desc')->get();

        return $this->view('terminoscondiciones.list', [
            'terminoscondiciones' => $terminoscondiciones
        ]);
    }

    public function edit(Request $request, $id, $title)
    {
        $terminocondicion = Terminocondicion::find($id);
        if(is_null($terminocondicion))
        {
            return redirect($this->base);
        }

        if($request->has('title'))
        {
            $terminocondicion->title = $request->title;
            $terminocondicion->tags = $request->tags;
            $terminocondicion->overview = $request->overview;
            $terminocondicion->article = $request->article;
            $terminocondicion->save();

            // Update terminocondicion status
            if(in_array($request->status, ['Activo', 'Inactivo']))
            {
                $terminocondicion->status = $request->status;
            }

            // Update programming status
            $terminocondicion->publish_date = substr($request->get('publish_date'), 0, 16);
            $terminocondicion->programmed = ($request->get('programmed')) ? 1 : 0;

            $terminocondicion->updatePublishStatus();
            $terminocondicion->save();
        }

        return $this->view('terminoscondiciones.edit', [
            'terminocondicion' => $terminocondicion
        ]);

    }

    public function upload(Request $request)
    {
        $response = [
            'result' => 'error'
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $terminocondicion = Terminocondicion::find($request->get('terminocondicion_id'));

            if (!is_null($terminocondicion))
            {
                $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
                $filename = $request->file('file')->getClientOriginalName();

                switch ($request->get('type'))
                {
                    case 'image':
                        if (in_array($ext, ['jpg', 'jpeg', 'png']))
                        {
                            $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'terminoscondiciones', 'terminocondicion_');
                            $terminocondicion->image = $newFile;
                            $terminocondicion->save();
                            $response['result'] = 'ok';
                            $response['file'] = $terminocondicion->image;
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
        $delTerminocondicion = Terminocondicion::find($id);

        if(!is_null($delTerminocondicion))
        {
            $delTerminocondicion->delete();
        }

        return redirect($this->base);
    }

    public function create(Request $request)
    {
        if($request->get('title'))
        {
            $newTerminocondicion = new Terminocondicion();

            $newTerminocondicion->title = $request->title;
            $newTerminocondicion->article = '';
            $newTerminocondicion->publish_date = \DB::raw('NOW()');

            $newTerminocondicion->save();
        }

        return redirect($this->base);
    }

}
