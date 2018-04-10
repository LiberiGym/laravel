<?php

namespace App\Http\Controllers\Admin;

use Tejuino\Adminbase\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Locations\Location;
use Tejuino\Adminbase\Files;
use App\Models\States\State;

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
        $locations = Location::with('states')->orderBy('id', 'desc')->get();
        $states = State::orderBy('title', 'asc')->get();

        return $this->view('locations.list', [
            'locations' => $locations,
            'states' => $states
        ]);
    }

    public function edit(Request $request, $id, $title)
    {
        $location = Location::find($id);
        $states = State::orderBy('title', 'asc')->get();
        if(is_null($location))
        {
            return redirect($this->base);
        }

        if($request->has('title'))
        {
            $location->title = $request->title;
            $location->state_id = $request->state_id;
            $location->save();

            // Update location status
            if(in_array($request->status, ['Activo', 'Inactivo']))
            {
                $location->status = $request->status;
            }
            $location->save();
        }

        return $this->view('locations.edit', [
            'location' => $location,
            'states' => $states
        ]);

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
            $newLocation->state_id = $request->state_id;

            $newLocation->save();
        }

        return redirect($this->base);
    }

}
