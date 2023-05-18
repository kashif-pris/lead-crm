@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        
         @include('voyager::multilingual.language-selector')

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


         
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

   
 
@stop

@section('content')
<style>
    .panel{
        text-align: center;
    }

    .panel.panel-orange .panel-heading {
    background: #af9207;
    color: white;
    } 

    .panel.panel-green .panel-heading {
    background: #0da565;
    color: white;
    }

    .panel.panel-blue .panel-heading {
    background: #23037c;
    color: white;
    }

    .panel.panel-purple .panel-heading {
    background: #4f058b;
    color: white;
    }

    .panel.panel-pink .panel-heading {
    background: #a3089b;
    color: white;
    }

    .panel.panel-cyan .panel-heading {
    background: #05557a;
    color: white;
    }

    .panel.panel-red .panel-heading {
    background: #750404;
    color: white;
    }

    .panel.panel-cyen .panel-heading {
    background: #08a2d1;
    color: white;
    }

    span.badge.badge-default {
    background: #ec0000;
   }

   .styleTab{
    border: 1px solid #145660 !important;
    padding: 3px !important;
   }
</style>

<div class="container" style="    margin-top: 50px;">
  

    <div class=" col-sm-12 ">
        <div class="panel panel-success">
            <div class="panel-heading">
               <h3>Overall Customers Account Status  </h3>         
                   
            </div>
            
        </div>
    </div>

    
        <div class=" col-sm-3 placeholder">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Total Amount</h3></div>

                <div class="panel-footer"><a href="javascript:void(0)">
                    <h4> PKR {{number_format($stats[0])}} /-</h3>
                </div>
            </div>
        </div>

        

        <div class=" col-sm-3 placeholder">
            <div class="panel panel-danger">
                <div class="panel-heading"><h3>Recovered</h3></div>
                <div class="panel-footer"><a href="javascript:void(0)">
                    <h4> PKR {{number_format($stats[1])}} /-</h3>
                </div>
            </div>
        </div>

        <div class=" col-sm-3 placeholder">
            <div class="panel panel-danger">
                <div class="panel-heading"><h3>Recoverable</h3></div>
                <div class="panel-footer"><a href="javascript:void(0)">
                    <h4> PKR {{number_format($stats[2])}} /-</h3>
                </div>
            </div>
        </div>

        <div class=" col-sm-3 placeholder">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Today Recovery</h3></div>
                <div class="panel-footer"><a href="javascript:void(0)"> 
                    <h4> PKR {{number_format($stats[3])}} /-</h3>
                </div>
            </div>
        </div>


        <div class=" col-sm-12 placeholder">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="">
                        <div class="panel-heading">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Booking Reference</th>
                                        <th>Customer</th>
                                        <th>Mobile</th>                                    
                                        <th>Balance</th>
                                        <th>Today Payable</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
               
            </div>
        </div>

       

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reminder Details</h4>
                </div>
                <form action="/admin/recovery-data/save-model" method="post" enctype = "multipart/form-data">
                    @csrf
                    <div class="modal-body">
                            <div class="form-group">
                            <label for="note">Note</label>
                            <input type="text" class="form-control " id="note" name="note">
                            </div>
                            <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="date" class="form-control" id="date" name="date">
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label><br>
                                <select class="form-select" aria-label="Default select example" style="width:50%;padding:5px;" name="type">
                                    <option selected >---Choose---</option>
                                    <option value="payment_Receiving">Payment Receiving</option>
                                    <option value="call">Call</option>
                                    <option value="visit">Visit</option>
                                </select>
                            </div>
                    </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </form>

               
            </div>
            
            </div>
        </div>

     </div>
 </div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script type="text/javascript">
    $(function () {      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('customersRecovery') }}",
          columns: [
            {data: 'installmentId', name: 'InstallmentMaster.installmentId'},
              {data: 'sal_customer_name', name: 'tbl_sal_customer_master.sal_customer_name'},
              {data: 'sal_customer_cell', name: 'tbl_sal_customer_master.sal_customer_cell'},            
              {data: 'balance', name: 'balance'},
              {data: 'today_payable', name: 'today_payable'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      
    });

    function addReminder(id){
        // alert(id);
    }
  </script>
@stop



