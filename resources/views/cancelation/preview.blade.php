@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-pie-chart"></i>
            <a href="/admin/plot/record" class="btn btn-success btn-add-new">
               <span>Cancelation Request</span>
            </a>
      
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
    
    <style>
        @page  {
          margin: 0;
          size: Legal; /*or width x height 150mm 50mm*/
        }
        table, td, th {
        border: 1px solid black;
      }
      
      table {
          width: 100%;
          border-collapse: collapse;
      }
      td{
          width: 50%;
          font-weight: 600;
          padding: 10px;
      }


    path {
    fill: transparent;
    }

    text {
        font-size: 35px;
    fill: #FF9800;
    }
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
  
	<div class="col-md-12">
        <div class="panel panel-defualt">
            <div class="panel-heading">
                <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
            </div>
            <div class="panel"  style="padding:22px;">
            <div class="row">
                <div id="page-wrap">
                    <svg viewBox="0 0 400 400" style="position: absolute; width: 70%; margin-left: 123px; transform: -90; transform: rotate( 13deg );
                ">
                        <path id="curve" d="M73.2,148.6c4-6.1,65.5-96.8,178.6-95.6c111.3,1.2,170.8,90.3,175.1,97" />
                        <text width="400">
                         
                        </text>
                      </svg>
                </div>
                    <table>
                        {{-- @dd($plot); --}}
            
                    
                    <tr style="height: 50px !important;">
                        <td>Name: {{$plot->booking->customers->sal_customer_name}}</td>
                        <td>Plot:{{$plot->booking->plots->name}}</td>
                    </tr>
                    <tr style="height: 50px !important;">
                        <td>Address: {{$plot->booking->customers->sal_customer_address_1}}</td>
                        <td>Precinct:
                            <br style="margin-top: 20px;">
                            Street:
                        </td>
                    </tr>
                    <tr style="height: 50px !important;">
                        <td>CNIC: {{$plot->booking->customers->sal_customer_id}}</td>
                        <td>Size:{{$plot->booking->plot_size}} </td>
                    </tr>
                    <tr style="height: 50px !important;">
                        <td>Contact: {{$plot->booking->customers->sal_customer_cell}}</td>
                        <td>Category:{{$plot->booking->plots->status}}</td>
                    </tr>
                    </table>
                    <p>Management of DEFENCE CITY is pleased to issue this final allotment letter on the following terms and 
                        conditions: -</p>
                        <ol type="I">
                            <li>This is in continuation of provisional allotment letter issued on ___(Date)___ and the terms and 
                            conditions printed overleaf thereof duly accepted and signed by the allottee.
                            </li>
                            <li>The plot number, phase and plot size are final and will not be changed by DEFENCE CITY except on 
                                technical grounds.</li>
                            <li>This allotment is not transferable unless authorized by the DEFENCE CITY.</li>
                            <li>
                                Please acknowledge receipt of this letter. 
                            </li>
                        </ol>
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <h4 style=" border-top: 1px solid; width: 183px; text-align-last: center; position: relative; left: 950; ">GM Sales</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h3 style="text-align: center;">TERMS AND CONDITIONS OF ALLOTTMENT</h3>
                    <ol style=" line-height: 1.6; text-align: justify; ">
                        <li>The size and location of the plot/house/apartment/unit is tentative and subject to adjustment/change 
                            until physical possession is taken by allottee.</li>
                        <li>The allottee shall pay all charges determined by the management of DEFENCE CITY from time to time. If 
                            any amount remains unpaid despite the notice(s) the management shall have right to cancel the allotment 
                            and the total amount deposited by the allottee shall be refunded after 20% deduction. The decision of the 
                            management in this regard shall be final.</li>
                        <li>For each preferential location i.e. Corner, Facing Park and Main Boulevard applicant will pay 10%
                            premium/ each. In case of multiple preferences, the applicant will pay in multiple of 10% to 20 % For 
                            example Main boulevard, corner, facing park will be charged 30% premium.</li>
                        <li>The price is based on the assumed standard size of the house/plot; allottee may have to pay more or less 
                            according to the allocated actual size of the house/plot. The payment adjustment will be made during the 
                            last instalment or earlier on possession.</li>
                        <li>After clearing all the outstanding dues including surcharges, in case any of the allottee may ask for taking 
                            over the possession of house/plot the management shall be final authority to take decision in this respect 
                            and the said decision shall be final and binding upon the allottee.
                            </li>
                        <li>After taking over the possession of house, in case the allottee wants to secure loan from a registered loan 
                            giving agency, he has to obtain No Objection Certificate from the Management of DEFENCE CITY before 
                            mortgaging the house/plot with said agency.</li>
                        <li>The allottee shall be liable to pay from the date he/she takes over the possession, all taxes, charges 
                            (including betterment and maintenance charges) as assessed by the Government Departments. 
                            MDA/KDA/Cantonment Board/SCBA/KMC and which may be levied or imposed now or hereafter 
                            by the Management of DEFENCE CITY or be payable in respect of the said house/plot or anything 
                            relating there by any competent authority under the law, rule, regulation, bye-laws or the orders of the 
                            State for the time being in force.
                            </li>
                        <li>The allottee will comply with and abide by all the terms and conditions, bye-laws and such other 
                            instructions that may be issued by DEFENCE CITY MDA/KDA/SCBA/KMC/Cantonment Board or any 
                            such Govt. authority from time to time.
                            </li>
                        <li>The allottee shall not disturb/interfere with layout of the housing scheme in any matter whatsoever and 
                            shall not encroach upon or put in to his use the pavements, pathways, roads, beams, green belts or any of 
                            the area/piece of land in ownership of the DEFENCE CITY other than the one allotted to him.</li>
                        <li>In case of any encroachment as mentioned above, the Management of DEFENCE CITY, in addition to any 
                            action permitted by terms and conditions of the allotment, may pull down remove or demolish the 
                            encroachment without any notice at the risk and cost of the allottee and the allottee shall be
                            liable to ____ cost to DEFENCE CITY incurred immediately on removal of such encroachment.</li>
                        <li>. The allottee shall use the house for residential (if we are issuing only for residential) purpose only and in 
                            case of violation, the allotment shall be liable to cancellation unless DEFENCE CITY otherwise agrees, 
                            allows or approves the same on certain conditions agreed to by the party.
                            </li>
                        <li>The Management of DEFENCE CITY reserves the right to cancel the allotment of house/plot resume its 
                            possession and forfeit whole or part of the payments already made in case of contravention of any 
                            condition of allotment in such case it shall be lawful for an officer of DEFENCE CITY authorized on its 
                            behalf notwithstanding the waiver of any previous right of entry upon the allotted house and take
                            possession of the same and the building, construction or any material found there or without any 
                            compensation thereof and the allottee shall be responsible for any loss that the DEFENCE CITY may 
                            sustain in the fresh allotment of the house/plot.</li>
                        <li>The allottee undertakes to abide by all the terms and conditions prescribed for transfer of allotted house/ 
                            plot, change of nominee and payment to be made to DEFENCE CITY on this account.
                        </li>
                        <li>In case of any dispute between the allottee and DEFENCE CITY, the matter shall be referred by either 
                            party to arbitration of the Chief Executive of the DEFENCE CITY whose decision shall be final and 
                            binding on both the parties without recourse to any court of law.
                            </li>
                        <li>The allottee undertakes to abide by the terms and conditions given above and shall not dispute these 
                            terms and conditions in any forum or before any court/authority.</li>
                    </ol>
                    <p style="padding-left: 20px;    line-height: 2.5; text-align: justify;">
                    I have carefully read, understood, acknowledged and accepted the above-mentioned terms and conditions for the allotment and bind myself for meticulous compliance, <br>
                    <b>Name:</b> {{$plot->booking->customers->sal_customer_name}} <b>S/O:</b> {{$plot->booking->customers->sal_customer_cont_person}} <b>R/O:</b>___________________________ <b>Allotted House No.</b> {{$plot->id}} <b> {{$plot->id}}</b> in 
                    DEFENCE CITY.<br>
                    <b>Sign of Allottee</b> _______________ <b>CNIC No</b>. {{$plot->booking->customers->sal_customer_id}}

                    </p>
                </div>
            </div>
        </div>
        <h3>Documents Required</h3>
        <!-- BOOTSTRAP V5 -->
        <div class="card">
            <table class="table">
                <thead style="background:grey;">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Document Type</th>
                    <th scope="col">Attachments</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($doc as $item)

                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->title}}</td>
                        <td>
                            <a href="{{"/".$item->path."/".$item->file}}" class="badge badge-primery" target="-blank">View</a>
                           
                        </td>

                    </tr>
                        
                    @endforeach
                       
                   
                </tbody>
            </table>
        </div>
          
               
               
               
            </form>

            </div>
            <div style="margin-left: 500px">
                <button id="print" class="btn btn-info" onclick="Pr()">print</button>
                <a id="approve" href="/admin/cancelation/approve/{{$id}}" class="btn btn-success">Approve</a>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Reject</button>
             </div>
        </div>

           {{-- model --}}
           <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Reject Form</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" action="{{route('cancelation.reject')}}">
                    @csrf
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label right" style="float: left">Subject:</label>
                      <input type="text" class="form-control" id="recipient-name" name="subject">
                      <input type="hidden" class="form-control" name="id" value="{{$id}}">
                      <input type="hidden" class="form-control" id="path" name="path" value="">
                    </div>
                    <div class="form-group">
                      <label for="message-text" class="col-form-label" style="float: left">Message:</label>
                      <textarea class="form-control" id="message-text" name="message"></textarea>
                    </div>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Send message</button>
                </div>
              </form>
              </div>
            </div>
          </div>
        {{-- model-end --}}

       

     
   
    
    

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
   <!-- DataTables -->
   
    <script src="{{ asset('dataTable/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dataTable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dataTable/jszip.min.js') }}"></script>
     
     
    <script>
        $("#path").val(window.location.pathname);  
        function Pr(){
          $(".btn").hide();
                print();
             location.reload();
        }
    </script>
     <script>
    
        $(document).ready(function() {
            $('#example').DataTable( {
                "scrollX": true,
                 dom: 'Bfrtip',
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 Filas', '25 Filas', '50 Filas', 'All' ]
                    ],
                    buttons: [
                    { extend: 'excel', text: '<i class="fas fa-file-excel" aria-hidden="true"> Exportar a EXCEL</i>' },
                    'pageLength'
                    ],
            } );
        } );

        function apporveCertificate(allotmentID,loggedUserID) {
                $.ajax({
                    'url':'/admin/pac/approve/certificate',
                    'method':'POST',
                    'data':{allotmentID:allotmentID,loggedUserID:loggedUserID,'_token':'{{csrf_token()}}'},
                    success:function(data){
                        console.log(data); 
                        toastr.success("Approved Successfully! SMS sent to CCRA");
                        setTimeout(function() { location.reload(); }, 3000); 
                    },
                    error:function(data){
                        
                    }
                })
        }
     </script>
    
@stop