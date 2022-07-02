<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

class TaskController extends BaseController
{
    //Stampa tutti i task
    public function getAll(){
        $tasks=Task::all();
        print_r($tasks);
    }

    //ricerca i Task di un job
    public function getJobTasks($jobId){
        $tasks=Task::where("job_id",$jobId)->get();
        return($tasks);
    }

    //conta i Task di un job
    public function countJobTasks($jobId){
        $nTasks=0;
        /*
        //pipeline tipo 1 per il conteggio
        $pipeline=[['$group' =>[
            '_id'=> '$job_id',
            'count'=> [
                '$sum'=> 1
            ]
        ]
        ]];
        //mi restituisce tutti i risultati gruppati per job_id che devo iterare
        $tasks=Task::raw()->aggregate($pipeline);
        foreach ($tasks as $task){
            var_dump($task);
        };
        */

        //cambio pipeline e faccio prima un match e poi un count per avere esattamente il numero
        $pipeline=[
            ['$match' =>[
                'job_id'=>intval($jobId)
                ]
            ],
            ['$count'=>'count']
        ];
        $tasks=Task::raw()->aggregate($pipeline);
        foreach ($tasks as $task){
            //devo comunque ciclare perchè mi viene restituito un cursore
            $nTasks=$task->count;
        };

        return $nTasks;
    }

    public function addTask($jobId){
        
    }
}