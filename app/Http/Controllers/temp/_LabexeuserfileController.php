<?php

namespace App\Http\Controllers;

use App\Models\LabStudent;
use App\Models\LabStudentExeFile;
use App\Models\LabUserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;

class _LabexeuserfileController extends Controller
{
    public function download($id)
    {
        /** @var \App\Models\LabUserFile $file */
        $file = LabUserFile::findOrFail(Helper::getAbsInt($id));
        return response()->download($file->getRootStoreFileName(), $file->name);
    }

    public function handleUploadFiles(Request $request, LabStudent $model)
    {
        $result = false;

        $files = [];
        foreach ($request->file('files') as $file) {

            /** @var \Illuminate\Http\UploadedFile $file */
            $result = $file->storeAs(LabUserFile::getStoreDirName($model), $file->getClientOriginalName());
            if ($result) {
                /** @var \Illuminate\Http\UploadedFile $file */
                $labExeUserFile = new LabUserFile();
                $labExeUserFile->setAttribute('lab_student_id', $model->id);
                $labExeUserFile->setAttribute('hash_name', $file->hashName());
                $labExeUserFile->setAttribute('name', $file->getClientOriginalName());

                $file->store(LabUserFile::getStoreDirName($model));

                $files[] = $labExeUserFile->attributesToArray();
            }
        }
        if ($result) {
            $result = LabUserFile::insert($files);
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
        /** @var \App\Models\LabUserFile $labUserFile */
        $labUserFile = LabUserFile::findOrFail(request()->input('id'));
        /** @var \App\Models\LabUserFile $labUserFile */
        //$labUserFile = LabStudentExeFile::File::findOrFail(request()->input('id'));

        try {
            $result = $labUserFile->delete();
        } catch (\Exception $e) {
            $result = false;
        }

        if ($result) {
            $pathToFile = $labUserFile->getStoreFileName($labUserFile->labStudent);
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
