@extends('voyager::master')


@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-pie-chart"></i>
                 
        </h1>
            <a href="/admin/plot/create" class="btn btn-success ">
               <span>Add New File</span>
            </a>
            <!-- <a href="/admin/plot/create" class="btn btn-warning ">
                <span>View Office On Map</span>
             </a> -->
            @if(isset($plot))
            <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                View File
            </a>
            @endif
            
 
      
      
       
     
        @include('voyager::multilingual.language-selector')
    </div>
   
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        
    </div>
    <!-- Panel Starts -->
    <div class="panel" style="padding:12px;">
        <table id="dataTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Project</th>
                    <th>Block</th>
                    <th>File No</th>
                    <th>Size</th>
                    <th>Price</th> 
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Type</th>
                    <th>Added By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($plots))
                @foreach($plots as  $key=>$item)
                 <tr>
                    <td>{{$key+1}}</td>
                    <td>{{@$item->project}}</td>
                    <td>{{@$item->block}}</td>
                    <td>{{@$item->office_no}}</td>
                    <td>{{@$item->size}}</td>
                    <td>{{@$item->price}}</td>
                    @php
                        $leadName = DB::table('leads')->where('id',$item->customer_id)->select('name')->first();
                        $username = DB::table('users')->where('id',$item->added_by)->select('name')->first();
                    @endphp
                    @if($item->customer_id != '')
                    <td>{{@$leadName->name}}</td>
                    <td>{{@$item->phone}}</td>
                    @else
                    <td>Not Assigned</td>
                    <td>Not Assigned</td>
                    @endif
                    <td>
                        @php
                            $token_data = DB::table('tokens')->where('plot_id' , $item->id)->first();
                        @endphp
                        @if(@$item->status == 'Open' )
                            <p class="badge badge-warning" >Open</p>
                        @elseif(@$item->status == 'Sold Out')
                            <p class="badge badge-success" >Sold Out</p>
                        @elseif(@$item->status == 'Token')
                            <p class="badge badge-danger" >Token</p>
                        @endif
                    </td>
                    <td><b>{{@$username->name}}</b></td>
                    <td>
                        <a class="badge badge-primary" href="/admin/plot/show/{{$item->id}}">View</a>
                        @if(Auth::user()->id == @$item->added_by )
                            <a class="badge badge-warning" href="/admin/plot/edit/{{$item->id}}">Edit</a>
                        @endif
                        @if(@$item->status == 'Sold Out')
                        <a href="{{route('generate-plot-receipt',$item->id)}}" title="View" class="badge badge-sm badge-warning pull-right view" style="text-decoration: none;padding: 5px;">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Receipt</span>
                        </a>
                        @endif
                        @if(Auth::user()->id == '1' )
                        <a class="badge badge-danger" href="/admin/plot/delete/{{$item->id}}">Delete</a>
                        @endif
                    </td>
                    
                   
                </tr>
                @endforeach
                @endif
            
               
            </tbody>
        
        </table>
        <div id="map" style="width: 100%; height: 300px;"></div>
    </div>
    <!-- Panel Closed -->



    {{-- model --}}

    @if(isset($plot))

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">File No : {{$plot->office_no}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-striped table-bordered">
              <tr>
                  <th>Project</th>
                  <td>{{$plot->project}}</td>
              </tr>
              <tr>
                <th>Floor</th>
                <td>{{$plot->block}}</td>
            </tr>
            <tr>
                <th>File No</th>
                <td>{{$plot->office_no}}</td>
            </tr>
            <tr>
                <th>Size</th>
                <td>{{$plot->size}}</td>
            </tr>
            <!-- <tr>
                <th>Length</th>
                <td>{{$plot->length}}</td>
            </tr>
            <tr>
                <th>Width</th>
                <td>{{$plot->width}}</td>
            </tr> -->
            <tr>
                <th>Price</th>
                <td>{{$plot->price}}</td>
            </tr>
            <!-- <tr>
                <th>Street</th>
                <td>{{$plot->street}}</td>
            </tr>
            <tr>
                <th>Attach Plots</th>
                <td>
                    @foreach ($attach as $i)
                    {{@DB::table('plots')->where('id',$i)->first()->name}} |  
                    @endforeach
                </td>
            </tr> -->
            <tr>
                <th>Plots Features </th>
                <td>
                    @if(isset($feature))
                    @foreach ($feature as $i)
                    {{@DB::table('features')->where('id',$i)->first()->name}} |  
                    @endforeach
                    @endif
                </td>
 
            </tr>
            <tr>
            @php
                $username = DB::table('users')->where('id',$item->added_by)->select('name')->first();
            @endphp
                <th>Added By</th>
                <td>{{$username->name}}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{@$plot->description}}</td>
            </tr>

          </table>
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
       $(document).ready(function() {
            $("#exampleModal").modal("show");
       });
    
 </script>
  @endif
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

@section('javascript')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script>
      
             function initialize() {

                 @foreach($plots as $item)
                 console.log({{$item->lattitude}});
                  var latlng = new google.maps.LatLng({{$item->lattitude}},{{$item->longitude}});
                    var map = new google.maps.Map(document.getElementById('map'), {
                    center: latlng,
                    zoom: 13
                    });
                    var marker = new google.maps.Marker({
                    map: map,
                    position: latlng,
                    draggable: false,
                    anchorPoint: new google.maps.Point(0, -29)
                });
                
                    var infowindow = new google.maps.InfoWindow();   
                    google.maps.event.addListener(marker, 'click', function() {
                    var iwContent = '<div id="iw_container">' +
                    '<div class="iw_title"><b>Location</b> : Noida</div></div>';
                    // including content to the infowindow
                    infowindow.setContent(iwContent);
                    // opening the infowindow in the current map and at the current marker location
                    infowindow.open(map, marker);
                    });
                    @endforeach
              }
              google.maps.event.addDomListener(window, 'load', initialize);
      

</script>
 
    
@stop
