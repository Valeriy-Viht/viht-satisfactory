<?php

namespace App\Modules\Http\Contracts;

use Workerman\Protocols\Http\Request;

interface IMiddleware {
    public function process(Request $request);
}