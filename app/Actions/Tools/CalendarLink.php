<?php

namespace App\Actions\Tools;

use App\Models\Appointment;
use App\Models\Event;

class CalendarLink
{
    public $title;

    public $start;

    public $end;

    public $description;

    public $location;

    public $uid;

    private $dateTimeFormat = 'Ymd\THis';

    public function __construct(Appointment|Event $calendar)
    {
        $this->title = $calendar->name;
        $this->description = $calendar->description;
        $this->start = $calendar->start_time;
        $this->end = $calendar->end_time;
        $this->location = $calendar->address?->full_address;
        $this->uid = $calendar->pid;
    }

    public function google()
    {
        $url = 'https://calendar.google.com/calendar/render?action=TEMPLATE';
        $url .= '&text=' . urlencode($this->title);
        $url .= '&dates=' . urlencode($this->start->format($this->dateTimeFormat)) . '/'
            . urlencode($this->end?->format($this->dateTimeFormat) ?? $this->start->format($this->dateTimeFormat));
        if ($this->description) {
            $url .= '&details=' . urlencode($this->description);
        }
        if ($this->location) {
            $url .= '&location=' . urlencode($this->location);
        }

        return $url;
    }

    public function yahoo()
    {
        $url = 'https://calendar.yahoo.com/?v=60&view=d&type=20';
        $url .= '&TITLE=' . urlencode($this->title);
        $url .= '&ST=' . urlencode($this->start->format($this->dateTimeFormat)) . '&ET='
            . urlencode($this->end?->format($this->dateTimeFormat) ?? $this->start->format($this->dateTimeFormat));
        if ($this->description) {
            $url .= '&DESC=' . urlencode($this->description);
        }
        if ($this->location) {
            $url .= '&in_loc=' . urlencode($this->location);
        }

        return $url;
    }

    public function outlook()
    {
        $this->dateTimeFormat = 'Y-m-d\TH:i:s\Z';
        $url = 'https://outlook.live.com/calendar/0/deeplink/compose?path=/calendar/action/compose&rru=addevent';
        $url .= '&subject=' . urlencode($this->title);
        $url .= '&startdt=' . urlencode($this->start->format($this->dateTimeFormat)) . '&enddt=' .
            urlencode($this->end?->format($this->dateTimeFormat));
        if ($this->description) {
            $url .= '&body=' . urlencode($this->description);
        }
        if ($this->location) {
            $url .= '&location=' . urlencode($this->location);
        }

        return $url;
    }

//    public function ics()
//    {
//        $url = 'data:text/calendar;charset=utf8,';
//        $url .= "BEGIN:VCALENDAR
//        VERSION:2.0
//        BEGIN:VEVENT
//        UID:{$this->uid}
//        URL:" . url()->current() . "
//        DTSTART:{$this->start->format($this->dateTimeFormat)}
//        DTEND:" . ($this->end ?->format($this->dateTimeFormat) ?? $this->start->format($this->dateTimeFormat)) . "
//        SUMMARY:{$this->title}";
//
//        if ($this->description) {
//            $url .= "DESCRIPTION:{$this->description}";
//        }
//
//        if ($this->location) {
//            $url .= "LOCATION:{$this->location}";
//        }
//
//        $url .= "END:VEVENT
//        END:VCALENDAR";
//
//        return $url;
//    }
    public function ics()
    {
        $url = 'data:text/calendar;charset=utf8,';
        $prodId = '-//Moura Tech//Eleitorado//EN'; // Adicione uma identificação de produto (PRODID)


        $dtStamp = now()->format('Ymd\THis\Z'); // Adicione um carimbo de data/hora (DTSTAMP)

        $url .= "BEGIN:VCALENDAR\r\n";
        $url .= "VERSION:2.0\r\n";
        $url .= "CALSCALE:GREGORIAN\r\n";
//        $url .= "PRODID:{$prodId}\r\n";

        $url .= "BEGIN:VEVENT\r\n";
        $url .= "UID:{$this->uid}\r\n";
        $url .= "URL:" . url()->current() . "\r\n";
        $url .= "DTSTAMP:{$dtStamp}\r\n";
        $url .= "DTSTART:{$this->start->format('Ymd\THis\Z')}\r\n";
        $url .= "DTEND:" . ($this->end ?->format('Ymd\THis\Z') ?? $this->start->format('Ymd\THis\Z')) . "\r\n";
        $url .= "SUMMARY:{$this->title}\r\n";

        if ($this->description) {
            $url .= "DESCRIPTION:{$this->description}\r\n";
        }

        if ($this->location) {
            $url .= "LOCATION:{$this->location}\r\n";
        }

        $url .= "END:VEVENT\r\n";
        $url .= "END:VCALENDAR\r\n";

        return $url;
    }

    public function WebOffice()
    {
        $this->dateTimeFormat = 'Y-m-d\TH:i:s\Z';
        $url = 'https://outlook.office.com/calendar/deeplink/compose?path=/calendar/action/compose&rru=addevent';
        $url .= '?subject=' . urlencode($this->title);
        $url .= '&body=' . urlencode($this->description);
        $url .= '&location=' . urlencode($this->location);
        $url .= '&startdt=' . urlencode($this->start->toAtomString()) . '&enddt=' . urlencode($this->end?->format($this->dateTimeFormat));

        return $url;
    }

    public function WebOutlook()
    {
        $this->dateTimeFormat = 'Y-m-d\TH:i:s\Z';
        $url = 'https://outlook.live.com/calendar/deeplink/compose?path=/calendar/action/compose&rru=addevent';
        $url .= '&subject=' . urlencode($this->title);
        $url .= '&startdt=' . urlencode($this->start->format($this->dateTimeFormat)) . '&enddt=' . urlencode($this->end?->format($this->dateTimeFormat));
        $url .= '&body=' . urlencode($this->description);
        $url .= '&location=' . urlencode($this->location);

        return $url;
    }
}
