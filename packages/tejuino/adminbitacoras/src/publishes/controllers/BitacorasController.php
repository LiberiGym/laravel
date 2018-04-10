<?php

namespace App\Http\Controllers\Admin;

use Tejuino\Adminbase\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Bitacoras\Bitacora;
use Tejuino\Adminbase\Files;

class BitacorasController extends AdminController
{

    public function __construct()
    {
        $this->middleware('admin');
        $this->section = 'Bitacoras';
        $this->base .= 'bitacoras/';
    }

    public function index()
    {
        $bitacoras = Bitacora::orderBy('id', 'desc')->get();

        return $this->view('bitacoras.list', [
            'bitacoras' => $bitacoras
        ]);
    }

    public function edit(Request $request, $id, $title)
    {
        $bitacora = Bitacora::find($id);
        if(is_null($bitacora))
        {
            return redirect($this->base);
        }

        if($request->has('title'))
        {
            $bitacora->title = $request->title;
            $bitacora->tags = $request->tags;
            $bitacora->overview = $request->overview;
            $bitacora->article = $request->article;
            $bitacora->save();

            // Update bitacora status
            if(in_array($request->status, ['Activo', 'Inactivo']))
            {
                $bitacora->status = $request->status;
            }

            // Update programming status
            $bitacora->publish_date = substr($request->get('publish_date'), 0, 16);
            $bitacora->programmed = ($request->get('programmed')) ? 1 : 0;

            $bitacora->updatePublishStatus();
            $bitacora->save();
        }

        return $this->view('bitacoras.edit', [
            'bitacora' => $bitacora
        ]);

    }

    public function upload(Request $request)
    {
        $response = [
            'result' => 'error'
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $bitacora = Bitacora::find($request->get('bitacora_id'));

            if (!is_null($bitacora))
            {
                $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
                $filename = $request->file('file')->getClientOriginalName();

                switch ($request->get('type'))
                {
                    case 'image':
                        if (in_array($ext, ['jpg', 'jpeg', 'png']))
                        {
                            $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'bitacoras', 'bitacora_');
                            $bitacora->image = $newFile;
                            $bitacora->save();
                            $response['result'] = 'ok';
                            $response['file'] = $bitacora->image;
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
        $delBitacora = Bitacora::find($id);

        if(!is_null($delBitacora))
        {
            $delBitacora->delete();
        }

        return redirect($this->base);
    }

    public function create(Request $request)
    {
        if($request->get('title'))
        {
            $newBitacora = new Bitacora();

            $newBitacora->title = $request->title;
            $newBitacora->article = '';
            $newBitacora->publish_date = \DB::raw('NOW()');

            $newBitacora->save();
        }

        return redirect($this->base);
    }

}
