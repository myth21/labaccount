<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckAuthorization;
use App\Models\Group;
use App\Models\Student;

class StudentController extends Controller
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
            'modelsWithout' => Student::whereDoesntHave('group')->get()->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CheckAuthorization::access(__FUNCTION__, Student::class);

        return view('typical_form', [
            'model' => new Student(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        CheckAuthorization::access(__FUNCTION__, Student::class);

        $model = new Student();
        $model->name = request()->input('name');
        $model->group_id = request()->input('group_id');
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
        $model = Student::findOrFail($id);
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
        $model = Student::findOrFail(request()->input('id'));
        CheckAuthorization::access(__FUNCTION__, $model);

        $model->fill(request()->post());
        $result = $model->save();

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $model = Student::findOrFail(request()->input('student_id'));
        CheckAuthorization::access(__FUNCTION__, $model);

        try {
            $result = $model->delete();
        } catch (\Exception $e) {
            $result = false;
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }
}
