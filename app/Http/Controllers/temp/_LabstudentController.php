<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreLabStudentValidator;
use App\Models\Lab;
use App\Models\LabStudent;
use Illuminate\Support\Facades\Auth;

class _LabstudentController extends Controller
{
    public function index()
    {
        /** @var \App\User $user */
        $user = Auth::user();

        return view($this->viewName, [
            'models' => $user->getCourses()
        ]);
    }

    public function create()
    {
        $lab = Lab::findOrFail(request()->input('id'));

        return view($this->ctrlName.'.form', [
            'model' => new LabStudent(),
            'lab' => $lab,
        ]);
    }

    public function store(StoreLabStudentValidator $request)
    {
        $model = LabStudent::create([
            'lab_id' => Helper::getAbsInt($request->input('id')),
            'student' => json_encode(['ids' => Helper::getAbsInt($request->input('student_id'))]),
            'user_id' => Auth::id(),
        ]);
        $result = $model->exists ? true : false;

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    public function edit($id)
    {
        $model = LabStudent::findOrFail($id);

        return view($this->ctrlName.'.form', [
            'model' => $model,
            'lab' => $model->lab
        ]);
    }

    public function update(StoreLabStudentValidator $request)
    {
        /** @var \App\Models\LabStudent $model */
        $model = LabStudent::findOrFail($request->input('id'));
        $model->student = json_encode(['ids' => Helper::getAbsInt($request->input('student_id'))]);
        $model->user_id = Auth::id();
        $result = $model->save();

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    public function destroy()
    {
        /** @var \App\Models\LabStudent $model */
        $model = LabStudent::findOrFail(request()->input('labstudent_id'));
        try {
            $result = $model->delete();
        } catch (\Exception $e) {

            $result = false;
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }
}
