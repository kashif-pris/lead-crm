@include('partials.website_header')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <title>Book Central</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
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
                        <!-- Category -->
                        <h6 class="title-attr" style="margin-top:15px;" ><small>Category</small></h6>                    
                        <div>
                            <h6 class="title-attr"><small>@if(isset($category)) {{$category->name}}@else N/A @endif</small></h6> 
                        </div>
                        <!-- Subjects -->
                        <h6 class="title-attr" style="margin-top:15px;" ><small>Subject</small></h6>                    
                        <div>
                             <h6 class="title-attr"><small>{{$book->subjects}}</small></h6> 
                        </div>
                        <!-- Tags -->
                        <h6 class="title-attr" style="margin-top:15px;" ><small>Tags</small></h6>                    
                        <div>
                          <h6 class="title-attr"><small>{{$book->tags}}</small></h6> 
                        </div>

                          <!-- ISBN -->
                          <h6 class="title-attr" style="margin-top:15px;" ><small>ISBN</small></h6>                    
                        <div>
                          <h6 class="title-attr"><small>{{$book->isbn}}</small></h6> 
                        </div>
                           <!-- Page Count -->
                           <h6 class="title-attr" style="margin-top:15px;" ><small>Page Count</small></h6>                    
                        <div>
                          <h6 class="title-attr"><small>{{$book->numberOfPages}}</small></h6>  
                        </div>

                          <!-- Where to buy -->
                          <h6 class="title-attr" style="margin-top:15px;" ><small>Where to buy?</small></h6>                    
                        <div>
                          <h6 class="title-attr"><small>{{$book->url}}</small></h6> 
                        </div>
                    </div>
                       
                        <div class="section" style="padding-bottom:20px;">

                            @auth
                            @if(count(Auth::user()->library->where('book_id', $book->id)) > 0)
                                <a href="javascript:void(0)"  class="library_{{$book->id}} btn btn-success"><i class="fa fa-check"></i>Have Read It</a>
                            @else 
                            <a href="javascript:void(0)" onclick="haveReadIt('{{$book->id}}','@auth{{Auth::user()->id}}@endauth')" class="library_{{$book->id}} btn btn-primary">  Have Read It</a>
                            
                            @endif

                            @if(count(Auth::user()->wishlist->where('book_id', $book->id)) > 0)
                            <a href="javascript:void(0)"  class="wishlist_{{$book->id}} btn btn-success"> <i class="fa fa-check"></i>Will Read It</a>
                            @else 
                            <a href="javascript:void(0)" onclick="willReadIt('{{$book->id}}','@auth{{Auth::user()->id}}@endauth')" class="wishlist_{{$book->id}} btn btn-primary">  Will Read It</a>

                            @endif
                            @endauth   
                            @guest 
                            <a href="javascript:void(0)" onclick="haveReadIt('{{$book->id}}','@auth{{Auth::user()->id}}@endauth')" class="library_{{$book->id}} btn btn-primary">  Have Read It</a>
                            <a href="javascript:void(0)" onclick="willReadIt('{{$book->id}}','@auth{{Auth::user()->id}}@endauth')" class="wishlist_{{$book->id}} btn btn-primary">  Will Read It</a>
                            @endguest                        
                        </div> 
                       
                           
                                                          
                </div>  
                                   
        
                <div class="col-xs-12">
                <hr>     
                    <?php
                        echo $book->description;
                    ?>
                </div>		
            </div>
        </div>    
        </div>    
        </div>
@include('partials.website_footer')