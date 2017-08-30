<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;
use App\TaskChild;
use App\TaskStatus;

class TasksController extends Controller
{

    public function index()
    {

        //--- Build data
        $data = [];

        $tasks = Task::all();
        foreach ($tasks as $task) {
            $tmp = [
                'id'            => $task->id,
                'name'          => $task->name,
                'standalone'    => $task->standalone,
                'description'   => $task->description,
                'sources'       => $task->sources,
                'status'        => $task->status(),
                'type'          => $task->type(),
                'progress'      => ($task->standalone === true ? $task->progress : 0),
                'children'      => [],

                'created_at'    => $task->created_at,
                'updated_at'    => $task->updated_at
            ];

            if($task->standalone === false) {
                //--- Append Children
                $children = $task->children();

                if(!($children->exists())) {
                    //--- Add without children
                    $data[] = $tmp;
                    continue;
                }

                $children = $children->get();

                $childrenArray = [];
                $progress = 0;

                foreach ($children as $child) {

                    //--- Build
                    $childrenArray[] = [
                        'id'            => $child->id,
                        'name'          => $child->name,
                        'description'   => $child->description,
                        'status'        => $child->status()->first(),
                        'progress'      => $child->progress,
                        'type'          => $child->type()->first(),

                        'sources'       => $child->sources()->get(),

                        'created_at'    => $child->created_at,
                        'updated_at'    => $child->updated_at
                    ];

                    $progress += $child['progress'];
                }

                //@TODO Is the overall progress of the parent task just the average
                //of all sub tasks? There should be some kind of weight be assigned
                // to each task...
                $tmp['progress'] = ($progress / count($childrenArray));
                $tmp['children'] = $childrenArray;
            }

            $data[] = $tmp;
        }

        return $data;
    }

    public function show($id)
    {

        $data = [
            'id'            => null,
            'name'          => null,
            'standalone'    => false,
            'description'   => null,
            'status'        => null,
            'type'          => null,
            'progress'      => 0,

            'progress'      => 0,
            'children'      => []
        ];

        $task = Task::find($id);

        if($task === null) {
            return $data;
        }

        $data['id']             = $task->id;
        $data['name']           = $task->name;
        $data['standalone']     = $task->standalone;
        $data['description']    = $task->description;
        $data['sources']        = $task->sources;
        $data['status']         = $task->status();
        $data['type']           = $task->type();
        $data['progress']       = ($task->standalone === true ? $task->progress : 0);

        $data['created_at']     = $task->created_at;
        $data['updated_at']     = $task->updated_at;

        if($task->standalone !== true) {
            //--- Append Children
            $children = $task->children();

            if(!($children->exists())) {
                return $data;
            }

            $children = $children->get();

            $childrenArray = [];
            $progress = 0;

            foreach ($children as $child) {
                $childrenArray[] = [
                    'id'            => $child->id,
                    'name'          => $child->name,
                    'description'   => $child->description,
                    'status'        => $child->status()->first(),
                    'progress'      => $child->progress,
                    'type'          => $child->type()->first(),

                    'sources'       => $child->sources()->get(),


                    'created_at'    => $child->created_at,
                    'updated_at'    => $child->updated_at
                ];

                $progress += $child['progress'];
            }

            //@TODO Is the overall progress of the parent task just the average
            //of all sub tasks? There should be some kind of weight be assigned
            // to each task...
            $data['progress'] = ($progress / count($childrenArray));
            $data['children'] = $childrenArray;
        }

        return $data;
    }

    public function queue() {
        return \App\Task::queue();
    }

}
