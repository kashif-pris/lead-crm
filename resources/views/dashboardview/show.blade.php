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

    <script>
       window.onload = function () {
	
        var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title: {
		text: ""
	},
	subtitles: [{
		text: "In Area",
		fontSize: 16
	}],
	axisY: {
		prefix: "",
		scaleBreaks: {
			customBreaks: [{
				startValue: 10000,
				endValue: 35000
			}]
		}
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0 Follow Ups",
		dataPoints: [
            @foreach ( $agent_count as $item)

                { label: "{{nl2br(@$item['name']." Leads ". (@$item['agent_lead_count_count']) ) }}", y: {{$item['agent_call_count_count']}}},
                    
                @endforeach
		       ]
	     }]
});
chart.render();

    

    var charts = new CanvasJS.Chart("chartsContainer", {
                exportEnabled: true,
                animationEnabled: true,
                title:{
                    text: ""
                },
                legend:{
                    cursor: "pointer",
                    itemclick: explodePies
                },
                data: [{
                    type: "column",
                    showInLegend: true,
                    toolTipContent: "{name}: <strong>{y}</strong>",
                    indexLabel: "{name} - {y}",
                    dataPoints: [
                        @foreach ($plot_booked as $item)
                         { y: {{$item['count']}}, name: "{{$item['is_booked'] == 1 ? 'Booked' : 'Un booked'}}", exploded: true },
                        @endforeach
                    ]
                }]
            });
            charts.render();
            }
            
            function explodePies (e) {
                if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
                    e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
                } else {
                    e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
                }
                e.charts.render();
    
    }
        </script>

 
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

    

    
</style>


    <div class="container" style="    margin-top: 50px;">
        <div class="row placeholders">

            <div class=" col-sm-4 placeholder">
                <div class="panel panel-blue">
                    <div class="panel-heading"><h3>Leads</h3></div>
                    <div class="panel-body"><a href="/admin/leads/create"> <h4><span class="voyager-list-add"> </span> Create</a></h3></div>
                    <div class="panel-footer"><a href="/admin/leads/get-filter/New Leads"> <h4><span class="voyager-list"> </span> Records</a>  <span class="badge badge-default">{{$customer}}</span></h3></div>
                </div>
            </div>

            <div class=" col-sm-4 placeholder">
                <div class="panel panel-orange">
                    <div class="panel-heading"><h3>Agents</h3></div>
                    <div class="panel-body"><a href="/admin/agent/create"> <h4><span class="voyager-list-add"> </span> Create</a></h3></div>
                    <div class="panel-footer"><a href="/admin/agent/record"> <h4><span class="voyager-list"> </span> Records</a>  <span class="badge badge-default">{{$agent}}</span></h3></div>
                </div>
            </div>

            

            <div class=" col-sm-4 placeholder">
                <div class="panel panel-purple">
                    <div class="panel-heading"><h3>Files</h3></div>
                    <div class="panel-body"><a href="/admin/plot/create"> <h4><span class="voyager-list-add"> </span> Create</a></h3></div>
                    <div class="panel-footer"><a href="/admin/plot/record"> <h4><span class="voyager-list"> </span> Records</a>  <span class="badge badge-default">{{$plot}}</span></h3></div>
                </div>
            </div>

            


            

          
           

            <div class=" col-sm-12 placeholder">
                <div class="panel panel-cyan">
                    <div class="panel-heading"><h3>Agent Wise Leads Status</h3></div>
                    <div class="panel-body"><div id="chartContainer" style="height: 370px; width: 100%;"></div></div>
                    <div class="panel-footer"></div>
                </div>
            </div>

            

            

           

         </div>
     </div>

@stop



