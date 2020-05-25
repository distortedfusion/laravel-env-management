<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Commands
    |--------------------------------------------------------------------------
    |
    | This array of commands will be registered when the application is started.
    | Feel free to disable commands by removing them from the list or
    | commenting them out.
    |
    */

    'commands' => [
        \DistortedFusion\Env\Commands\AppVersionCommand::class,
        \DistortedFusion\Env\Commands\KeySetCommand::class,
    ],

];
