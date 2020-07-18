<?php

class Event
{
    public $event = NULL;
    public $raw_data = NULL;

    function create($pars, $user, $user_id) {
        $this->event = array(
            'user' => $user,
            'user_id' => $user_id,
            'id' => $pars['item'],
            'event_date' => $pars['event_date'],
            'event' => $pars['event'],
            'genre' => $pars['genre'],
            'stream' => $pars['stream'],
            'from' => str_replace('T', ' ', $pars['from']),
            'to' => str_replace('T', ' ', $pars['to']),
            'icon' => $pars['icon'],
            'fanart' => $pars['fanart'],
            'plot' => $pars['plot'],
            'event_ts' => NULL
        );
        if (!empty($this->event['from'])) {
            $this->event['event_ts'] = DateTime::createFromFormat('Y-m-d H:i', $this->event['from'])->getTimestamp();
        }
    }

    function read($event_id) {
        if (is_file(DATA.$event_id)) {
            $fh = fopen(DATA.$event_id, 'r');
            $this->event = json_decode(fgets($fh), true);
            fclose($fh);
        }
    }

    function read_raw($event_id) {
        if (is_file(DATA.$event_id)) {
            $fh = fopen(DATA . $event_id, 'r');
            $this->raw_data = fgets($fh);
            fclose($fh);
        }
    }

    function persist() {
        $fh = fopen(DATA.$this->event['id'], 'w');
        fwrite($fh, json_encode($this->event));
        fclose($fh);
    }
}
