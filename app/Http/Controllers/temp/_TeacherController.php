<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckAuthorization;
use App\Models\Teacher;

class _TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = Teacher::orderBy('name', 'asc');
        $models = $collection->get()->all();

        return view($this->viewName, [
            'models' => $models
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CheckAuthorization::access(__FUNCTION__, Teacher::class);

        return view('typical_form', [
            'model' => new Teacher(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        CheckAuthorization::access(__FUNCTION__, Teacher::class);

        $model = new Teacher();
        $model->name = request()->input('name');
        $model->email = request()->input('email'); ///
        $model->user_id = request()->input('user_id');
        $result = $model->save();

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
        $model = Teacher::findOrFail($id);
        CheckAuthorization::access(__FUNCTION__, $model);

        return view('typical_form', [
            'model' => $model
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $model = Teacher::findOrFail(request()->input('id'));
        CheckAuthorization::access(__FUNCTION__, $model);

        $model->fill(request()->except('course_id')); ///
        $result = $model->save();

        $result && $model->courses()->sync(request()->input('course_id')); ///

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $model = Teacher::findOrFail(request()->input('teacher_id'));
        CheckAuthorization::access(__FUNCTION__, $model);

        try {
            $model->courses()->detach(); ///
            $result = $model->delete();
        } catch (\Exception $e) {
            $result = false;
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }
}
