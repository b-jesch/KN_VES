<?php

class Event
{
    public $event = NULL;
    public $raw_data = NULL;

    function __construct() {
        if (!is_dir(DATA)) {
            mkdir(DATA);
        }
    }

    function create($pars, $user, $user_id) {
        $this->event = array(
            'user' => $user,
            'user_id' => $user_id,
            'id' => $pars['item'],
            'event_date' => $pars['event_date'],
            'event' => $pars['event'],
            'genre' => $pars['genre'],
            'stream' => $pars['stream'],
            'isyoutube' => (isset($pars['isyoutube'])) ? true : false,
            'from' => str_replace('T', ' ', $pars['from']),
            'to' => str_replace('T', ' ', $pars['to']),
            'permalink' => (isset($pars['permalink'])) ? true : false,
            'icon' => $pars['icon'],
            'fanart' => $pars['fanart'],
            'plot' => $pars['plot'],
            'ts_from' => 0,
            'ts_to' => 0
        );
        if (!empty($this->event['from'])) {
            $this->event['ts_from'] = DateTime::createFromFormat('Y-m-d H:i', $this->event['from'])->getTimestamp();
        }
        if (!empty($this->event['to'])) {
            $this->event['ts_to'] = DateTime::createFromFormat('Y-m-d H:i', $this->event['to'])->getTimestamp();
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
