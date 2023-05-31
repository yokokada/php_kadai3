<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数：db_conn()
function db_conn(){
    try {
        $db_name = "p_k2";       //データベース名
        $db_id   = "root";           //アカウント名
        $db_pw   = "";               //パスワード：XAMPPはパスワード無し
        $db_host = "localhost"; //DBホスト
        //localhostでなければさくらに接続する
        if($_SERVER["HTTP_HOST"] != "localhost"){
            $db_name = "umasaka_p_k2";   //データベース名
            $db_id   = "umasaka";     //アカウント名
            $db_pw   = "4050Umasaka";    //パスワード：
            $db_host = "mysql57.umasaka.sakura.ne.jp"; //DBホスト
            }
        return  new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
 }

//SQLエラー関数：sql_error($stmt)
  //*** function化する！*****************
  function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

//リダイレクト関数: redirect($file_name)
 //*** function化する！*****************
 function redirect($page){
    header("Location: ".$page);
    exit();
}





