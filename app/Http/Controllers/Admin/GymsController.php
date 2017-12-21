<?php

namespace App\Http\Controllers\Admin;

use Tejuino\Adminbase\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Gyms\Gym;
use Tejuino\Adminbase\Files;

class GymsController extends AdminController
{

    public function __construct()
    {
        $this->middleware('admin');
        $this->section = 'Gyms';
        $this->base .= 'gyms/';
    }

    public function index()
    {
        $gyms = Gym::orderBy('id', 'desc')->get();

        return $this->view('gyms.list', [
            'gyms' => $gyms
        ]);
    }

    public function edit(Request $request, $id, $title)
    {
        $gym = Gym::find($id);
        if(is_null($gym))
        {
            return redirect($this->base);
        }

        if($request->has('title'))
        {
            $gym->title = $request->title;
            $gym->tags = $request->tags;
            $gym->overview = $request->overview;
            $gym->article = $request->article;
            $gym->save();

            // Update gym status
            if(in_array($request->status, ['Activo', 'Inactivo']))
            {
                $gym->status = $request->status;
            }

            // Update programming status
            $gym->publish_date = substr($request->get('publish_date'), 0, 16);
            $gym->programmed = ($request->get('programmed')) ? 1 : 0;

            $gym->updatePublishStatus();
            $gym->save();
        }

        return $this->view('gyms.edit', [
            'gym' => $gym
        ]);

    }

    public function upload(Request $request)
    {
        $response = [
            'result' => 'error'
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $gym = Gym::find($request->get('gym_id'));

            if (!is_null($gym))
            {
                $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
                $filename = $request->file('file')->getClientOriginalName();

                switch ($request->get('type'))
                {
                    case 'image':
                        if (in_array($ext, ['jpg', 'jpeg', 'png']))
                        {
                            $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'gyms', 'gym_');
                            $gym->image = $newFile;
                            $gym->save();
                            $response['result'] = 'ok';
                            $response['file'] = $gym->image;
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
        $delGym = Gym::find($id);

        if(!is_null($delGym))
        {
            $delGym->delete();
        }

        return redirect($this->base);
    }

    public function create(Request $request)
    {
        if($request->get('title'))
        {
            $newGym = new Gym();

            $newGym->title = $request->title;
            $newGym->article = '';
            $newGym->publish_date = \DB::raw('NOW()');

            $newGym->save();
        }

        return redirect($this->base);
    }

}
