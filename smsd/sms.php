<?php

//database connection
define('DB_SERVER', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', 'smstools');
define('DB_CODEPAGE', 'latin1');
define('DIR', '/var/spool/sms/outgoing');

//connect database engine
$connectionAdm = mysql_pconnect(DB_SERVER, DB_USER, DB_PASS);
mysql_select_db(DB_NAME, $connectionAdm);
mysql_query('SET character_set_client='.DB_CODEPAGE, $connectionAdm);
mysql_query('SET character_set_connection='.DB_CODEPAGE, $connectionAdm);
mysql_query('SET character_set_results='.DB_CODEPAGE, $connectionAdm);
mysql_query('SET character_set_server='.DB_CODEPAGE, $connectionAdm);

//sending messages
$res = mysql_query('
SELECT *
  FROM `sms_queue`
 WHERE sent = 0');
while ($ret = mysql_fetch_array($res))
{
    $priority = $ret['priority'] == 1 ? "\n".'Priority: High' : '';
    $from = $ret['from'] != '' ? 'From: '.$ret['from']."\n" : '';

    $f = fopen(DIR.'/sms-'.$ret['id_sms_queue'], 'w');
    fwrite($f, $from.'To: '.$ret['number'].'
Alphabet: ISO'.$priority.'
Report: '.$ret['report'].'

'.stripslashes($ret['text']));
    fclose($f);

    mysql_query('UPDATE `sms_queue` SET sent = 1 WHERE id_sms_queue = '.$ret['id_sms_queue']);
}

mysql_close($connectionAdm);

?>
