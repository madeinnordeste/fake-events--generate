<?php

require_once 'vendor/autoload.php';

use Carbon\Carbon;


$QTTY = 3000;

$startDate  = new Carbon('first day of last Year', 'America/Sao_Paulo');
$endDate  = new Carbon('last day of next Year', 'America/Sao_Paulo');

$kinds = ['holiday', 'brand event', 'campaign'];
$statuses = [' confirmed', 'not confirmed'];



$faker = Faker\Factory::create();

$events = [];

for($i=1; $i<=$QTTY; $i++){



    $diffSeconds = $endDate->diffInSeconds($startDate);
    $randomSeconds =  rand(0, $diffSeconds);

    $currentDate = $startDate->copy()->addSeconds($randomSeconds);

    $organizerMail = $faker->email();

    $startDiff = (rand(0,72) * 60);
    $startEvent = $currentDate->copy()->addSeconds($startDiff);

    $endDiff = (rand(0,72) * 60);
    $endEvent = $startEvent->copy()->addSeconds($endDiff);

    
    $kind = $faker->randomElements($kinds)[0];
    $etag = '"'.$faker->isbn13().'"';
    $id = $faker->uuid();
    $status = $faker->randomElements($statuses)[0];
    $htmlLink = $faker->url();
    $created = $currentDate->format('Y-m-d\TH:i:s.v\Z');
    $updated = $currentDate->format('Y-m-d\TH:i:s.v\Z');
    $summary = $faker->sentence();
    $description = $faker->paragraph();
    $location = $faker->address();
    $creator = ['email' => $organizerMail, 'self' => true];
    $organizer = ['email' => $organizerMail, 'self' => true];
    $start =  ["dateTime" => $startEvent->format('Y-m-d\TH:i:s.v\Z')];
    $end = ["dateTime" => $endEvent->format('Y-m-d\TH:i:s.v\Z')];
    $iCalUID = $faker->uuid()."@google.com";
    $sequence =  0;
    $attendees = [
         [
             "email" => $organizerMail,
             "organizer" =>true,
             "self" => true,
             "responseStatus" => "accepted"
         ]
     ];
    $reminders = ["useDefault" => true ];

    $event = compact('kind', 'etag', 'id',
                     'status', 'htmlLink', 'created',
                     'updated', 'summary', 'description',
                     'location', 'creator', 'organizer',
                     'start', 'end', 'iCalUID', 'sequence',
                     'attendees', 'reminders');

    $events[] = $event;


}



$outputFile = 'output/'.$QTTY."-".date('Y-m-d_h_i_s').".json";

file_put_contents($outputFile, json_encode($events));
