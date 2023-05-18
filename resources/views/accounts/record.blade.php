@extends('voyager::master')

@section('page_title', 'Record')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            @if(Auth::user()->hasPermission('add_booking'))
            <a href="/admin/application-form" class="btn btn-success btn-add-new">
               <span>Booking Form</span>
            </a>
          @endif
        </h1>
        @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>

   
<style>
ul, #myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}

.cart {
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

.cart::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.cart-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */'
  transform: rotate(90deg);  
}

.nested {
  display: none;
}

.active {
  display: block;
}
</style>
 

@stop

@section('content')

 <div class="container">
    <h2>Chart Of Account</h2>
    <div class="row">
       <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
              <ul id="myUL">
                  <li><span class="cart">Beverages</span>
                      <ul class="nested">
                          <li>Water</li>
                          <li>Coffee</li>
                          <li><span class="cart">Tea</span>
                              <ul class="nested">
                                  <li>Black Tea</li>
                                  <li>White Tea</li>
                                  <li><span class="cart">Green Tea</span>
                                      <ul class="nested">
                                          <li>Sencha</li>
                                          <li>Gyokuro</li>
                                          <li>Matcha</li>
                                          <li>Pi Lo Chun</li>
                                      </ul>
                                  </li>
                              </ul>
                          </li>  
                      </ul>
                  </li>
              </ul>
            </div>
          </div>
       </div>
       <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="">
                    <div class="form-group">
                    <label for="account_head">Head Code</label>
                    <input type="text" class="form-control" id="head_code" name="head_code">
                    </div>
                    <div class="form-group">
                    <label for="account_head">Head Name</label>
                    <input type="text" class="form-control" id="head_name" name="head_name">
                    </div>
                    <div class="form-group">
                    <label for="account_head">Parent Head</label>
                    <input type="text" class="form-control" id="parent_head" name="parent_head">
                    </div>
                    <div class="form-group">
                    <label for="account_head">Head Level</label>
                    <input type="text" class="form-control" id="account_head" name="account_head">
                    </div>
                    <div class="form-group">
                    <label for="account_level">Head Type</label>
                    <input type="text" class="form-control" id="account_level" name="account_level">
                    </div>
                    <button type="submit" class="btn btn-success">New</button>
                    <button type="submit" class="btn btn-default">Update</button>
                </form>
           </div>
        </div>
     </div>
   </div>
</div>
    

<script>
    var toggler = document.getElementsByClassName("cart");
    var i;
    
    for (i = 0; i < toggler.length; i++) {
      toggler[i].addEventListener("click", function() {
        this.parentElement.querySelector(".nested").classList.toggle("active");
        this.classList.toggle("cart-down");
      });
    }
    </script>


@stop
