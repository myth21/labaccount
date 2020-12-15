<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreLabExeUserValidator;
use App\Models\LabStudent;
use App\Models\LabStudentExe;
use App\Models\LabStudentExeFile;
use App\Models\LabUserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class _LabstudentexeController extends Controller
{
    public function index()
    {
        /** @var \App\User $user */
        $user = Auth::user();

        return view($this->viewName, [
            'models' => $user->getCourses()
        ]);
    }

    public function show($id)
    {
        return view($this->ctrlName.'.form', [
            'model' => LabStudentExe::findOrFail($id),
            'onShow' => true,
        ]);
    }

    public function create()
    {
        $labStudent = LabStudent::findOrFail(request()->input('id'));

        return view($this->ctrlName.'.form', [
            'model' => new LabStudentExe(),
            'labStudent' => $labStudent,
        ]);
    }

    public function store() ///StoreLabExeUserValidator $request
    {
        $request = request();

        $model = LabStudentExe::create([
            'lab_student_id' => Helper::getAbsInt($request->input('id')),
            'comment' => $request->input('comment'),
            'status' => $request->input('status'),
        ]);
        $result = $model->exists ? true : false;

        if ($result) {
            if ($request->has('files') && is_array($request->file('files'))) {
                $result = app(LabstudentexefileController::class)->handleUploadFiles($model);
            }
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    public function edit($id)
    {
        return view($this->ctrlName.'.form', [
            'model' => LabStudentExe::findOrFail($id)
        ]);
    }

    public function update() ///StoreLabExeUserValidator $request
    {
        $model = LabStudentExe::findOrFail(request()->input('id'));
        $model->comment = request()->input('comment');
        $model->status = request()->input('status');

        $result = $model->save();

        if ($result) {
            if (request()->has('files') && is_array(request()->file('files'))) {
                $result = app(LabstudentexefileController::class)->handleUploadFiles($model);
            }
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    public function destroy()
    {
        $model = LabStudentExe::findOrFail(request()->input('labstudentexe_id'));
        try {
            $model->labStudentExeFiles()->delete();
            $result = $model->delete();
        } catch (\Exception $e) {

            $result = false;
        }

        $pathToDir = LabStudentExeFile::getStoreDirName($model);
        if ($result && Storage::exists($pathToDir)) {
            $result = Storage::deleteDirectory($pathToDir);
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

}