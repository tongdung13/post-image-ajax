<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::query()->orderBy('id', 'desc')->paginate(10);
        $users = User::query()->orderBy('id', 'desc')->select(['id', 'name'])->get();

        return view('welcome', compact('blogs', 'users'));
    }

    public function store(Request $request)
    {
        $blogs = new Blog();
        $blogs->fill($request->all());

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileExtension = $image->getClientOriginalExtension();
            $fileName = md5(time() . rand(0, 999999)) . '.' . $fileExtension;
            $fileUpload = public_path('blogs');
            $image->move($fileUpload, $fileName);
            $blogs->image = 'blogs/' . $fileName;
        }

        $blogs->save();

        return response()->json($blogs);
    }
}
