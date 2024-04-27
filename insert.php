<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//1. POSTデータ取得
//[name,towho,agetowho,budget,kenshinplan,addplan,comment]
$name = $_POST["name"];
$towho = $_POST["towho"];
$agetowho = $_POST["agetowho"];
$budget = $_POST["budget"];
$kenshinplan = $_POST["kenshinplan"];
$addplan = $_POST["addplan"];
$comment = $_POST["comment"];


//2. DB接続します
include("funcs.php"); //外部ファイル読み込み
$pdo = db_conn();


//３．データ登録SQL作成
$sql = "INSERT INTO kenshin_gift(name, towho, agetowho, budget, kenshinplan, addplan, comment) 
        VALUES(:name, :towho, :agetowho, :budget, :kenshinplan, :addplan, :comment)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':towho', $towho, PDO::PARAM_STR);
$stmt->bindValue(':agetowho', $agetowho, PDO::PARAM_STR); // Assuming age range is a string
$stmt->bindValue(':budget', $budget, PDO::PARAM_INT);
$stmt->bindValue(':kenshinplan', $kenshinplan, PDO::PARAM_STR);
$stmt->bindValue(':addplan', $addplan, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  sql_error($stmt); // Function call for SQL error handling
} else {
  redirect("index.php"); // Redirect to index.php after successful insertion
}
?>
