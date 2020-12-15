<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckAuthorization;
use App\Http\Requests\StoreUserValidator;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($role = null)
    {
        CheckAuthorization::access(__FUNCTION__, User::class);

        $collection = User::orderBy('role', 'desc');
        if (!is_null($role)) {
            $collection->where('role', $role);
        }
        $models = $collection->get();

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
        CheckAuthorization::access(__FUNCTION__, User::class);

        return view('typical_form', [
            'model' => new User(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserValidator $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserValidator $request)
    {
        $model = new User();
        $model->fill($request->except('course_id'));
        $model->password = Hash::make($request->input('password'));
        $result = $model->save();

        $result && $model->courses()->sync($request->input('course_id'));

        try {
            $result = $model->save();
        } catch (\Exception $e) {
            $result = false;
        }

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
        $model = User::findOrFail($id);
        CheckAuthorization::access(__FUNCTION__, $model);

        return view('typical_form', [
            'model' => $model
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserValidator $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserValidator $request)
    {
        $model = User::findOrFail($request->input('id'));
        CheckAuthorization::access(__FUNCTION__, $model);

        $model->fill($request->except('course_id'));
        $model->password = Hash::make($request->input('password'));
        $result = $model->save();

        $result && $model->courses()->sync($request->input('course_id'));

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $model = User::findOrFail(request()->input('user_id'));
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
