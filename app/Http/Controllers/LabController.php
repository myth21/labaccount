<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\LabFile;
use App\Http\Requests\StoreLabValidator;
use App\Models\Lab;

class LabController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var \App\User $user */
        $user = Auth::user();

        return view($this->viewName, [
            'models' => $user->getCourses()
        ]);
    }

    public function _item(Request $request)
    {
        if ($request->ajax()) {
            return view($this->viewName, [
                'model' => Lab::find($request->get('onModelId'))
            ]);
        }
        return abort(400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CheckAuthorization::access(__FUNCTION__, Lab::class);

        return view('typical_form', [
            'model' => new Lab(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLabValidator $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLabValidator $request)
    {
        CheckAuthorization::access(__FUNCTION__, Lab::class);

        $validatedData = $request->validated();
        $model = Lab::create([
            'course_id' => $validatedData['course_id'],
            'number' => $validatedData['number'],
            'name' => $validatedData['name'],
            'task' => $validatedData['task']
        ]);
        $result = $model->exists ? true : false;

        if ($result) {
            if ($request->has('files') && is_array($request->file('files'))) {
                $result = app(LabfileController::class)->handleUploadFiles($request, $model->id);
            }
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id int
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view($this->viewName, [
            'model' => Lab::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Lab::findOrFail($id);
        CheckAuthorization::access(__FUNCTION__, $model);

        return view('typical_form', [
            'model' => $model
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreLabValidator $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLabValidator $request)
    {
        $model = Lab::findOrFail($request->input('id'));
        CheckAuthorization::access(__FUNCTION__, $model);

        $model->fill($request->post());
        $result = $model->save();

        if ($result) {
            if ($request->has('files') && is_array($request->file('files'))) {
                $result = app(LabfileController::class)->handleUploadFiles($request, $model->id);
            }
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        /** @var \App\Models\Lab $model */
        $model = Lab::findOrFail(request()->input('lab_id'));
        CheckAuthorization::access(__FUNCTION__, $model);

        try {
            $result = $model->delete();
        } catch (\Exception $e) {
            $result = false;
        }

        if (Storage::exists(LabFile::getStoreDirName($model->id))) {
            $result = Storage::deleteDirectory(LabFile::getStoreDirName($model->id));
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }
}
