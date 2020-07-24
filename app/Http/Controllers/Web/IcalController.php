<?php

namespace Vanguard\Http\Controllers\Web;
use Vanguard\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Vanguard\WorkOrder;

class IcalController extends Controller
{
    /**
     * Gets the events data from the database
     * and populates the iCal object.
     *
     * @return void
     */
    public function getEventsICalObject($cid)
    {
        $events = WorkOrder::with('estimate')->where('companyId', $cid)->get();

        //dd($events);
        define('ICAL_FORMAT', 'Ymd\THis\Z');

        $icalObject = "BEGIN:VCALENDAR
       VERSION:2.0
       METHOD:PUBLISH
       PRODID:-//Charles Oduk//Tech Events//EN\n";

        // loop over events
        foreach ($events as $event) {
            $endTime = Carbon::parse($event->estimate->arrivalTime)->addHours(6)->format('H:i:s');
            $start = $event->estimate->dateofService.' '. $event->estimate->arrivalTime;
            $end = $event->estimate->dateofService.' '. $endTime;
            if($event->estimate->detailType == 1){$detailType = 'Shop Detail';} elseif($event->estimate->detailType == 2) { $detailType = "Mobile Detail";}else{ $detailType = "Detail";}
            $summary = $event->estimate->customer->firstName.' '.$event->estimate->customer->lastName;

            $icalObject .=
                "BEGIN:VEVENT
           DTSTART:" . date(ICAL_FORMAT, strtotime($start)) . "
           DTEND:" . date(ICAL_FORMAT, strtotime($end)) . "
           DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->created_at)) . "
           SUMMARY:$summary;
           UID:$event->id
           LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->updated_at)) . "
           LOCATION:$event->estimate->serviceAddress
           END:VEVENT\n";
        }

        // close calendar
        $icalObject .= "END:VCALENDAR";

        // Set the headers
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');

        $icalObject = str_replace(' ', '', $icalObject);

        echo $icalObject;
    }
}
