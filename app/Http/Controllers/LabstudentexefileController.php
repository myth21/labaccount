<?php

namespace App\Http\Controllers;

use App\Models\LabStudentExe;
use App\Models\LabStudentExeFile;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;

class LabstudentexefileController extends Controller
{
    public function download($id)
    {
        /** @var \App\Models\LabStudentExeFile $file */
        $file = LabStudentExeFile::findOrFail(Helper::getAbsInt($id));

        return response()->download($file->getRootStoreFileName(), $file->name);
    }

    public function handleUploadFiles(LabStudentExe $model)
    {
        $result = false;

        $files = [];
        foreach (request()->file('files') as $file) {

            /** @var \Illuminate\Http\UploadedFile $file */
            $result = $file->store(LabStudentExeFile::getStoreDirName($model));
            if ($result) {
                /** @var \Illuminate\Http\UploadedFile $file */
                $labExeUserFile = new LabStudentExeFile();
                $labExeUserFile->setAttribute('lab_student_exe_id', $model->id);
                $labExeUserFile->setAttribute('hash_name', $file->hashName());
                $labExeUserFile->setAttribute('name', $file->getClientOriginalName());
                $files[] = $labExeUserFile->attributesToArray();
            }
        }
        if ($result) {
            $result = LabStudentExeFile::insert($files);
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        /** @var \App\Models\LabStudentExeFile $labUserFile */
        $labStudentExeFile = LabStudentExeFile::findOrFail(request()->input('id'));

        try {
            $result = $labStudentExeFile->delete();
        } catch (\Exception $e) {
            $result = false;
        }

        if ($result) {
            $pathToFile = $labStudentExeFile->getStoreFileName($labStudentExeFile->labStudentExe);
            if (Storage::exists($pathToFile)) {
                $result = Storage::delete($pathToFile);
            }
        }

        if (request()->ajax()) {
            $message = $result ? __('SuccessOperation') : __('FailedOperation');
            return response()->json([
                'message' => $message
            ]);
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }
}
