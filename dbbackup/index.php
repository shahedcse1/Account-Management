<?php

/**
 * 
 * MySQL DB Backup Class v1
 * Date 7 January 2015
 * @auther: Yousuf Khan
 * */
/**
 * Spacified tables
 * */
//include('class.dbbackup.php');
include('config.php');
/*
  try {
  $db = new DBBackup(HOST, USERNAME, PASSWORD, DATABASE);
  $db->table();
  $db->path(PATH);
  $db->backUp();
  $db->close();
  echo "success";
  } catch (Exception $e) {
  die($e->getMessage());
  } */

backup_tables(HOST, USERNAME, PASSWORD, DATABASE);

function backup_tables($host, $user, $pass, $name, $tables = '*') {
    $return = "";
    $link = mysql_connect($host, $user, $pass);
    mysql_select_db($name, $link);

    //get all of the tables
    if ($tables == '*') {
        $tables = array();
        $result = mysql_query('SHOW TABLES');
        while ($row = mysql_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    //cycle through
    foreach ($tables as $table) {
        $result = mysql_query('SELECT * FROM ' . $table);
        $num_fields = mysql_num_fields($result);

        $return.= 'DROP TABLE ' . $table . ';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));
        $return.= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysql_fetch_row($result)) {
                $return.= 'INSERT INTO ' . $table . ' VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = ereg_replace("\n", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $return.= '"' . $row[$j] . '"';
                    } else {
                        $return.= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return.= ',';
                    }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    //save file
    $files = glob("cloudpro-*.sql");
    foreach ($files as $sfile) {
        unlink($sfile);
    }
    $File = 'cloudpro-' . date('d-m-Y-H-i-s') . '.sql';
    $handle = fopen($File, 'w+');
    fwrite($handle, $return);
    fclose($handle);
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($File));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($File));
    readfile($File);
    exit;
}

?>