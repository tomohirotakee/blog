<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\Blogrequest;

class BlogController extends Controller
{
    //ブログ一覧表示
     
    
    
    public function showList()
    {
        $blogs = Blog::all();
        
    
        return view('blog.list',['blogs'=>$blogs]);        
    }
     //ブログ詳細を表示する
      public function showDetail    ($id)
    {
        $blog = Blog::find($id);
        
        if(is_null($blog)) 
     {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
     }
        
    
        return view('blog.detail',['blog'=>$blog]);        
     } 
    
      //ブログ登録を表示する
      public function showCreate()
      {
          return view('blog.form');
      }      
          
      //ブログを登録する
      public function exeStore(BlogRequest $request)
      {
          //ブログのデータを受け取る
             $inputs = $request->all();
            
           \DB::beginTransaction();
          try{
          //ブログを登録
             Blog::create($inputs);
             \DB::commit();
          }catch(\throwble $e){
             \DB::rollback(); 
              abort(500);
          }
          
          \Session::flash('err_msg', 'ブログを登録しました。');
         return redirect(route('blogs'));
      }      
    
    
    //ブログ編集画面を表示する
     public function showEdit    ($id)
    {
        $blog = Blog::find($id);
        
        if(is_null($blog)) 
     {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
     }
        
    
        return view('blog.edit',['blog'=>$blog]);        
     } 
    
    //ブログを更新する
      public function exeUpdate(BlogRequest $request)
      {
          //ブログのデータを受け取る
             $inputs = $request->all();
             
            
           \DB::beginTransaction();
          try{
          //ブログ更新を登録
            $blog= Blog::find($inputs['id']);
            $blog->fill([
                'title'=>$inputs['title'],
                'content'=>$inputs['content'],
                ]);
                $blog->save();
             \DB::commit();
          }catch(\throwble $e){
             \DB::rollback(); 
              abort(500);
          }
          
          \Session::flash('err_msg', 'ブログを更新しました。');
         return redirect(route('blogs'));
      }      
    
     //ブログ削除画面を表示する
     public function exeDelete    ($id)
    {
        
         if(empty($id)) 
     {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
     }
        
        try{
          //ブログを削除
            Blog::destroy($id);
          }catch(\throwble $e){
              abort(500);
          }
        
       
        
     \Session::flash('err_msg', 'ブログを削除しました。');
       return redirect(route('blogs'));         
     } 
    
    
}



