<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckAuthorization;
use App\Models\Course;
use App\Http\Requests\StoreCourseValidator;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('typical_form', [
            'model' => new Course()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCourseValidator $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseValidator $request)
    {
        CheckAuthorization::access(__FUNCTION__, Course::class);
        $validatedData = $request->validated();
        $model = Course::create([
            'name' => $validatedData['name']
        ]);
        $result = $model->exists ? true : false;

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id int
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Course::findOrFail( Helper::getAbsInt($id) );
        CheckAuthorization::access(__FUNCTION__, $model);

        return view('typical_form', [
            'model' => $model
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreCourseValidator $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCourseValidator $request)
    {
        $validatedData = $request->validated();
        $model = Course::findOrFail($request->input('id'));
        CheckAuthorization::access(__FUNCTION__, $model);
        $result = $model->update([
            'name' => $validatedData['name']
        ]);

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = Helper::getAbsInt(request()->input('course_id'));
        $model = Course::findOrFail($id);
        CheckAuthorization::access(__FUNCTION__, $model);
        try {
            $result = $model->delete();
        } catch (\Exception $e) {
            $result = false;
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }
}
