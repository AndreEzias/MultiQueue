<?php

return [
    "num_queue_process" => env("NUM_QUEUE_PROCS", 5),
    "connection" => env('QUEUE_CONNECTION', 'sync')
];
