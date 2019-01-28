<?php
session_start();

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=Members;charset=utf8;','root','emika0304',
    array(PDO::ATTR_EMULATE_PREPARES => false));

    $userid = $_SESSION["NAME"];
    $stmt = $pdo->prepare("SELECT * FROM Members WHERE name = ?");
    $stmt->execute(array($userid)); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //echo htmlentities($row['balance']);

}catch (PDOException $e) {
    $errorMessage = 'データベースエラー';
}

//$money = $money-580;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>購入確認画面</title>
<link rel="stylesheet" href="home.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script>
                
        
            </script>
</head>
<body>


<center><h1>会計画面</h1></center>
<hr>

<button class="btn" type="button"><a href="index02.php">メニュー画面に戻る</a></button>
</script>

<center><p>ご注文を承りました<br>ご注文ありがとうございました</p></br></center>

<center><p>あなたの残高はあと<?php echo htmlentities($row['balance']-580, ENT_QUOTES); ?>円です</p></center>



</body>
</html>