<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadLocalFiles
{
    public function uploadPacientPhoto(Request $request, $field)
    {
        $result = [];
        $name = uniqid(date('HisYmd'));
        $extension = $request->file($field)->extension();

        $nameFile = "{$name}.{$extension}";

        $upload = $request->file($field)->storeAs('photos', $nameFile);

        if (!$upload) {
            $result['ok'] = false;
            $result['message'] = 'Falha ao fazer upload.';
            $result['filename'] = '';
        } else {
            $result['ok'] = true;
            $result['message'] = '';
            $result['filename'] = $nameFile;
        }

        return $result;
    }
}
