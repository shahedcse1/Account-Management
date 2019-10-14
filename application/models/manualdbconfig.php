<?php

class Manualdbconfig extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getconfigval($shopid) {
        if ($shopid != "default"):
            $this->db->select('*');
            $this->db->where('id', $shopid);
            $rowdata = $this->db->get('shopdetails');
            $dbconfig['hostname'] = "localhost";
            $dbconfig['username'] = $rowdata->row()->dbUser;
            $dbconfig['password'] = $rowdata->row()->dbPass;
            $dbconfig['database'] = $rowdata->row()->dbName;
            $dbconfig['dbdriver'] = $rowdata->row()->connectionType;
            $dbconfig['dbprefix'] = '';
            $dbconfig['pconnect'] = TRUE;
            $dbconfig['db_debug'] = TRUE;
            $dbconfig['cache_on'] = FALSE;
            $dbconfig['cachedir'] = '';
            $dbconfig['char_set'] = 'utf8';
            $dbconfig['dbcollat'] = 'utf8_general_ci';
            $dbconfig['swap_pre'] = '';
            $dbconfig['autoinit'] = TRUE;
            $dbconfig['stricton'] = FALSE;
            return $dbconfig;
        else:
            $this->load->database();
            $db['hostname'] = $this->db->hostname;
            $db['username'] = $this->db->username;
            $db['password'] = $this->db->password;
            $db['database'] = $this->db->database;
            $db['dbdriver'] = 'mysql';
            $db['dbprefix'] = '';
            $db['pconnect'] = TRUE;
            $db['db_debug'] = TRUE;
            $db['cache_on'] = FALSE;
            $db['cachedir'] = '';
            $db['char_set'] = 'utf8';
            $db['dbcollat'] = 'utf8_general_ci';
            $db['swap_pre'] = '';
            $db['autoinit'] = TRUE;
            $db['stricton'] = FALSE;
            return $db;
        endif;
    }

}
