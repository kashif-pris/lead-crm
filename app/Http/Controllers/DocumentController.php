<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ReflectionClass;
use Auth;
use Redirect;
use TCG\Voyager\Database\Schema\SchemaManager;
use App\FeeSetup;
use App\FormDocument;
use TCG\Voyager\Database\Types\Type;
use TCG\Voyager\Events\BreadAdded;
use TCG\Voyager\Events\BreadDeleted;
use TCG\Voyager\Events\BreadUpdated;
use TCG\Voyager\Facades\Voyager;

class DocumentController extends Controller
{
   public function create(){

    if(!Auth::user()) {
        return redirect('admin/login');
    }
    
    // GET THE SLUG, ex. 'posts', 'pages', etc.
    $slug = 'roles';

    // GET THE DataType based on the slug
    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
    // Check permission
    $this->authorize('browse', app($dataType->model_name));
    $view = 'forms.document.create';
    $forms = FeeSetup::all();
    return Voyager::view($view)->with(compact('dataType','forms'));
  
    }
    function store(Request $request){
        FormDocument::where('form_id',$request->form_id)->delete();
        foreach($request->title  as $key=>$item){
            FormDocument::create([
                'title'=>$request->title[$key],
                'system_value'=>$request->system[$key],
                'is_required'=>$request->required[$key],
                'form_id'=>$request->form_id,
            ]);
        }
        return back();
    }

    function getDocument($fID){
            return FormDocument::where(['form_id'=>$fID])->get();
    }

    

}
