<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function download($filename)
    {
        $file = File::where('filename', '=', $filename)->firstOrFail();
        return $file->fileDownload();
    }
}
