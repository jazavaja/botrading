<?php

namespace App\Http\Controllers;

use App\Jobs\Tests;

class Test extends Controller
{
    public function testAddJob()
    {
        for ($i=0;$i<100;$i++)
        {
            Tests::dispatch();
        }
    }
}