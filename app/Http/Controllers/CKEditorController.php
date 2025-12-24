<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = \App\Helpers\ImageHelper::uploadAndOptimize($request->file('upload'), 'ckeditor', 1000);
            $url = asset('storage/' . $path);

            return response()->json([
                'uploaded' => 1,
                'fileName' => basename($path),
                'url' => $url,
            ]);
        }
    }
}
