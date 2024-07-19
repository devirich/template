<?php

use App\Database\DB;

class LogModel extends DB
{
    private $result = null;

    public function createLogLogin($userid)
    {
        $values = array(
            'user_id' => $userid,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'date_log' => date('Y-m-d'),
            'time_log' => date('H:i:s')
        );
        $this->result = DB::insertSQL('tb_loglogin', $values);
        if ($this->result) {
            return true;
        } else {
            return false;
        }
    }

    public function createLog($userid, $action)
    {
        $values = array(
            'user_id' => $userid,
            'action' => $action,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'date_log' => date('Y-m-d'),
            'time_log' => date('H:i:s')
        );
        $this->result = DB::insertSQL('tb_logaction', $values);
        if ($this->result) {
            return true;
        } else {
            return false;
        }
    }
}
