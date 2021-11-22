$(function() {
	//削除確認ポップアップ mypage,goods
	$(".delete").click(function(){
		if(confirm("本当に削除しますか？")){
			var check = "ok";
			return check;
		} else {
			return false;
		}
	});
});

function insert(){
	// 「OK」時の処理開始 ＋ 確認ダイアログの表示
	if(window.confirm('追加しますか？')){
		return true;
	} else {
		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false;
	}
}

function deleted(){
	// 「OK」時の処理開始 ＋ 確認ダイアログの表示
	if(window.confirm('削除しますか？')){
		return true;
	} else {
		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false;
	}
}

function update(){
	// 「OK」時の処理開始 ＋ 確認ダイアログの表示
	if(window.confirm('管理者権限を外しますか？')){
		return true;
	} else {
		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false;
	}
}