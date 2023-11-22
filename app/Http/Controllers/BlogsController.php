<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

            $blogs = DB::select("CALL get_blogs()");
            //dd($blogs);

            return view('blogs', compact('blogs'));
        } else {
            return redirect(url('login'))->with('fail', 'you need to login first to discover/access dashboard');
        }
    }

    public function CreateBlog(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blog_manual_pdf' => 'mimes:pdf|max:10000',
        ]);

        $title = $request->input('title');
        $description = $request->input('description');

        //for image upload
        $image = $request->file('image');

        $image_new_name = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('uploads'), $image_new_name);

        //for blog manual pdf file upload
        $blog_manual = $request->file('blog_manual_pdf');

        $blog_manual_new_name = time() . '.' . $blog_manual->getClientOriginalExtension();

        $blog_manual->move(public_path('blog_manuals'), $blog_manual_new_name);

        //dd($image_new_name);

        $created_at = date("Y-m-d h:i:s");
        $updated_at = date("Y-m-d h:i:s");

        $create_blog = DB::insert("CALL create_blog(?,?,?,?,?,?)", array($title, $description, $image_new_name, $blog_manual_new_name, $created_at, $updated_at));

        if ($create_blog) {
            return redirect(url('blogs'))->with('success', 'Blog Successfully Created');
        } else {
            return redirect(url('blogs'))->with('fail', 'Failed to create blog');
        }
    }

    public function EditBlog($blog_id)
    {

        if (Auth::check()) {

            $blog = DB::select("CALL get_blog_by_id(?)", array($blog_id));
            //dd($blog);

            return view('edit_blog', compact('blog'));
        } else {
            return redirect(url('login'))->with('fail', 'you need to login first to discover/access dashboard');
        }

    }

    public function UpdateBlog(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $id = $request->input('id');
        $title = $request->input('title');
        $description = $request->input('description');

        $image = $request->file('image');
        if ($image != "") {
            $image_new_name = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads'), $image_new_name);
        } else {
            //old_filename
            $blog = DB::select("CALL get_blog_by_id(?)", array($id));
            $image_new_name = $blog[0]->image;
        }

        //dd($image_new_name);

        $created_at = date("Y-m-d h:i:s");
        $updated_at = date("Y-m-d h:i:s");

        $create_blog = DB::update("CALL update_blog(?,?,?,?,?)", array($id, $title, $description, $image_new_name, $updated_at));

        if ($create_blog) {
            return redirect(url('blogs'))->with('success', 'Blog Successfully Upadated');
        } else {
            return redirect(url('blogs'))->with('fail', 'Failed to create blog');
        }
    }
}
