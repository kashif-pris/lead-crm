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
	<div class="col-md-12">
        <div class="panel panel-defualt">
            <div class="panel-heading">
                <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
            </div>
            <div class="panel"  style="padding:22px;">
            <div class="row">
                    <div id="page-wrap">
                        <div class="badge">
                            <h1 style="text-align: center;margin-bottom: 100px;">ALLOTMENT CERTIFICATE</h1>
                        </div>

                        <img src="{{$qrimg}}" style="width:130px;height:130px;float:right;margin-top:-120px;">
                       <br>
                       <p style="float:right;margin-right:35px;margin-top:-8px;text-transform:capitalize;">@if(!empty($duplicateOrNot)){{$duplicateOrNot}}@else Orignal @endif </p>
                    </div>
                    <h2 style="text-align: center;">({{$bookOrder->plots->block->name}})</h2>
                    <table>
                   
                    
                    <tr style="height: 50px !important;">
                        <td>Name: {{$bookOrder->customers->sal_customer_name}}</td>
                        <td>House:</td>
                    </tr>
                    <tr style="height: 50px !important;">
                        <td>Address: {{strip_tags($bookOrder->customers->sal_customer_address_1)}}</td>
                        <td>Precinct:
                            <br style="margin-top: 20px;">
                            Street:
                        </td>
                    </tr>
                    <tr style="height: 50px !important;">
                        <td>CNIC: {{$bookOrder->customers->sal_customer_id}}</td>
                        <td>Size: ______________Sq. Yards</td>
                    </tr>
                    <tr style="height: 50px !important;">
                        <td>Contact: {{$bookOrder->customers->sal_customer_cell}}</td>
                        <td>Category:</td>
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
                    <b>Name:</b> {{$bookOrder->customers->sal_customer_name}} <b>S/O:</b> {{$bookOrder->customers->sal_customer_cont_person}} <b>R/O:</b>___________________________ <b>Allotted House No.</b> {{$bookOrder->plots->id}} <b> {{$bookOrder->plots->block->name}}</b> in 
                    DEFENCE CITY.<br>
                    <b>Sign of Allottee</b> _______________ <b>CNIC No</b>. {{$bookOrder->customers->sal_customer_id}}

                    </p>
                </div>
            </div>
            <br><br><br>
            <p style="padding:12px;float:right;text-transform:uppercase; font-family: "Monaco", "Lucida Console", monospace;">
                @if(!empty($duplicateOrNot)){{$duplicateOrNot}}@else Orignal @endif:{{$dateTime}}</p>
        </div>
      

           

    </div>
</div>
     
   
    
    


