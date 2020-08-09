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
        preg_match_all('/[0-9]+/', $pars['contributors'], $m);
        $this->event = array(
            'user' => $user,
            'user_id' => array_merge(array($user_id), $m[0]),
            'id' => $pars['item'],
            'event_date' => $pars['event_date'],
            'event' => $pars['event'],
            'genre' => $pars['genre'],
            'web' => trim($pars['web']),
            'stream' => trim($pars['stream']),
            'isyoutube' => isset($pars['isyoutube']),
            'from' => str_replace('T', ' ', $pars['from']),
            'to' => str_replace('T', ' ', $pars['to']),
            'permalink' => isset($pars['permalink']),
            'icon' => trim($pars['icon']),
            'fanart' => trim($pars['fanart']),
            'plot' => $pars['plot'],
            'ts_from' => 0,
            'ts_to' => 0
        );

        if (!empty($this->event['from'])) {
            try {
                $this->event['ts_from'] = DateTime::createFromFormat('Y-m-d H:i', $this->event['from'])->getTimestamp();
            } catch (Exception $e) {}
        }

        if (!empty($this->event['to'])) {
            try {
                $this->event['ts_to'] = DateTime::createFromFormat('Y-m-d H:i', $this->event['to'])->getTimestamp();
            } catch (Exception $e) {}
        }

    }

    function read($event_id) {
        if (is_file(DATA.$event_id)) {
            $fh = fopen(DATA.$event_id, 'r');
            $this->event = json_decode(fgets($fh), true);
            fclose($fh);
        } else {
            return false;
        }
        return true;
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
