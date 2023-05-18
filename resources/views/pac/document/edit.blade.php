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
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>
 <style>
    input[type="file"] {
        /* display: none; */
    }
    .note-btn{
        background: #62a8ea !important;
    }
    #tagator_activate_tagator2{
        width:auto !important;
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
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Edit Book</h3>
        </div>
        
        <div class = "panel-body">
        <form action = "/admin/books/edit/{{ $book->id }}" method ="post" enctype = "multipart/form-data">
        @csrf
            <div class="row">
                <div class="col-md-6">
                <label class="font-weight-bold">Book Title * <sub>(Max 191 characters)</sub></label>
                <input type="text" value="{{ $book->title }}" maxlength="191" name="title" class="book_title form-control @error('title') is-invalid @enderror"  placeholder="Enter Book Title" required>
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                </div>
              
                <div class="col-md-3">
                <label for="file-upload" class="custom-file-upload">
                    <i class="voyager-upload"></i> Image Upload  <sub>Only jpeg, jpg, png | Max size 500 KB</sub></label>
                <input type="file" value="{{ old('image_url') }}" id="file-upload" name="image_url" class="@error('image_url') is-invalid @enderror" >
                </div>

               <div class="col-md-3">
                  <a href="{{$book->image_url}}" target="_blank">  <img src="{{ $book->image_url }}" class="rounded float-right img-fluid img-thumbnail" width="100"></a>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-6">
                <label class="font-weight-bold">Author *</label>
                <select  class="form-control myselect2 border border-dark @error('author_id') is-invalid @enderror" name="author_id" required>
                    <option value='' > Select </option>
                    @if(!empty(Config::get('authors'))) 

                        @foreach(config('authors') as $key=>$author) 
                            <option  {{ $book->author_id == $author->id ? "selected" : "" }} value="{{ $author->id }}"> {{$author->author_name}} </option>
                        @endforeach 
                        
                    @endif
                </select>
                </div>
                <div class="col-md-6">
                    <label class="font-weight-bold">ISBN * <sub>Only numbers</sub></label>
                    <input value="{{$book->isbn}}" type="text"  type="text" name="isbn" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  class="form-control @error('isbn') is-invalid @enderror" placeholder="Enter ISBN Number" required>
                </div>
                
               
            </div>
            <div class="row">
                <div class="col-md-6">
                <label class="font-weight-bold">Category *</label>
                <select class="form-control myselect2 border border-dark @error('category_id') is-invalid @enderror" name="category_id" required>
                    <option value='' disabled selected> Select </option> 
                    @if(!empty(Config::get('categories'))) 
                        @foreach(config('categories') as $key=>$category) 
                            <option {{ $book->category_id  == $category->id ? "selected" : "" }} value="{{ $category->id }}" value='{{$category->id}}'> {{$category->name}} </option> 
                        @endforeach
                    @endif
                </select>
                </div>
                <div class="col-md-6">
                    @php $numItems = count($tagsArray); @endphp
                <label class="font-weight-bold">Tags *</label>
                 <input id="activate_tagator2" type="text" class="tagator @error('tags') is-invalid @enderror" name="tags" value="{{$book->tags}}" data-tagator-show-all-options-on-focus="true" data-tagator-autocomplete="[@foreach($tagsArray as $key=>$tag)'{{$tag}}'@if(++$key === $numItems)@else,@endif @endforeach]">
                
                </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                <label class="font-weight-bold">Year Of Publication *</label>
                <select class="form-control myselect2 border border-dark @error('year_of_publication') is-invalid @enderror" name="year_of_publication" required>
                     
                            
                                @for($i = 1400 ; $i < date('Y'); $i++)
                                     <option @if($book->year_of_publication == $i) {{'selected'}} @endif value="{{$i}}">{{$i}}</option>;
                                @endfor
                   
                </select>
                </div>
              
                <div class="col-md-6">
                <label class="font-weight-bold">Pages * <sub>(Max 6 digits)</sub></label>
                <input type="text" value="{{$book->numberOfPages}}" name="numberOfPages" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="6" class="form-control @error('numberOfPages') is-invalid @enderror" placeholder="Enter number of pages " required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-bold">Similar Books</label>
                    <select class="form-control multiselect myselect border border-dark" name="similar_books"> @if(!empty(Config::get('categories'))) @foreach(config('categories') as $category) <option value='{{$category->id}}'> {{$category->name}} </option> @endforeach @endif </select>
                </div>
                <div class="col-md-6">
                <label class="font-weight-bold">Subject *</label>
                     <input type="text" value="{{$book->subjects}}" name="subjects" class="form-control @error('subjects') is-invalid @enderror" placeholder="Enter subject " required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-bold">Edition <su>(Max 20 characters)</su></label>
                    <input type="text" value="{{$book->edition}}" class="form-control" maxlength="20" name="edition"  />
                </div>
                <div class="col-md-6">
                <label class="font-weight-bold">Where to buy?</label>
                     <input type="text" value="{{$book->url}}" name="URL" class="form-control" placeholder="Enter url " >
                </div>
            </div>
            @if($book->status == 1)
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-bold">Meta Description</label>
                        <input type="text" name="meta_description" value="{{$book->meta_description}}" class="form-control" placeholder="Enter meta description " >
                </div>
                <div class="col-md-6">
                    <div class="radio mt-5"><br>
                        <label>
                        <input type="radio" value="1" name="status" checked>Publish </label>
                    </div>
                 </div>

            </div>
            <div class="row">
             <div class="col-md-6">
                <label class="font-weight-bold">Meta Keywords</label>
                     <input type="text" name="meta_keywords" value="{{$book->meta_keywords}}"  class="form-control" placeholder="Enter keywords " >
                </div>
                <div class="col-md-6">
                    <div class="radio mt-5"><br>
                        <label>
                            <input type="radio" value ="0" name="status">Save as draft </label>
                    </div>
                 </div>
               
            </div>
            <div class="row">
             <div class="col-md-6">
                <label class="font-weight-bold">Meta Title</label>
                     <input type="text" name="meta_title" value="{{$book->meta_title}}" class="form-control" placeholder="Enter meta title " >
                </div>
              
            </div>
            <div class="row">
             <div class="col-md-6">
                <label class="font-weight-bold">Slug</label>
                     <input type="text" value="{{ $book->slug}}" name="slug" class="form-control slug" placeholder="Url reference.. " >
                </div>
                
               
            </div>
            @else          
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-bold">Meta Description</label>
                        <input type="text" name="meta_description" value="{{$book->meta_description}}" class="form-control" placeholder="Enter meta description " >
                </div>
                <div class="col-md-6">
                    <div class="radio mt-5"><br>
                        <label>
                        <input type="radio" value="1" name="status" >Publish </label>
                    </div>
                 </div>

            </div>
          
            <div class="row">
             <div class="col-md-6">
                <label class="font-weight-bold">Meta Keywords</label>
                     <input type="text" name="meta_keywords" value="{{$book->meta_keywords}}" class="form-control" placeholder="Enter keywords " >
                </div>
                <div class="col-md-6">
                    <div class="radio mt-5"><br>
                        <label>
                            <input type="radio" value ="0" name="status" checked>Save as draft </label>
                    </div>
                 </div>
               
            </div>
            <div class="row">
             <div class="col-md-6">
                <label class="font-weight-bold">Meta Title</label>
                     <input type="text" name="meta_title" value="{{$book->meta_title}}" class="form-control" placeholder="Enter meta title " >
                </div>
              
            </div>
            <div class="row">
             <div class="col-md-6">
                <label class="font-weight-bold">Slug</label>
                     <input type="text" value="{{ $book->slug}}" name="slug" class="form-control slug" placeholder="Url reference.. " >
                </div>
                
               
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                <label class="font-weight-bold">Description </label>
                <textarea required class="form-control @error('description') is-invalid @enderror" id="summernote" rows="50" cols="50" placeholder="Enter Book description" name="description">{{$book->description}}</textarea>
                </div>
                <button class="btn btn-success float-right " style="margin-right:14px;" type="submit">Update Book</button>
            </div>
        </form>
        </div>
    </div>
     
   
      
    

@stop
@section('javascript')
    <script src="{{ asset('tagsManager/fm.tagator.jquery.js') }}"></script>
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
        $('#file-upload').bind('change', function() {
            var fileSize = 500000; //500 KB
            var fileExtension = ['jpeg', 'jpg', 'png'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only formats are allowed : "+fileExtension.join(', '));
                $("#file-upload").css("border-color",'red');
                $("#file-upload").val("");
            }
            if(this.files[0].size > fileSize){
                alert('File size is too large!');
                $("#file-upload").val("");
                $("#file-upload").css("border-color",'red');
            }

        });
        $('.book_title').bind('keyup', function() {
            var Text = $(this).val();
            $('.slug').val(Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,''));

        });
    </script>
   
    
@stop