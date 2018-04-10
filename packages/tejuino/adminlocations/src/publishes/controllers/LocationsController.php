<?php

namespace App\Http\Controllers\Admin;

use Tejuino\Adminbase\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Locations\Location;
use Tejuino\Adminbase\Files;

class LocationsController extends AdminController
{

    public function __construct()
    {
        $this->middleware('admin');
        $this->section = 'Locations';
        $this->base .= 'locations/';
    }

    public function index()
    {
        $locations = Location::orderBy('id', 'desc')->get();

        return $this->view('locations.list', [
            'locations' => $locations
        ]);
    }

    public function edit(Request $request, $id, $title)
    {
        $location = Location::find($id);
        if(is_null($location))
        {
            return redirect($this->base);
        }

        if($request->has('title'))
        {
            $location->title = $request->title;
            $location->tags = $request->tags;
            $location->overview = $request->overview;
            $location->article = $request->article;
            $location->save();

            // Update location status
            if(in_array($request->status, ['Activo', 'Inactivo']))
            {
                $location->status = $request->status;
            }

            // Update programming status
            $location->publish_date = substr($request->get('publish_date'), 0, 16);
            $location->programmed = ($request->get('programmed')) ? 1 : 0;

            $location->updatePublishStatus();
            $location->save();
        }

        return $this->view('locations.edit', [
            'location' => $location
        ]);

    }

    public function upload(Request $request)
    {
        $response = [
            'result' => 'error'
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $location = Location::find($request->get('location_id'));

            if (!is_null($location))
            {
                $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
                $filename = $request->file('file')->getClientOriginalName();

                switch ($request->get('type'))
                {
                    case 'image':
                        if (in_array($ext, ['jpg', 'jpeg', 'png']))
                        {
                            $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'locations', 'location_');
                            $location->image = $newFile;
                            $location->save();
                            $response['result'] = 'ok';
                            $response['file'] = $location->image;
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
        $delLocation = Location::find($id);

        if(!is_null($delLocation))
        {
            $delLocation->delete();
        }

        return redirect($this->base);
    }

    public function create(Request $request)
    {
        if($request->get('title'))
        {
            $newLocation = new Location();

            $newLocation->title = $request->title;
            $newLocation->article = '';
            $newLocation->publish_date = \DB::raw('NOW()');

            $newLocation->save();
        }

        return redirect($this->base);
    }

}
