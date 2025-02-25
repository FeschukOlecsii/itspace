<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Jobs\ProcessSendMail;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DateTime;


class EventController extends Controller
{
    /**
     * Display the events form.
     */
    public function index()
    {
        return view('events.event');
    }
    /**
     * Send events to app.js from database to processing information.
     */
    public function setEvents(Request $request)
    {
        $reminders = Reminder::all();
        $reminders2 = Event::all();
        $events = [];
        //генерує повторюваність події на 2 роки
        $endDate = Carbon::now()->addYear(2);

        foreach ($reminders as $reminder) {

            $startDate = Carbon::parse($reminder->date_time);
            if ($reminder->recurrence === 'specified_days') {
                $startDate = Carbon::parse($reminder->date_time);
                $recurrenceDays = json_decode($reminder->recurrence_days);

                foreach ($recurrenceDays as $day) {
                    $nextEventDate = $startDate->copy()->next($day);
                    while ($nextEventDate->lessThan($endDate)) {
                        if (Auth::user()->id == $reminder->user_id) {
                            $event = [
                                'id' => $reminder->id,
                                'user_id' => $reminder->user_id,
                                'title' => $reminder->title,
                                'start' => $nextEventDate->toDateTimeString(),
                                'color' => $reminder->color,
                                'recurrence' => $reminder->recurrence,
                                'recurrence_days' => $reminder->recurrence_days,
                                'recurrence_day_of_month' => $reminder->recurrence_day_of_month,
                                'recurrence_day_of_year' => $reminder->recurrence_day_of_year,
                                'type' => $reminder->type,
                                'completed' => $reminder->completed,
                            ];
                            $events[] = $event;
                            $nextEventDate->addWeek();
                        }
                    }
                }
            } elseif ($reminder->recurrence === 'monthly') {
                $dayOfMonth = $startDate->day;

                while ($startDate->lessThan($endDate)) {
                    if (Auth::user()->id == $reminder->user_id) {
                        $event = [
                            'id' => $reminder->id,
                            'user_id' => $reminder->user_id,
                            'title' => $reminder->title,
                            'start' => $startDate->toDateTimeString(),
                            'color' => $reminder->color,
                            'recurrence' => $reminder->recurrence,
                            'recurrence_days' => $reminder->recurrence_days,
                            'recurrence_day_of_month' => $reminder->recurrence_day_of_month,
                            'recurrence_day_of_year' => $reminder->recurrence_day_of_year,
                            'type' => $reminder->type,
                            'completed' => $reminder->completed

                        ];
                        $events[] = $event;
                        $startDate->addMonth();
                        $startDate->day($dayOfMonth);
                    }
                }
            } elseif ($reminder->recurrence === 'yearly') {
                while ($startDate->lessThan($endDate)) {
                    if (Auth::user()->id == $reminder->user_id) {
                        $event = [
                            'id' => $reminder->id,
                            'user_id' => $reminder->user_id,
                            'title' => $reminder->title,
                            'start' => $startDate->toDateTimeString(),
                            'color' => $reminder->color,
                            'recurrence' => $reminder->recurrence,
                            'recurrence_days' => $reminder->recurrence_days,
                            'recurrence_day_of_month' => $reminder->recurrence_day_of_month,
                            'recurrence_day_of_year' => $reminder->recurrence_day_of_year,
                            'type' => $reminder->type,
                            'completed' => $reminder->completed
                        ];
                        $events[] = $event;
                        $startDate->addYear();
                    }
                }
            } elseif ($reminder->recurrence === 'daily') {
                while ($startDate->lessThan($endDate)) {
                    if (Auth::user()->id == $reminder->user_id) {
                        $event = [
                            'id' => $reminder->id,
                            'user_id' => $reminder->user_id,
                            'title' => $reminder->title,
                            'start' => $startDate->toDateTimeString(),
                            'color' => $reminder->color,
                            'recurrence' => $reminder->recurrence,
                            'recurrence_days' => $reminder->recurrence_days,
                            'recurrence_day_of_month' => $reminder->recurrence_day_of_month,
                            'recurrence_day_of_year' => $reminder->recurrence_day_of_year,
                            'type' => $reminder->type,
                            'completed' => $reminder->completed
                        ];
                        $events[] = $event;
                        $startDate->addDay();
                    }
                }
            } else {
                if (Auth::user()->id == $reminder->user_id) {
                    $event = [
                        'id' => $reminder->id,
                        'user_id' => $reminder->user_id,
                        'title' => $reminder->title,
                        'start' => $reminder->date_time,
                        'color' => $reminder->color,
                        'recurrence' => $reminder->recurrence,
                        'recurrence_days' => $reminder->recurrence_days,
                        'recurrence_day_of_month' => $reminder->recurrence_day_of_month,
                        'recurrence_day_of_year' => $reminder->recurrence_day_of_year,
                        'type' => $reminder->type,
                        'completed' => $reminder->completed

                    ];
                    $events[] = $event;
                }
            }
        }

        foreach ($reminders2 as $reminder2) {

            $event = [
                'id' => $reminder2->id,
                'title' => $reminder2->title,
                'start' => $reminder2->date_time_start,
                'end' => $reminder2->date_time_end,
                'color' => $reminder2->color,
                'type' => $reminder2->type,
                'completed' => $reminder2->completed,
                'extendedProps' => [
                    'title' => $reminder2->title,
                    'start' => $reminder2->date_time_start,
                    'end' => $reminder2->date_time_end,
                    'color' => $reminder2->color,
                    'type' => $reminder2->type,
                    'completed' => $reminder2->completed
                ]
            ];
            $events[] = $event;
        }

        return response($events);
    }
    /**
     * Add reminder to database.
     */
    public function addReminder(Request $request)
    {
        $event = [
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'color' => $request->color,
            'date_time' => $request->date . " " . $request->time,
            'recurrence' => $request->recurrence,

        ];
        if ($request->recurrence === 'Specified days') {

            foreach ($request->days as $day) {
                if (isset($event['recurrence_days']) && is_array($event['recurrence_days'])) {
                    array_push($event['recurrence_days'], $day);
                } else {
                    $event['recurrence_days'] = [$day];
                }
            }
            $event['recurrence'] = 'specified_days';
            $event['recurrence_days'] = json_encode($event['recurrence_days']);
        } else if ($request->recurrence === 'Monthly') {
            $dateTime = new DateTime($request->date);
            $month = $dateTime->format('d');
            $event['recurrence_day_of_month'] = $month;
        } else if ($request->recurrence === 'Yearly') {
            $event['recurrence_day_of_year'] = $request->date;
        }
        $event['type'] =  $request->type;

        Reminder::create($event);
        ProcessSendMail::dispatch($event);
        return redirect()->route('event.index');
    }
    /**
     * Add event to database.
     */
    public function addEvent(Request $request)
    {
        $event = [
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'color' => $request->color,
            'date_time_start' => $request->date_start . " " . $request->time_start,
            'date_time_end' => $request->date_end . " " . $request->time_end,
            'type' => $request->type
        ];
        Event::create($event);
        ProcessSendMail::dispatch($event);
        return redirect()->route('event.index');
    }
    /**
     * Update reminder in database.
     */
    public function updateReminder(Request $request)
    {

        $event = [
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'color' => $request->color,
            'date_time' => $request->date . " " . $request->time,
            'recurrence' => $request->update_recurrence,
        ];

        if ($request->update_recurrence === 'Specified days') {

            foreach ($request->days as $day) {
                if (isset($event['recurrence_days']) && is_array($event['recurrence_days'])) {
                    array_push($event['recurrence_days'], $day);
                } else {
                    $event['recurrence_days'] = [$day];
                }
            }
            $event['recurrence'] = 'specified_days';

            $event['recurrence_days'] = json_encode($event['recurrence_days']);
        } else if ($request->update_recurrence === 'Monthly') {
            $dateTime = new DateTime($request->date);
            $month = $dateTime->format('d');
            $event['recurrence_day_of_month'] = $month;
        } else if ($request->update_recurrence === 'Yearly') {
            $event['recurrence_day_of_year'] = $request->date;
        }
        $event['type'] =  $request->type;

        if ($request->completed_reminder == 'on') {
            $event['completed'] =  true;
        } else {
            $event['completed'] =  false;
        }

        Reminder::create($event);
        ProcessSendMail::dispatch($event);
        $controller = new EventController();
        return $controller->destroyReminder($request->id);
    }
    /**
     * Update event in database.
     */
    public function updateEvent(Request $request)
    {
        $event = [
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'color' => $request->color,
            'date_time_start' => $request->date_start . " " . $request->time_start,
            'date_time_end' => $request->date_end . " " . $request->time_end,
            'type' => $request->type,
        ];
        if ($request->completed_event == 'on') {

            $event['completed'] =  true;
        } else {
            $event['completed'] =  false;
        }
        Event::create($event);
        ProcessSendMail::dispatch($event);
        $controller = new EventController();
        return $controller->destroyEvent($request->id);
    }
    /**
     * Delete reminder from database.
     */
    public function destroyReminder($id)
    {
        $event = Reminder::findOrFail($id);
        $event->delete();
        return redirect()->route('event.index');
    }
    /**
     * Delete event from database.
     */
    public function destroyEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('event.index');
    }
    /**
     * Mark reminder as completed.
     */
    public function completeReminder($id)
    {
        $event = Reminder::find($id);
        if ($event->completed == true) {
            return redirect()->route('event.index');
        }
        $event->completed = true;
        $event->save();
        return redirect()->route('event.index');
    }
    /**
     * Mark event as completed.
     */
    public function completeEvent($id)
    {
        $event = Event::find($id);
        if ($event->completed == true) {
            return redirect()->route('event.index');
        }
        $event->completed = true;
        $event->save();
        return redirect()->route('event.index');
    }
}
