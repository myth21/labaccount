<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Middleware\CheckAuthorization;
use App\Http\Requests\StoreLabStudentExeValidator;
use App\Models\Lab;
use App\Models\LabStudent;
use App\Models\LabStudentExe;
use App\Models\LabStudentExeFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LabstudentexeController extends Controller
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
        $model = LabStudentExe::findOrFail($id);
        CheckAuthorization::access(__FUNCTION__, $model);

        return view($this->ctrlName.'.form', [
            'model' => $model,
            'labStudent' => $model->labStudent,
            'lab' => $model->labStudent->lab,
            'onShow' => true,
            'formAction' => '',
        ]);
    }

    public function create()
    {
        $lab = Lab::findOrFail(request()->input('id'));

        return view($this->ctrlName.'.form', [
            'model' => new LabStudentExe(),
            'labStudent' => new LabStudent(),
            'lab' => $lab,
            'formAction' => route($this->ctrlName.'.store'),
        ]);
    }

    public function store(StoreLabStudentExeValidator $request)
    {
        $labStudent = LabStudent::create([
            'lab_id' => Helper::getAbsInt($request->input('lab_id')),
            'student' => json_encode(['ids' => Helper::getAbsInt($request->input('student_id'))]),
            'user_id' => Auth::id(),
        ]);
        $result = $labStudent->exists ? true : false;

        if ($result) {
             $labStudentExe = LabStudentExe::create([
                'lab_student_id' => $labStudent->id,
                'comment' => $request->input('comment'),
                'status' => $request->input('status'),
            ]);
            $result = $labStudentExe->exists ? true : false;
            if ($result) {
                if ($request->has('files') && is_array($request->file('files'))) {
                    $result = app(LabstudentexefileController::class)->handleUploadFiles($labStudentExe);
                }
            }
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    public function add($id)
    {
        $labStudent = LabStudent::findOrFail( Helper::getAbsInt($id) );

        return view($this->ctrlName.'.form', [
            'model' => new LabStudentExe(),
            'labStudent' => $labStudent,
            'lab' => $labStudent->lab,
            'formAction' => route($this->ctrlName.'.save'),
            'onAdd' => true,
        ]);
    }

    public function save(StoreLabStudentExeValidator $request)
    {
        $labStudent = LabStudent::findOrFail($request->input('lab_student_id'));
        $labStudent->student = json_encode(['ids' => Helper::getAbsInt($request->input('student_id'))]);
        $labStudent->user_id = Auth::id();
        $result = $labStudent->save();
        if ($result) {
            $labStudentExe = LabStudentExe::create([
                'lab_student_id' => $labStudent->id,
                'comment' => $request->input('comment'),
                'status' => $request->input('status'),
            ]);
            $result = $labStudentExe->exists ? true : false;
            if ($result) {
                if ($request->has('files') && is_array($request->file('files'))) {
                    $result = app(LabstudentexefileController::class)->handleUploadFiles($labStudentExe);
                }
            }

        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }

    public function edit($id)
    {
        $model = LabStudentExe::findOrFail($id);
        CheckAuthorization::access(__FUNCTION__, $model);

        return view($this->ctrlName.'.form', [
            'model' => $model,
            'labStudent' => $model->labStudent,
            'lab' => $model->labStudent->lab,
            'formAction' => route($this->ctrlName.'.update'),
        ]);
    }

    public function update(StoreLabStudentExeValidator $request)
    {
        $model = LabStudentExe::findOrFail($request->input('id'));
        CheckAuthorization::access(__FUNCTION__, $model);
        
        $labStudent = LabStudent::findOrFail($request->input('lab_student_id'));
        $labStudent->student = json_encode(['ids' => Helper::getAbsInt($request->input('student_id'))]);
        $labStudent->user_id = Auth::id();
        $result = $labStudent->save();
        if ($result) {
            $model->comment = $request->input('comment');
            $model->status = $request->input('status');
            $result = $model->save();
            if ($result && $request->has('files') && is_array($request->file('files'))) {
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
            $exists = LabStudentExe::where('lab_student_id', $model->lab_student_id)->exists();
            if ( ! $exists){
                $result = $result && $model->labStudent()->delete();
            }

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