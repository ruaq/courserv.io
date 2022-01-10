<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\QsehService;
use Illuminate\Http\Request;

class QsehController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, QsehService $qsehService)
    {
        $course = Course::find(3);

        $respone = $qsehService->connect($course, 'update');

        dd($respone['response']);
    }
}
