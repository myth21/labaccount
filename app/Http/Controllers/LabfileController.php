<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\LabFile;
use App\Helpers\Helper;

class LabfileController extends Controller
{
    public function download($id)
    {
        /** @var \App\Models\LabFile $labFile */
        $labFile = LabFile::findOrFail(Helper::getAbsInt($id));

        return response()->download($labFile->getRootStoreFileName());
    }

    public function handleUploadFiles(Request $request, $modelId)
    {
        $result = false;

        $files = [];
        foreach ($request->file('files') as $file) {

            /** @var \Illuminate\Http\UploadedFile $file */
            $result = $file->storeAs(LabFile::getStoreDirName($modelId), $file->getClientOriginalName());
            if ($result) {
                $labFile = new LabFile();
                $labFile->setAttribute('lab_id', $modelId);
                $labFile->setAttribute('name', $file->getClientOriginalName());
                $files[] = $labFile->attributesToArray();
            }
        }
        if ($result) {
            $result = LabFile::insert($files);
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        /** @var $labFile \App\Models\LabFile */
        $labFile = LabFile::findOrFail($request->input('id'));

        try {
            $result = $labFile->delete();
        } catch (\Exception $e) {
            $result = false;
        }

        if ($result) {
            $pathToFile = $labFile->getStoreFileName();
            if (Storage::exists($pathToFile)) {
                $result = Storage::delete($pathToFile);
            }
        }

        if ($request->ajax()) {
            $message = $result ? __('SuccessOperation') : __('FailedOperation');
            return response()->json([
                'message' => $message
            ]);
        }

        return $this->getRedirectWith($result, $this->redirectToUrl);
    }
}
