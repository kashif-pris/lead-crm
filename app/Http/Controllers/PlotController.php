<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class PlotController extends Controller
{
  
    public function index()
    {
      
        $plots = DB::table('plots')->leftJoin('projects','projects.id','plots.pr_id')
        ->leftJoin('blocks','blocks.id','plots.bl_id')->leftJoin('categories','categories.id','plots.size')
        ->select('plots.*','projects.project_name as project','blocks.name as block','categories.name as size')
        ->get();
        return view('plots.record',compact('plots'));
    }

  
    public function create()
    {
        $projects = DB::table('projects')->get();
        $features = DB::table('features')->get();
        $blocks = DB::table('blocks')->get();
        $size = DB::table('categories')->get();
        $plots = DB::table('plots')->get();
        $leads = DB::table('leads')->where('status','Closed Won')->get();
        return view('plots.create',compact('projects','blocks','size','plots','features','leads'));
    }

    public function search(Request $request)
    {
        $project = $request->project;
        $block = $request->block;
        $plot = Plot::latest()->first();
        if(isset($plot)){
            $plot_id = $plot->id + 1;
        }else{
            $plot_id = 1;
        }
      
       $new = $project.'-'.$block.'-'.$plot_id;
        return $new;
    }

    
    public function store(Request $request)
    {

    
// dd($request->all());
        $key = 'AIzaSyC1RGpKCBAwMeclgpo_sqY6Y-XImRhpA30';

        if($request->atack_plot){
            $attach = json_encode($request->atack_plot);
        }else{
            $attach = "[]";
        }

        if($request->feature){
            $feature = json_encode($request->feature);
        }else{
            $feature = "[]";
        }
        
        Plot::create([
           'pr_id' => $request->project   ,
           'bl_id' => $request->block   ,
           'name' => $request->name   ,
           'length' => $request->Length   ,
           'customer_id' => $request->customer_id   ,
           'phone' => $request->phone   ,
           'cnic' => $request->cnic   ,
           'width' => $request->width   ,
           'size' => $request->size  ,
           'street' => $request->street  ,
           'status' => $request->status  ,
           'customer_type' => $request->customer_type  ,
           'customer_name' => $request->customer_name  ,
           'customer_phone' => $request->customer_phone  ,
           'payment_type' => $request->payment_type  ,
            'customer_rel' => $request->customer_rel  ,
           'file_type' => $request->file_type  ,
           'description' => $request->description  ,
           'price' => $request->price   ,
           'attach_plot' => $attach ,
           'feature' => $feature ,
           'lattitude' => $request->latitude ,
           'longitude' => $request->longitude ,
           'location_title' => $request->address,
           'office_no'=>$request->office_no,
           'added_by'=>Auth::user()->id,
        ]);

        return redirect('/admin/plot/record')->with('message','File has been added successfully .....!');
    }


    public function show($id)
    {
        $plot = DB::table('plots')->leftJoin('projects','projects.id','plots.pr_id')
        ->leftJoin('blocks','blocks.id','plots.bl_id')->leftJoin('categories','categories.id','plots.size')
        ->where('plots.id',$id)
        ->select('plots.*','projects.project_name as project','blocks.name as block','categories.name as size')
        ->first();
        

        $plots = DB::table('plots')->leftJoin('projects','projects.id','plots.pr_id')
        ->leftJoin('blocks','blocks.id','plots.bl_id')->leftJoin('categories','categories.id','plots.size')
        ->select('plots.*','projects.project_name as project','blocks.name as block','categories.name as size')
        ->get();

        $attach = json_decode($plot->attach_plot);
        $feature = json_decode($plot->feature);
        return view('plots.record',compact('plot','plots','attach','feature'));
    }

    public function edit($id)
    {
        $plot = DB::table('plots')->where('id',$id)->first();
        // dd($plot);
        $update = 1;
        $projects = DB::table('projects')->get();
        $blocks = DB::table('blocks')->get();
        $features = DB::table('features')->get();
        $size = DB::table('categories')->get();
        $plots = DB::table('plots')->get()->toArray();
        $attach = json_decode($plot->attach_plot);
        $feature = json_decode($plot->feature);
        $leads = DB::table('leads')->where('status','Closed Won')->get();
        
        return view('plots.create',compact('projects','leads','blocks','size','plots','plot','update','attach','features','feature'));

    }

    
    public function update(Request $request, $id)
    {
        
       if($request->attach_plot){
        $json = json_encode($request->attach_plot);
       }else{
           $json = "[]";
       }

       if($request->feature){
        $feature = json_encode($request->feature);
       }else{
           $feature = "[]";
       }

        Plot::find($id)->update([
            'pr_id' => $request->project   ,
            'bl_id' => $request->block   ,
            'name' => $request->name   ,
            'length' => $request->Length   ,
            'width' => $request->width   ,
            'size' => $request->size  ,
            'customer_id' => $request->customer_id   ,
           'phone' => $request->phone   ,
           'cnic' => $request->cnic   ,
            'street' => $request->street  ,
            'status' => $request->status  ,
            'customer_type' => $request->customer_type  ,
            'payment_type' => $request->payment_type  ,
            'customer_rel' => $request->customer_rel  ,
           'customer_name' => $request->customer_name  ,
           'customer_phone' => $request->customer_phone  ,
           'file_type' => $request->file_type  ,
           'description' => $request->description  ,
            'price' => $request->price   ,
            'attach_plot' => $json ,
            'feature' => $feature ,
            'lattitude' => $request->latitude ,
           'longitude' => $request->longitude ,
           'location_title' => $request->address,
           'office_no'=>$request->office_no,
           'added_by'=>Auth::user()->id,
           
        ]);
        return redirect('/admin/plot/record')->with('message','File has been upfated successfully ...!');
       
    }

    public function destroy($id)
    {
      
        Plot::find($id)->delete();
        return back()->with('message','File has been deleted ...!');
    }
    
    function PlotReceipt($token){
        // dd($token);
        
        $data =  Plot::where('id',$token)->with('block','sizeGet','projects','customers')->first();
        // dd($data);
        if($data->customer_id != NULL){
            return view('receipts.printReceipt',compact('data'));
        }else{
           dd('File not assigned yet to get print');
        }
        
    }
}
