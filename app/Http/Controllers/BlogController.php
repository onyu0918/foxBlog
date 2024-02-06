<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    //
    public function showList() {
        $blogs = Blog::all();

        return view('blog.list', ['blogs' => $blogs]);
    }

    public function showDetail($id) {
        $blog = Blog::find($id);

        if(is_null($blog)) {
            Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }

        return view('blog.detail', ['blog' => $blog]);
    }

    public function showCreate() {

        return view('blog.form');
    }
    public function exeStore(BlogRequest $request) {
        $inputs = $request->all();
        
        DB::beginTransaction();
        try{
            Blog::create($inputs);
            DB::commit();
        }catch(\Throwable $e) {
            DB::rollBack();
            abort(500);
        }

        Session::flash('err_msg', 'ブログお登録しました。');
        return redirect(route('blogs'));
    }

    public function showEdit($id) {
        $blog = Blog::find($id);

        if(is_null($blog)) {
            Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }

        return view('blog.edit', ['blog' => $blog]);
    }

    public function exeUpdate(BlogRequest $request) {
        $inputs = $request->all();
        
        DB::beginTransaction();
        try{
            $blog = Blog::find($inputs['id']);
            $blog->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content'],
            ]);
            $blog->save();
            DB::commit();
        }catch(\Throwable $e) {
            DB::rollBack();
            abort(500);
        }

        Session::flash('err_msg', 'ブログお更新しました。');
        return redirect(route('blogs'));
    }

    public function exeDelete($id) {

        if(empty($id)) {
            Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }
        try{
            Blog::destroy($id);
        }catch(\Throwable $e) {
            abort(500);
        }
        Session::flash('err_msg', '削除しました。');
        return redirect(route('blogs'));
    }
}
