<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckAuthorization;
use App\Http\Requests\StoreGroupValidator;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = Group::orderBy('name', 'asc');
        $models = $collection->get()->all();

        return view($this->viewName, [
            'models' => $models,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CheckAuthorization::access(__FUNCTION__, Group::class);

        return view('typical_form', [
            'model' => new Group(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGroupValidator $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupValidator $request)
    {
        CheckAuthorization::access(__FUNCTION__, Group::class);

        $validatedData = $request->validated();
        $model = new Group();
        $model->name = $validatedData['name'];
        $result = $model->save();
        $result && $model->courses()->attach($validatedData['course_id']);

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Group::findOrFail($id);
        CheckAuthorization::access(__FUNCTION__, $model);

        return view('typical_form', [
            'model' => $model
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreGroupValidator $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGroupValidator $request)
    {
        $model = Group::findOrFail($request->input('id'));
        CheckAuthorization::access(__FUNCTION__, $model);
        $model->fill($request->except('course_id'));
        $result = $model->save();

        $result && $model->courses()->sync($request->input('course_id'));

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = Group::findOrFail($request->input('group_id'));
        CheckAuthorization::access(__FUNCTION__, $model);
        try {
            $model->courses()->detach();
            $result = $model->delete();
        } catch (\Exception $e) {
            $result = false;
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }
}
