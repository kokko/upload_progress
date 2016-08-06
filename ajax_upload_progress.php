<?php
/** 
 * 
 * ファイルアップロード進捗状況を取得する
 * 
 * @author      kokko 
 * @version     1.0 
 * @create      2016-07-31
 * 
 **/

session_start();

$upload_progress_key = ini_get('session.upload_progress.prefix') . 'upfile';

if ( isset($_SESSION[$upload_progress_key]) ) {
	$res = json_encode($_SESSION[$upload_progress_key]);
} else {
	$res = json_encode(null);
}

header('Content-Type: text/plain;charset=UTF-8');
echo $res;


exit;
