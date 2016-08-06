<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>ファイルアップロード進捗を取得するサンプル</title>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
<script type="text/javascript">

var progress_watch;
var progress_watch_id;

$(document).ready(function() {
	$('form').submit(function() {
		var $progress_view = $('#progress_view');
		var $nowtime_view = $('#nowtime_view');

		//進捗状況監視の本体
		var progress_watch = function(){
			$.get('./ajax_upload_progress.php', {}, function(res){
				var jso = JSON.parse(res);
				if ( jso != null ) {
					var content_length = jso.content_length;
					var bytes_processed = jso.bytes_processed;
					var bytes_processed_ratio;
					
					//アップロード進捗率の算出
					if ( content_length > 0 ) {
						bytes_processed_ratio = Math.floor(1000 * (bytes_processed / content_length)) / 10;
					} else {
						bytes_processed_ratio = 0;
					}
					$progress_view.html(String(bytes_processed_ratio) + '%');
					//アップロード終了した？
					if ( jso.done ) {
						$progress_view.htm('100 %');
						clearInterval(progress_watch_id);
					}
				}
			});
		};

		//１秒間隔で監視を開始
		progress_watch_id = setInterval(progress_watch, 1000);
	});
});

</script>
</head>
<body>

	<form method="POST" action="#" enctype="multipart/form-data">
		<input type="hidden" name="<?php echo ini_get('session.upload_progress.name'); ?>" value="upfile">
		<input type="file" name="upfile" value="">
		<input type="submit" name="upload_button" value="アップロード" id="upload_button">
	</form>
	アップロードできるファイルサイズの上限は <?php echo ini_get('upload_max_filesize'); ?> です。<br>
	<hr>
	進捗状況：<span id="progress_view">-</span><br>

</body>
</html>
