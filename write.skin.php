<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
$action_url = https_url(G5_BBS_DIR)."/write_update.php";
$option = '';
$option_hidden = '';
if ($is_notice || $is_html || $is_secret || $is_mail) {
	$option = '';
	if ($is_notice) {
		$option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">NOTICE</label>';
	}

	if ($is_html) {
		if ($is_dhtml_editor) {
			$option_hidden .= '<input type="hidden" value="html1" name="html">';
		} else {
			// $option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
		}
	}

	if ($is_secret) {
		if ($is_admin || $is_secret==1) {
			$option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">SECRET</label>';
		} else {
			$option_hidden .= '<input type="hidden" name="secret" value="secret">';
		}
	}

	if ($is_mail) {
		$option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
	}
}
echo $option_hidden;

?>
<form name="fwrite" id="fwrite" action="<? echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="uid" value="<? echo get_uniqid(); ?>">
	<input type="hidden" name="w" value="<? echo $w ?>">
	<input type="hidden" name="bo_table" value="<? echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<? echo $wr_id ?>">
	<input type="hidden" name="sca" value="<? echo $sca ?>">
	<input type="hidden" name="sfl" value="<? echo $sfl ?>">
	<input type="hidden" name="stx" value="<? echo $stx ?>">
	<input type="hidden" name="spt" value="<? echo $spt ?>">
	<input type="hidden" name="sst" value="<? echo $sst ?>">
	<input type="hidden" name="sod" value="<? echo $sod ?>">
	<input type="hidden" name="page" value="<? echo $page ?>">
	<input type="hidden" name="wr_subject" value="QNA 문의글">
	<?= $option_hidden ?>

	<div class="ui-write-box autosize">
		<textarea id="content" name="wr_content" itemname="내용" required><?=$content?></textarea>
	</div>

	<div class="ui-control">
	<? if ($option) {
		echo $option ?>&nbsp;&nbsp;
	<? } ?>
	<? if(!$is_member){ ?>
		<input type="text" maxlength="20" name="wr_name" id="wr_name" placeholder="NAME" itemname="이름" required value="<?=$name?>" />
		<input type="password" maxlength="20" id="wr_password" name="wr_password" placeholder="PASSWORD" itemname="****" value="<?=$password?>" <?=$password_required?> />
	<? } ?>
		<button type="submit" id="btn_submit" class="ui-btn" accesskey="s">ENTER</button>
	</div>
</form>

<script>
<? if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<? echo $write_min; ?>); // 최소
var char_max = parseInt(<? echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
	$("#wr_content").on("keyup", function() {
		check_byte("wr_content", "char_count");
	});
});
<? } ?>
$(document).ready(function() {
	$('.autosize').on( 'keyup', 'textarea', function (e){
		$(this).css('height', 'auto' );
		$(this).height( this.scrollHeight );
	});
	$('.autosize').find( 'textarea' ).keyup();
});
function fwrite_submit(f)
{
	return true;
}
</script>
