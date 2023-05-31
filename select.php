<?php
//1.  DB接続します
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT*FROM gs_bm_table;";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
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
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
  <!-- Chart.jsの読み込み -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ表示</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
      <table>
      <?php foreach($values as $v){?>
        <tr>
          <td><?=$v["id"]?>/　</td>
          <td><?=$v["weight"]?>kg/　</td>
          <td><?=$v["fat"]?>%/　</td>
          <td><?=$v["food"]?>/　</td>
          <td><?=$v["cond"]?>/　</td>
          <td><?=$v["indate"]?></td>
          <td> <a href="detail.php?id=<?=h($v["id"])?>"> 　　編集 </a></td>
          <td> <a href="delete.php?id=<?=h($v["id"])?>"> 　削除</a></td>
        </tr>
      <?php }?>
      </table>
    </div>
</div>
<!-- 折れ線グラフの表示エリア -->
<div>
  <canvas id="myChart"></canvas>
</div>
<a href="index.php">入力画面に戻る</a>
<!-- Main[End] -->

<script>
  //JSON受け取り
  const json = JSON.parse('<?=$json?>');
  console.log(json);

  // テーブルのデータを配列に変換
  const chartData = <?= $json ?>;
  
  // ラベルとデータの配列を作成
  const labels = chartData.map(data => data.indate);
  const weightData = chartData.map(data => data.weight);
  const fatData = chartData.map(data => data.fat);
  const foodData = chartData.map(data => data.food * 10);
  const condData = chartData.map(data => data.cond * 10);

  // グラフの描画
  const ctx = document.getElementById('myChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        {
          label: '体重 (kg)',
          data: weightData,
          borderColor: 'rgba(75, 192, 192, 1)',
          fill: false
        },
        {
          label: '体脂肪率 (%)',
          data: fatData,
          borderColor: 'rgba(255, 99, 132, 1)',
          fill: false
        },
        {
          label: '前日食事量',
          data: foodData,
          borderColor: 'rgba(54, 162, 235, 1)',
          fill: false
        },
        {
          label: '体調',
          data: condData,
          borderColor: 'rgba(255, 206, 86, 1)',
          fill: false
        }
      ]
    },
    options: {
      scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 70,
                        stepSize: 5
                    }
                }
              }
        });
</script>
</body>
</html>

