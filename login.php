<?php

//require 'password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "emika0304";  // ユーザー名のパスワード
$db['dbname'] = "Members";  // データベース名


// エラーメッセージの初期化
$errorMessage = "";


if (isset($_POST["login"])) {
    if (empty($_POST["userid"])) {  
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
        $userid = $_POST["userid"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        //$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);//%s

        // 3. エラー処理
        try {
            $pdo = new PDO('mysql:host=127.0.0.1;dbname=Members;charset=utf8;','root','emika0304');

            $stmt = $pdo->prepare('SELECT * FROM Members WHERE name = ?');
            $stmt->execute(array($userid));

            $password = $_POST["password"]; 

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                if (password_verify($password, $row['password'])) { // パスワードがハッシュにマッチするかどうかを調べる. $arr[キー] = 値;.
                    session_regenerate_id(true);//セッションハイジャック対策.

                    // 入力したIDのユーザー名を取得
                    $id = $row['id']; 
                    $sql = "SELECT * FROM Members WHERE id = $id";  //入力したIDからユーザー名を取得
                    $stmt = $pdo->query($sql);
                    
                    /*foreach ($stmt as $row) {
                        $row['name'];  // ユーザー名
                    }*/
                    $_SESSION["NAME"] = $row['name'];
                    header("Location: Main.php");  // メイン画面へ遷移
                    exit();  // 処理終了
                } else {
                    // 認証失敗
                    $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html>
 
    <head>
            <meta charset="UTF-8">
            <title>ログイン</title>
    </head>
    <body>

        <h1>ログイン画面</h1>

        
        <form id="loginForm" name="loginForm" method="POST" action=""> 
            <fieldset>
                <legend>ログインフォーム</legend>
                <div><font color="#ff0000">  <?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <label for="userid">ユーザーID</label><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value = "">
                <br>
                <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <input type="submit" id="login" name="login" value="ログイン">
            </fieldset>
        </form>
        <br>
        <form action="SignUp.php"> 
            <fieldset>          
                <legend>新規登録フォーム</legend>
                <input type="submit" value="新規登録">
            </fieldset>
        </form>

    </body>
</html>
