<?php
//1. POSTデータ取得
$weight = $_POST["weight"];
if (empty($weight)) {
  $weight = 0.0; // デフォルトの値を設定する（例として 0.0 を使用）
}
$fat = $_POST["fat"];
if (empty($fat)) {
  $fat = 0.0; // デフォルトの値を設定する（例として 0.0 を使用）
}
$food = $_POST["food"];
if (empty($food)) {
  $food = 0.0; // デフォルトの値を設定する（例として 0.0 を使用）
}
$cond = $_POST["cond"];
if (empty($cond)) {
  $cond = 0.0; // デフォルトの値を設定する（例として 0.0 を使用）
}

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO gs_bm_table(weight,fat,food,cond,indate)VALUES(:weight, :fat, :food, :cond,sysdate());";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':weight', $weight,    PDO::PARAM_STR);//Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':fat', $fat,     PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':food', $food,          PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':cond', $cond, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  sql_error($stmt); //関数sql_errorを実行
}else{
  redirect("select.php");
}
?>
