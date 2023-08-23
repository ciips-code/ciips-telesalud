<?php

function notify(\App\Models\Videoconsultation $videoconsultation, $topic) {
    if(is_array($videoconsultation->extra) && isset($videoconsultation->extra['notification_url'])) {
        $url = $videoconsultation->extra['notification_url'];
    } else {
        $url = config('app.notifications.url');
    }

    if($url) {
        $request = \Illuminate\Support\Facades\Http::asJson();
        if($token = config('app.notifications.token')) {
            $request->withToken($token);
        }
        $request->post($url, [
            'vc' => $videoconsultation->only(['secret', 'medic_secret', 'status',
                'medic_attendance_date', 'patient_attendance_date', 'start_date', 'finish_date', 'extra']),
            'topic' => $topic
        ]);
    }
}
