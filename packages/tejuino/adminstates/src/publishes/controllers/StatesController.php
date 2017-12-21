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
            $state->tags = $request->tags;
            $state->overview = $request->overview;
            $state->article = $request->article;
            $state->save();

            // Update state status
            if(in_array($request->status, ['Activo', 'Inactivo']))
            {
                $state->status = $request->status;
            }

            // Update programming status
            $state->publish_date = substr($request->get('publish_date'), 0, 16);
            $state->programmed = ($request->get('programmed')) ? 1 : 0;

            $state->updatePublishStatus();
            $state->save();
        }

        return $this->view('states.edit', [
            'state' => $state
        ]);

    }

    public function upload(Request $request)
    {
        $response = [
            'result' => 'error'
        ];

        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $state = State::find($request->get('state_id'));

            if (!is_null($state))
            {
                $ext = strtolower(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
                $filename = $request->file('file')->getClientOriginalName();

                switch ($request->get('type'))
                {
                    case 'image':
                        if (in_array($ext, ['jpg', 'jpeg', 'png']))
                        {
                            $newFile = Files::save($request->file('file')->getRealPath(), $ext, 'states', 'state_');
                            $state->image = $newFile;
                            $state->save();
                            $response['result'] = 'ok';
                            $response['file'] = $state->image;
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
            $newState->article = '';
            $newState->publish_date = \DB::raw('NOW()');

            $newState->save();
        }

        return redirect($this->base);
    }

}
