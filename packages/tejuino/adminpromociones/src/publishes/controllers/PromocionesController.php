<?php

namespace App\Http\Controllers\Admin;

use Tejuino\Adminbase\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Promociones\Promocion;
use Tejuino\Adminbase\Files;

class PromocionesController extends AdminController
{

    public function __construct()
    {
        $this->middleware('admin');
        $this->section = 'Promociones';
        $this->base .= 'promociones/';
    }

    public function index()
    {
        $promociones = Promocion::orderBy('id', 'desc')->get();

        return $this->view('promociones.list', [
            'promociones' => $promociones
        ]);
    }

    public function edit(Request $request, $id, $title)
    {
        $promocion = Promocion::find($id);
        if(is_null($promocion))
        {
            return redirect($this->base);
        }

        if($request->has('title'))
        {
            $promocion->title = $request->title;
            $promocion->tags = $request->tags;
            $promocion->overview = $request->overview;
            $promocion->article = $request->article;
            $promocion->save();

            // Update promocion status
            if(in_array($request->status, ['Activo', 'Inactivo']))
            {
                $promocion->status = $request->status;
            }

            // Update programming status
            $promocion->publish_date = substr($request->get('publish_date'), 0, 16);
            $promocion->programmed = ($request->get('programmed')) ? 1 : 0;

            $promocion->updatePublishStatus();
            $promocion->save();
        }

        return $this->view('promociones.edit', [
            'promocion' => $promocion
        ]);

    }

    public function upload(Request $request)
    {
        $response = [
            'result' => 'error'
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $promocion = Promocion::find($request->get('promocion_id'));

            if (!is_null($promocion))
            {
                $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
                $filename = $request->file('file')->getClientOriginalName();

                switch ($request->get('type'))
                {
                    case 'image':
                        if (in_array($ext, ['jpg', 'jpeg', 'png']))
                        {
                            $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'promociones', 'promocion_');
                            $promocion->image = $newFile;
                            $promocion->save();
                            $response['result'] = 'ok';
                            $response['file'] = $promocion->image;
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
        $delPromocion = Promocion::find($id);

        if(!is_null($delPromocion))
        {
            $delPromocion->delete();
        }

        return redirect($this->base);
    }

    public function create(Request $request)
    {
        if($request->get('title'))
        {
            $newPromocion = new Promocion();

            $newPromocion->title = $request->title;
            $newPromocion->article = '';
            $newPromocion->publish_date = \DB::raw('NOW()');

            $newPromocion->save();
        }

        return redirect($this->base);
    }

}
