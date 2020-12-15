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
            'iseditable' => isset($pars['iseditable']),
            'isyoutube' => isset($pars['isyoutube']),
            'from' => str_replace('T', ' ', $pars['from']),
            'to' => str_replace('T', ' ', $pars['to']),
            'permalink' => isset($pars['permalink']),
            'icon' => trim($pars['icon']),
            'fanart' => trim($pars['fanart']),
            'plot' => $pars['plot'],
            'ts_from' => 0,
            'ts_to' => 0,
            'retention_time' => 0
        );

        # some time calculations

        $dt = false;
        if (!empty($this->event['from'])) {
            if (DateTime::createFromFormat('Y-m-d H:i', $this->event['from'])) {
                $dt = DateTime::createFromFormat('Y-m-d H:i', $this->event['from']);
            }
            elseif (DateTime::createFromFormat('d.m.Y H:i', $this->event['from'])) {
                $dt = DateTime::createFromFormat('d.m.Y H:i', $this->event['from']);
            }
        } else {
            $dt = DateTime::createFromFormat('Y-m-d', $this->event['event_date']);
        }
        if ($dt) {
            $this->event['ts_from'] = $dt->getTimestamp();
            $this->event['ts_to'] = $dt->getTimestamp();
        }

        if (!empty($this->event['to'])) {
            if (DateTime::createFromFormat('Y-m-d H:i', $this->event['to'])) {
                $dt = DateTime::createFromFormat('Y-m-d H:i', $this->event['to']);
            }
            elseif (DateTime::createFromFormat('d.m.Y H:i', $this->event['to'])) {
                $dt = DateTime::createFromFormat('d.m.Y H:i', $this->event['to']);
            }
            if ($dt) $this->event['ts_to'] = $dt->getTimestamp();
        }
        $this->event['retention_time'] = ($this->event['permalink']) ? $this->event['ts_from'] + RETENTION_TIME_PERMA : $this->event['ts_to'] + RETENTION_TIME_TEMP;
    }

    function read($event_id) {
        if (is_file(DATA.$event_id)) {
            $this->read_raw($event_id);
            $this->event = json_decode($this->raw_data, true);
        } else {
            return false;
        }
        return true;
    }

    function read_raw($event_id) {
        if (is_file(DATA.$event_id)) {
            $this->raw_data = file_get_contents(DATA.$event_id);
        }
    }

    function persist() {
        $fh = fopen(DATA.$this->event['id'], 'w');
        fwrite($fh, json_encode($this->event, JSON_PRETTY_PRINT));
        fclose($fh);
    }
}
