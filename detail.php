<?php
session_start();
$id = $_GET["id"];
//１．PHP

include("funcs.php");
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM kenshin_gift WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT); 
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$v =  $stmt->fetch(); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
  <form method="POST" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>興味を持ってくださった方はこちらから</legend>
     <label>名前：<input type="text" name="name" value="<?= $v["name"] ?>"></label><br>
     <input type="hidden" name="towho" value="<?= $v["towho"] ?>"> 
     <input type="hidden" name="agetowho" value="<?= $v["agetowho"] ?>">
     <label>予算：<input type="text" name="budget" value="<?= $v["budget"] ?>"></label><br>
     <label>検診プラン：<input type="text" name="kenshinplan" value="<?= $v["kenshinplan"] ?>"></label><br>
     <label>お返しプラン：<input type="text" name="addplan" value="<?= $v["addplan"] ?>"></label><br>
     <label>コメント：<textArea name="comment" rows="2" cols="40"><?= $v["comment"] ?></textArea></label><br>
     <input type="hidden" name="id" value="<?= $v["id"] ?>"> 
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>