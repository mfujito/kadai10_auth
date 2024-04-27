<?php

//0. SESSION開始！！
session_start();

//１．関数群の読み込み
include("funcs.php");

//LOGINチェック → funcs.phpへ関数化しましょう！
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM kenshin_gift";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); //true or false

// var_dump("hello");
// exit();

// //３．データ表示
$values=""; //無視
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}

// //全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONい値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>アンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
Head[Start]
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <?=$_SESSION["name"]?>さん、こんにちは！
      <a class="navbar-brand" href="index.php">データ結果</a>
      <a class="navbar-brand" href="logout.php">ログアウト</a><var>
      </div>
    </div>
  </nav>
</header>




<div>
    <div class="container jumbotron"></div>
    <table>
    <?php foreach($values as $v){?> 
      <tr>
        <td><?=h($v["id"])?></td>
        <td><?=h($v["name"])?></td>
        <td><?=h($v["towho"])?></td>
        <td><?=h($v["agetowho"])?></td>
        <td><?=h($v["budget"])?></td>
        <td><?=h($v["kenshinplan"])?></td>
        <td><?=h($v["comment"])?></td>
        <td><a href="detail.php?id=<?=h($v["id"])?>">更新</a></td>
        <?php if($_SESSION["kanri_flg"]== "1"){ ?>
            <td><a href="delete.php?id=<?=$v["id"]?>">[削除]</a></td>
          <?php } ?>
      </tr>
<?php } ?> 
    </table>
</div>



<script>
  //JSON受け取り
  const a = '<?php echo $json; ?>';
  console.log(JSON.parse(a));
</script>
</body>
</html>  