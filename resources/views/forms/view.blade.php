@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/books" class="btn btn-success btn-add-new">
               <span>All Books</span>
            </a>
        @endcan
        </h1>
       
      
       
     
        @include('voyager::multilingual.language-selector')
    </div>
 <style>
    input[type="file"] {
        /* display: none; */
    }
    .note-btn{
        background: #62a8ea !important;
    }
    /* .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 5px 45px;
        cursor: pointer;
        margin-top: 26px;
    } */
 </style>
@stop

@section('content')
    <div class="page-content  browse container-fluid">
        @include('voyager::alerts')
             @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
    </div>
        <div class="container panel panel-info " style="padding:12px !important;">
        	<div class="row">
               <div class="col-xs-4 item-photo">
                    <img style="max-width:60%;" class="rounded float-left img-fluid img-thumbnail" src="{{$book->image_url}}" />
                </div>
                <div class="col-xs-5" style="border:0px solid gray">
                    <!-- Datos del vendedor y titulo del producto -->
                    <h3>{{$book->title}}</h3>  
                    @php 
                        $author = DB::table('authors')->where('id',$book->author_id)->first();
                        $category = DB::table('categories')->where('id',$book->category_id)->first();
                    @endphp

                    <h5 style="color:#337ab7">By<a href="/admin/authors/@if(isset($author)) {{$author->id}} @else {{'#0'}} @endif">@if(isset($author)) {{$author->author_name}} @else {{'N/A'}} @endif </a> · <small style="color:#337ab7">(5054 reviews)</small></h5>
        
               
                   
        
                    <!-- Detalles especificos del producto -->
                    <div class="section">
                        <h6 class="title-attr" style="margin-top:15px;" ><small>Category</small></h6>                    
                        <div>
                        <h6 class="title-attr"><small>@if(isset($category)) {{$category->name}}@else N/A @endif</small></h6> 
                        </div>
                    </div>
                        @can('edit', app($dataType->model_name))
                        <div class="section" style="padding-bottom:20px;">
                        <a href="/admin/books/edit/{{$book->id}}"> <button class="btn btn-primary"><span style="margin-right:12px" class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button></a>
                        
                        </div> 
                         @endcan
                           
                                                          
                </div>  
                                   
        
                <div class="col-xs-12">
                <hr>     
                    <?php
                        echo $book->description;
                    ?>
                </div>		
            </div>
        </div>     
   
      
    

@stop
@section('javascript')
    <script src="{{ asset('dataTable/summernote.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
   <script type="text/javascript">
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 250,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                }
            });
        });
        $(".myselect2").select2();
        $(".myselect").select2({
            multiple: true,
            
        });
    </script>
   
    
@stop