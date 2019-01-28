<?php
session_start();
// ログイン状態チェック
/*
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}*/

if (isset($_POST["payment"])) {
    if (empty($_POST["balance"])) {  
        $errorMessage = '金額が未入力です。';
    }

    if (!empty($_POST["balance"])) {
        $userid = $_SESSION["NAME"];
        $balance = $_POST["balance"];

        try{
            $pdo = new PDO('mysql:host=127.0.0.1;dbname=Members;charset=utf8;','root','emika0304',
            array(PDO::ATTR_EMULATE_PREPARES => false));
            $stmt = $pdo->prepare("update Members set balance = ? where name = ?");
            $stmt->execute(array($balance, $userid)); 

            


        }catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }


    }
}
?>
<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="UTF-8">
<title>メニュー表</title>

<form id="" name="" method="POST" action=""> 
<input type="text" id="balance" name="balance" placeholder="チャージする金額を入力してください" value = "">
<input type="submit" id="payment" name="payment" value="入金">
</form>

<link rel="stylesheet" href="home.css">
</head>
<body>
<center><h1>メニュー表</h1></center>

<center><p><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>  残高<?php echo htmlspecialchars($balance, ENT_QUOTES); ?>円</p><center>
<hr>


<div class="gazo-box">
<ul>
<li><a href="next.html">セットメニュー</li>
<li><a href="next.html">ドリンクメニュー</li>
<li>期間限定メニュー</li>
</ul>
</div>




<div class="gazo-box">
<ul>
<li><img src="image/ramen.png" width="300" height="250" alt="サンプル画像"><br>商品名<br>¥580円<br>商品説明ーーー<br><button class="btn" type="button"><a href="index03.php">購入</a></button>

</script>

<br>

<li><img src="image/suteki.png" width="300" height="350" alt="サンプル画像"><br>商品名<br>¥580円<br>商品説明ーーー<br><button class="btn" type="button"><a href="index03.php">購入</a></button>


</script>

</ul>
</div>


<div class="gazo-box">
<ul　list-style: none;>
<li><img src="image/udon.png" width="300" height="250" alt="サンプル画像"><br>商品名<br>¥580円<br>商品説明ーーー<br><button class="btn"
type="button" onclick="location.href='移動先のファイルのパスを書く'">購入</button></li>

<li><img src="image/han.png" width="300" height="350" alt="サンプル画像"><br>商品名<br>¥580円<br>商品説明ーーー<br><button class="btn"
type="button" onclick="location.href='移動先のファイルのパスを書く'">購入</button></li>
</ul>
</div>



</body>
</html>