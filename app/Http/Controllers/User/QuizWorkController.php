<?php

namespace App\Http\Controllers\User;

use App\Events\UserOnline;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class QuizWorkController extends Controller
{
    public function updateOnlineStatus(Request $request)
    {
        UserOnline::dispatch(
            $request->quizId,
            auth('student')->user()->id,
            $request->status,
            $request->answerCount,
            $request->timeRemaining,
        );
    }
}
