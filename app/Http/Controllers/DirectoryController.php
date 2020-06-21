<?php

namespace App\Http\Controllers;

use App\Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectoryController extends Controller
{

//file history
    public function filehistory()
    {
        if(request("search")!=""){
            $file_list= Directory:: whereRaw("file_name regexp '^(?:[\w]\:|\\)(\\[a-z_\-\s0-9\.]+)+\.(txt|gif|pdf|doc|docx|xls|xlsx|jpeg)$'")->where("file_name","like","%".request("search")."%")->onlyTrashed()->  paginate(10);
        }else{
            $file_list= Directory::onlyTrashed()->  paginate(10);
        }
      
       return view('directory_list/filehistory',compact("file_list"));
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request("search")!=""){
            $file_list= Directory:: whereRaw("file_name regexp '^(?:[\w]\:|\\)(\\[a-z_\-\s0-9\.]+)+\.(txt|gif|pdf|doc|docx|xls|xlsx|jpeg)$'")->where("file_name","like","%".request("search")."%")->  paginate(10);
        }else{
            $file_list= Directory:: paginate(10);
        }
      
       return view('directory_list/index',compact("file_list"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('directory_list/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,csv,jpg,gif,jpeg',
        ]);
  
        $fileName = $request->file->extension().time().'.'.$request->file->extension();  
   
        $request->file->move(public_path('file_list'), $fileName);
        

        $file_data["file_name"] =     $fileName;
        $file_data["uuid"] =    DB::raw("uuid()");
        
        $file_data["url"] =   asset("file_list/". $fileName) ;
        Directory::create( $file_data);
        return redirect()->route('index')
            ->with('success','You have successfully upload file.')
            ->with('file',$fileName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directory $file)
    {
        $file->delete();
        return redirect()->route('index')
        ->with('success','You have successfully Deleted file.')
        ->with('file' ,$file->file_name);
    }
}
