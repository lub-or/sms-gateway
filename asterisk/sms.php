<?php

//database connection
define('DB_SERVER', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', 'smstools');
define('DB_CODEPAGE', 'latin1');
define('DIR', '/home/lubo/cron/sms/outgoing');

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
    if (strlen($ret['text']) <= 160)
	$text = array($ret['text']);
    else {
	$text = array();
	while (strlen($ret['text']) > 151) {
	    $text[] = mb_substr($ret['text'], 0, 151);
	    $ret['text'] = mb_substr($ret['text'], 151, 99999);
	}
	$text[] = $ret['text'];
    }

    for ($i=0; $i<count($text); $i++) {
        $textToSend = $text[$i];
        $f = fopen(DIR.'/sms-'.$ret['id_sms_queue'].'-'.$i, 'w');
        fwrite($f, 'Action: login
Username: your-ast-man-user
Secret: *********

Action: originate
Channel: LOCAL/1@sms-dummy
Context: ********
Exten: stocksy
WaitTime: 7
CallerId: 5555
Async: true
Priority: 1
Variable: SMSTO=+'.$ret['number'].',SMSBODY="'.(count($text)>1 ? 'SMS'.($i+1).'/'.count($text).': ' : '').$textToSend.'"

Action: Logoff');
        fclose($f);
    }

    mysql_query('UPDATE `sms_queue` SET sent = 1 WHERE id_sms_queue = '.$ret['id_sms_queue']);
}

mysql_close($connectionAdm);

?>
