<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
//
    private $baseUrl = "http://ahmadhossi-001-site1.btempurl.com";

//    private  $baseUrl= "http://localhost/Projects/around-you-app";

    public function upload(UploadFileRequest $request)
    {
        $file = $request->file('file');
        try {
            Storage::disk('public')->put('/media/Files/' . time() . '.' . $file->extension(), fopen($file, 'r+'), 'public');
            $data = $this->baseUrl . '/storage/app/public/media/Files/' . time() . '.' . $file->extension();
            return response()->json(['status' => 'OK', 'data' => $data], 250);

        } catch (\Exception $exception) {
            return response()->json(['status' => 'OK', 'data' => 'Operation Has been Failed'], 510);
        }
    }

}
