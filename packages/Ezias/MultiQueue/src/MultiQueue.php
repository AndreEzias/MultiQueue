<?php

namespace Ezias\MultiQueue;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\DB;

class MultiQueue
{
    public function getNextProcess()
    {
        $queues = $this->getQueueList();
        $lastJob = $this->getLastJobQueued();
        $nextQueue = "process_00";

        if (is_null($lastJob)) {
            return $nextQueue;
        }

        foreach ($queues as $key => $queue) {
            if ($lastJob->queue === $queue) {
                $nextQueue = $queues[$key+1] ?? $nextQueue;
            }
        }

        return $nextQueue;
    }

    protected function getLastJobQueued()
    {
        $queueConnection = config("multiqueue.connaction");

        if ($queueConnection == "database") {
            return DB::table("jobs")->get()->last();
        }

        return Queue::after(function (JobProcessed $event) {
            if (Queue::size($event->job->getQueue()) == 0) {
                return $event->job->getQueue();
            }
        });
    }

    protected function getQueueList()
    {
        $procs = array_fill(0, config("multiqueue.num_process"), "process_");
        $queues = [];

        foreach ($procs as $key => $value) {
            $zero = $key < 10 ? "0":"";
            $queues[]=$value.$zero.$key;
        }

        return $queues;
    }
}
