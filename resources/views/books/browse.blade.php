@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
        @can('add', app($dataType->model_name))
            <a href="{{ route('storeBook') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
      
       
     
        @include('voyager::multilingual.language-selector')
    </div>
   
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        
    </div>
    <!-- Panel Starts -->
    <div class="panel" style="padding:12px;">
        <table id="dataTable" style="width:100%">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Category</th>
                    <th>Publication</th> 
                    <th>Author</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($books) > 0)
                @foreach($books as $index=>$item)
                 <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->isbn}}</td>
                    <td>
                        @php 
                             $category = DB::table('categories')->where('id', $item->category_id)->first();
                        @endphp
                        @if(isset($category))
                             {{$category->name}}
                        @else
                             N/A
                        @endif
                       
                    </td>
                    <td>{{$item->year_of_publication}}</td>
                    <td>
                        @php 
                             $author = DB::table('authors')->where('id', $item->author_id)->first();
                        @endphp
                        @if(isset($author))
                             {{$author->author_name}}
                        @else
                             N/A
                        @endif
                    </td>
                    <td>
                        @can('edit', app($dataType->model_name))
                            <a href="/admin/books/edit/{{$item->id}}">
                                <i class="voyager-edit text-blue"></i>
                            </a>
                         @endcan
                         @can('browse', app($dataType->model_name))
                            <a href="/admin/books/view/{{$item->id}}">
                                <i class="voyager-eye text-blue"></i>
                            </a>
                         @endcan
                         @can('delete', app($dataType->model_name))
                            <a href="/admin/books/delete/{{$item->id}}" class="text-danger">
                                <i class="voyager-trash "></i>
                            </a>
                         @endcan
                     
                        
                      
                    </td>
                </tr>
                @endforeach
                @endif
               
            </tbody>
        
        </table>
    </div>
    <!-- Panel Closed -->
@stop

@section('css')
    <style>
   
    @media screen and (min-width: 480px) {
        .dt-buttons{
            position: relative Im !important;
            left: 10px  !important;
        }
    }
    </style>
    
    
@stop

