<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use Redirect;
class Block extends Model
{
    protected $table= "blocks";
    protected $fillable =[
        "id", "name", "description", "created_at",
        "updated_at"
    ];
    public function save(array $options = []){

        $projectTotalArea = Project::where('id',$this->project_id)->with('blocks')->first();
        $blocksTotal = Block::where('project_id',$this->project_id)->sum('total_marla');
        $total = $blocksTotal+$this->total_marla;
        if($blocksTotal+$this->total_marla > $projectTotalArea->total_marla){
            echo "<script>";
            echo "alert('Block area ".$total." cannot be greater than project area ". $projectTotalArea->total_marla ." ');";
            echo "window.history.back();";
            echo "</script>";
            die();
        }
      
        return parent::save();
    }

  

   
}
