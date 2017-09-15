<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function store(request $request)
    {
        if ($request->hasFile('image')) {
            $request->file('image');
            return $request->image->storeAs('public', 'bitfumes.jpeg');
            // return $request->image->store('public');
            // return Storage::putFile('public/new', $request->file('image'));
        } else {
            return 'no file selected';
        }
    }

    public function show()
    {
        $url = Storage::url('bitfumes.jpeg');
        return "<img src='" . $url . "' />";
    }
}
