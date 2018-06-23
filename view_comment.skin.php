<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<script>
// 글자수 제한
var char_min = parseInt(<?=$comment_min?>); // 최소
var char_max = parseInt(<?=$comment_max?>); // 최대
</script>

<ul>
<!-- 코멘트 리스트 -->
<?
for ($i=0; $i<count($list); $i++) {
	$comment_id = $list[$i][wr_id];
?>
	<li>
		<div class="qna-comment-content theme-box">
			<!-- 코멘트 출력 -->
			<?
			if (strstr($lists[$ii][wr_option], "secret") && !$is_admin && !$is_open) {
				echo "* 비밀글을 작성한 당사자만 답글을 확인할 수 있습니다.";
			} else {
				$str = $list[$i][content];
				$str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $str);
				$str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(swf)\".*\<\/a\>\]/i", "<script>doc_write(flash_movie('$1://$2.$3'));</script>", $str);
				$str = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' id='target_resize_image[]' onclick='image_window(this);' border='0'>", $str);
			?>
				<div id="comment<?=$comment_id?>"><?=$str?></div>
			<? }
			if ($list[$i]['is_edit']) {
				$str = str_replace('<br/>','',$str); 
			?>
			<div id="edit<?=$comment_id?>" style="display:none;">
				<!-- 코멘트 수정 -->
				<form name="fviewcomment<?=$comment_id?>" method="post" action="./write_comment_update.php" autocomplete="off">
					<input type="hidden" name="w"			value="cu">
					<input type="hidden" name="bo_table"	value="<?=$bo_table?>">
					<input type="hidden" name="wr_id"		value="<?=$comment_id?>">
					<input type="hidden" name="comment_id"	value="<?=$comment_id?>">

					<div class="ui-write-box autosize">
						<textarea id="wr_content" name="wr_content" itemname="내용" required
						<? if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?> style="word-break:break-all;"><?=$str?></textarea>
					</div>
					<? if ($comment_min || $comment_max) { ?><script type="text/javascript"> check_byte('wr_content', 'char_count'); </script><?}?>

					<div class="txt-right">
						<button type="submit" id="btn_submit" class="ui-btn" accesskey='s'>ENTER</button>
					</div>
				</form>
			</div>
			<? } ?>
			<p>
				<em><? if ($list[$i]['is_edit']) { echo "<a href=\"javascript:comment_tog('edit', '{$comment_id}');\">수정</a>"; } ?></em>
				<em><? if ($list[$i]['is_del']) { echo "<a href=\"javascript:comment_delete('{$list[$i][del_link]}');\">삭제</a>"; } ?></em>
				<span class="date"><? echo date('m/d H:i', strtotime($list[$i]['datetime'])) ?></span>
			</p>
		</div>

		<div class="co-name"><?=$list[$i]['name']?></div>

		<input type="hidden" id="secret_comment_<?=$comment_id?>" value="<?=strstr($list[$i][wr_option],"secret")?>">
		<textarea id="save_comment_<?=$comment_id?>" style="display:none;"><?=get_text($list[$i][content], 0)?></textarea>
	</li>
<? } ?>
</ul>

<? if ($is_comment_write) { ?>
<div class="ui-write-area" id="reply<?=$wr_id?>" style="display:none;">
	<!-- 코멘트 입력테이블시작 -->
	<form name="fviewcomment<?=$wr_id?>" method="post" action="./write_comment_update.php" autocomplete="off">
		<input type="hidden" name="w"			value="c">
		<input type="hidden" name="bo_table"	value="<?=$bo_table?>">
		<input type="hidden" name="wr_id"		value="<?=$wr_id?>">
		<input type="hidden" name="comment_id"	value="">
		<input type="hidden" name="token"		value="<?=$comment_token?>">
		<input type="hidden" name="sca"			value="<?=$sca?>" >
		<input type="hidden" name="sfl"			value="<?=$sfl?>" >
		<input type="hidden" name="stx"			value="<?=$stx?>">
		<input type="hidden" name="spt"			value="<?=$spt?>">
		<input type="hidden" name="page"		value="<?=$page?>">
		<input type="hidden" name="cwin"		value="<?=$cwin?>">
		<input type="hidden" name="is_good"		value="">
		<input type="hidden" name="url"			value="./board.php?bo_table=<?=$bo_table?>&page=<?=$page?>">

		<textarea id="wr_content" name="wr_content" rows=4 itemname="내용" required
		<? if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?> style="width:100%; word-break:break-all;" class="tx"><?=$list[$i][wr_content]?></textarea>
		<? if ($comment_min || $comment_max) { ?><script type="text/javascript"> check_byte('wr_content', 'char_count'); </script><?}?>

		<div class="txt-right">
			<button type="submit" id="btn_submit" class="ui-btn" accesskey='s'>ENTER</button>
		</div>
	</form>
</div>
<? } ?>

<script>
function fviewcomment<?=$wr_id?>_submit(f) {
	return true;
}
</script>
<? 
include_once("$board_skin_path/view_skin_js.php");
?>