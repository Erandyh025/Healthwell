<?php

namespace App\Shared;

use Illuminate\Support\Facades\Log;


class LogManage {

    public  function emergency($class, $function, $message)
    {
        Log::emergency("$class - $function - $message");
    }

    public  function alert($class, $function,$message)
    {
        Log::alert("$class - $function - $message");
    }

    public  function info($class, $function,$message)
    {
        Log::info("$class - $function - $message");
    }

    /*
     *  Log::emergency($message);
        Log::alert($message);
        Log::critical($message);
        Log::error($message);
        Log::warning($message);
        Log::notice($message);
        Log::info($message);
        Log::debug($message);
     * */
}