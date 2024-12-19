<?php
$name = $_POST['title'];
$email = $_POST['URL'];
$content = $_POST['content'];

try {
  //ID:'root', Password: xamppは 空白 ''
  $pdo = new PDO('mysql:dbname=gs_db_class;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}
$stmt = $pdo->prepare("INSERT
                            INTO
                        gs_bm_table(id, title, URL, comments, date)
                        VALUES(NULL, :title, :URL, :content, now())"
                    );

$stmt->bindValue(':title', $name, PDO::PARAM_STR);
$stmt->bindValue(':URL', $email, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: index.php');
}
?>
