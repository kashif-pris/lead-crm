<?php

namespace App\Imports;

use App\Models\Leads;
use Illuminate\Support\Collection;
use \Maatwebsite\Excel\Concerns\ToCollection;
use \Maatwebsite\Excel\Concerns\Importable;
use \App\Models\User;
use Auth;
use Session;
use Illuminate\Support\Carbon;
class ImportLeads implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /**
     * @return int
     */
    use Importable;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
            $rows = $collection->toArray();
            unset($rows[0]);
            // dd($rows,'leads');
            $agents = Session::get('agents');
            // dd($agents);
            $perAgent = round(count($rows) / count($agents));
            $checking = $perAgent*count($agents);
            if($perAgent > 0){
                $difference = count($rows) - $checking;
            }else{
                $difference = 0;
            }
            // dd(count($rows), count($agents),$perAgent);
            // dd($difference,$agents);
                        $agentIndex = 0;
                        $index = 1;
                        $result = [];
                        if($perAgent >= 1){
                            foreach($rows as $rowKey => $row) {
                            //    dd($row);
                                $date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]))->format('Y-m-d');
                            
                                if($index <= $perAgent){
                                    
                                        try {
                                            if(array_key_exists($agentIndex, $agents)){
                                                // $result[$agents[$agentIndex]->id][] = $row[2];
                                                // dd($agents[$agentIndex]->id);
                                                if($row[1] != ''){
                                                    $checkphone = Leads::where('phone',(string)$row[2])->first();
                                                    if(empty($checkphone)){
                                                            Leads::create([
                                            
                                                                'created_at'=>$date,
                                                                'name'=>$row[1],
                                                                'email'=>$row[3],
                                                                'phone'=>$row[2],
                                                                'description'=>$row[4],
                                                                'project_name'=>$row[5],
                                                                'source'=> $row[6],
                                                                'created_by'=>Auth::user()->id,
                                                                'allocated_to'=>$agents[$agentIndex],
                                                                'status'=>'New Leads',
                                                                'temperature'=>'Moderate',
                                                            
                                                            ]);
                                                        }else{
                                                            Leads::create([
                                            
                                                                'created_at'=>$date,
                                                                'name'=>$row[1],
                                                                'email'=>$row[3],
                                                                'phone'=>$row[2],
                                                                'description'=>$row[4],
                                                                'project_name'=>$row[5],
                                                                'source'=> $row[6],
                                                                'created_by'=>Auth::user()->id,
                                                                'allocated_to'=> '1',
                                                                'status'=>'Duplicate Lead',
                                                                'temperature'=>'Moderate',
                                                            
                                                            ]);
                                                        }
                                                    }
                                                $index++;
                                                }
                                        
                                            

                                        } catch (\Exception $exception) {
                                            dd($exception);
                                            Log::error($exception);
                                        }
                                    }else{
                                        
                                        $agentIndex++;
                                        $index = 1;
                                        
                                        
                                    
                                        if(array_key_exists($agentIndex, $agents)){
                                            $agent =$agents[$agentIndex]; 
                                            // $result[$agent][] = $row[2];
                                            // dd($agent);
                                            $checkphone = Leads::where('phone',(string)$row[2])->first();
                                            if(empty($checkphone)){
                                                    Leads::create([
                                    
                                                        'created_at'=>$date,
                                                        'name'=>$row[1],
                                                        'email'=>$row[3],
                                                        'phone'=>$row[2],
                                                        'description'=>$row[4],
                                                        'project_name'=>$row[5],
                                                        'source'=> $row[6],
                                                        'created_by'=>Auth::user()->id,
                                                        'allocated_to'=>$agents[$agentIndex],
                                                        'status'=>'New Leads',
                                                        'temperature'=>'Moderate',
                                                    
                                                    ]);
                                                }else{
                                                    Leads::create([
                                    
                                                        'created_at'=>$date,
                                                        'name'=>$row[1],
                                                        'email'=>$row[3],
                                                        'phone'=>$row[2],
                                                        'description'=>$row[4],
                                                        'project_name'=>$row[5],
                                                        'source'=> $row[6],
                                                        'created_by'=>Auth::user()->id,
                                                        'allocated_to'=> '1',
                                                        'status'=>'Duplicate Lead',
                                                        'temperature'=>'Moderate',
                                                    
                                                    ]);
                                                }
                                        }
                                        $index++;
                                    }

                            }
                        }else{
                            foreach($rows as $key=>$last){
                                if(array_key_exists($agentIndex, $agents)){
                                    $agent =$agents[$agentIndex]; 
                                    $date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($last[0]))->format('Y-m-d');
                                    if($last[1] != ''){
                                        $checkphone = Leads::where('phone',(string)$row[2])->first();
                                        if(empty($checkphone)){
                                                Leads::create([
                                
                                                    'created_at'=>$date,
                                                    'name'=>$row[1],
                                                    'email'=>$row[3],
                                                    'phone'=>$row[2],
                                                    'description'=>$row[4],
                                                    'project_name'=>$row[5],
                                                    'source'=> $row[6],
                                                    'created_by'=>Auth::user()->id,
                                                    'allocated_to'=>$agents[$agentIndex],
                                                    'status'=>'New Leads',
                                                    'temperature'=>'Moderate',
                                                
                                                ]);
                                            }else{
                                                Leads::create([
                                
                                                    'created_at'=>$date,
                                                    'name'=>$row[1],
                                                    'email'=>$row[3],
                                                    'phone'=>$row[2],
                                                    'description'=>$row[4],
                                                    'project_name'=>$row[5],
                                                    'source'=> $row[6],
                                                    'created_by'=>Auth::user()->id,
                                                    'allocated_to'=> '1',
                                                    'status'=>'Duplicate Lead',
                                                    'temperature'=>'Moderate',
                                                
                                                ]);
                                            }
                                    }
                                    $agentIndex++;
                                }
                               
                            }
                        }
                        if($difference > 0){
                            $RemainingItems = array_slice($rows, -$difference);
                            // dd($agents)
                            foreach($RemainingItems as $key=>$last){
                                if(array_key_exists($key, $agents)){
                                    $agent =$agents[$key]; 
                                    // $result[$agent][] = $last[2];
                                    if($last[1] != ''){
                                        $checkphone = Leads::where('phone',(string)$row[2])->first();
                                        if(empty($checkphone)){
                                                Leads::create([
                                
                                                    'created_at'=>$date,
                                                    'name'=>$row[1],
                                                    'email'=>$row[3],
                                                    'phone'=>$row[2],
                                                    'description'=>$row[4],
                                                    'project_name'=>$row[5],
                                                    'source'=> $row[6],
                                                    'created_by'=>Auth::user()->id,
                                                    'allocated_to'=>$agents[$key],
                                                    'status'=>'New Leads',
                                                    'temperature'=>'Moderate',
                                                
                                                ]);
                                            }else{
                                                Leads::create([
                                
                                                    'created_at'=>$date,
                                                    'name'=>$row[1],
                                                    'email'=>$row[3],
                                                    'phone'=>$row[2],
                                                    'description'=>$row[4],
                                                    'project_name'=>$row[5],
                                                    'source'=> $row[6],
                                                    'created_by'=>Auth::user()->id,
                                                    'allocated_to'=> '1',
                                                    'status'=>'Duplicate Lead',
                                                    'temperature'=>'Moderate',
                                                
                                                ]);
                                            }
                                    }
                                }
                               
                            }
                            
                        }
            // dd($result);
    }
}
