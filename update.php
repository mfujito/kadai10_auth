<?php
session_start();

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//1. POSTデータ取得
$name = $_POST["name"];
$towho = $_POST["towho"]; 
$agetowho = $_POST["agetowho"]; 
$budget = $_POST["budget"];
$kenshinplan = $_POST["kenshinplan"];
$addplan = $_POST["addplan"];
$comment = $_POST["comment"];
$id = $_POST["id"];


//2. DB接続します
include("funcs.php"); //外部ファイル読み込み
sschk();
$pdo = db_conn();


//３．データ登録SQL作成
$sql = "UPDATE kenshin_gift SET name=:name, towho=:towho, agetowho=:agetowho, budget=:budget, kenshinplan=:kenshinplan, addplan=:addplan, comment=:comment WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':towho', $towho, PDO::PARAM_STR);
$stmt->bindValue(':agetowho', $agetowho, PDO::PARAM_STR);
$stmt->bindValue(':budget', $budget, PDO::PARAM_INT);
$stmt->bindValue(':kenshinplan', $kenshinplan, PDO::PARAM_STR);
$stmt->bindValue(':addplan', $addplan, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); 


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("select.php");
}


?>