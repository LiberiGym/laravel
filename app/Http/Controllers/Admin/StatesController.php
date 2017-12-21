<?php

namespace App\Http\Controllers\Admin;

use Tejuino\Adminbase\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\States\State;
use Tejuino\Adminbase\Files;

class StatesController extends AdminController
{

    public function __construct()
    {
        $this->middleware('admin');
        $this->section = 'States';
        $this->base .= 'states/';
    }

    public function index()
    {
        $states = State::orderBy('id', 'desc')->get();

        return $this->view('states.list', [
            'states' => $states
        ]);
    }

    public function edit(Request $request, $id, $title)
    {
        $state = State::find($id);
        if(is_null($state))
        {
            return redirect($this->base);
        }

        if($request->has('title'))
        {
            $state->title = $request->title;
            $state->save();

            // Update state status
            if(in_array($request->status, ['Activo', 'Inactivo']))
            {
                $state->status = $request->status;
            }
            $state->save();
        }

        return $this->view('states.edit', [
            'state' => $state
        ]);

    }


    public function delete(Request $request, $id)
    {
        $delState = State::find($id);

        if(!is_null($delState))
        {
            $delState->delete();
        }

        return redirect($this->base);
    }

    public function create(Request $request)
    {
        if($request->get('title'))
        {
            $newState = new State();

            $newState->title = $request->title;

            $newState->save();
        }

        return redirect($this->base);
    }

}
