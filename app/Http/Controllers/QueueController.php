<?php

namespace App\Http\Controllers;
use App\Jobs\ProcessSendMail;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function sendNotification($event) {
        ProcessSendMail::dispatch($event);

        return response()->json(['message' => 'Email queued successfully']);
    } 
}
