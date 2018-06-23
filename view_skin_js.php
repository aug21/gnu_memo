<script>
function comment_tog(name, id) { 
	var layer = document.getElementById(name+id); 
	layer.style.display = (layer.style.display == "none")? "block" : "none";
	if(name=='edit') {
		var comment = document.getElementById("comment"+id);
		comment.style.display = (comment.style.display == "none")? "block" : "none";
	}
}
function comment_delete(url) {
	if (confirm("이 코멘트를 삭제하시겠습니까?")) location.href = url;
}
</script>