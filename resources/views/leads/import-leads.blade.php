<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Import Leads In CRM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    
        <link rel="stylesheet" href="/docs/css/bootstrap-4.5.2.min.css" type="text/css">
        <link rel="stylesheet" href="/docs/css/bootstrap-example.min.css" type="text/css">
        <link rel="stylesheet" href="/docs/css/prettify.min.css" type="text/css">
        <link rel="stylesheet" href="/docs/css/fontawesome-5.15.1-web/all.css" type="text/css">

        <script type="text/javascript" src="/docs/js/jquery-2.2.4.min.js"></script>
        <script type="text/javascript" src="/docs/js/bootstrap.bundle-4.5.2.min.js"></script>
        <script type="text/javascript" src="/docs/js/prettify.min.js"></script>

        <link rel="stylesheet" href="/dist/css/bootstrap-multiselect.css" type="text/css">
        <script type="text/javascript" src="/dist/js/bootstrap-multiselect.js"></script>
</head>

<body>
        <div class="container mt-5 text-center">
            <h2 class="mb-4">
            Import Export Excel
            </h2>
            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @php
                $user = Auth::user();
            @endphp
            @if($user->role_id != '5')
                <div class="row">
                    <div class="col-md-4">
                        <select id="multiple" multiple="multiple" class="form-control onchange"  name="agent_id[]">
                                @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" >
                                            @if($agent->role_id == 8)
                                                <span style="color:green !important; ">{{ $agent->name }}</span>
                                                @else
                                                {{$agent->name}}
                                            @endif
                                        </option>
                                @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group col-8 mb-4 ">
                        <div class="custom-file text-left">
                            <input type="file" name="file" class="custom-file-input" id="customFile" required>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-primary">Import Leads</button>
                <a class="btn btn-sm btn-success" href="{{ route('export-leads') }}">Export Leads</a>
            </form>
        </div>
</body>
<script>
    $('.').css('backgroundColor', function(){
        var inputval = $('.form-check-input').attr("value");
        alert(inputval);
        if (inputval === 37){
            return 'green';
        }
        else {
            return 'red';
        }
    });
</script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#multiple').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                maxHeight: 400,
                dropUp: true
            });
        });
    </script>
</html>