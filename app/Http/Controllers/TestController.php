<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Storage;
class TestController extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function store(Request $request)
    {
            $image      = $request->file('avatar');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(120, 120, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->stream(); // <-- Key point

            //dd();
            Storage::put($fileName, $img,'public');
    }
}
