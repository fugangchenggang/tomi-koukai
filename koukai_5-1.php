<html>
<head>
 <meta charset="utf-8">
<title>公開ファイル5-1</title>
 </head>
  <body>
    
    <p>新規投稿</p>
    <form action="mission_5-1.php" method="POST">
    <font>名前:</font>
    <input type="text" name="name" placeholder="名前を入力してください" height="2" size="50"><br>

    <font>コメント:</font>
    <input type="text" name="comment" placeholder="コメントを入力してください" size="50">

    <input type="hidden" name="rewnum2" placeholder="編集番号指定フォーム"size="50"><br>

    <font>パスワード:</font>
    <input type="text" name="compassword" placeholder="パスワードを入力してください" value="" size="50"/>
    <br>
    <input type="submit" name="comsubmit" size="20"><br>
    </form>
    
    
    
    <p>削除</p>
    <form action="mission_5-1.php" method="post">
    <font>削除対象番号:</font>
    <input type="text" name="delete" 
    placeholder="削除番号を入力してください" size="50"><br>
    <font>パスワード:</font>
    <input type="text" name="depassword" placeholder="パスワードを入力してください" value="" size="50"/>
    <br>
    <input type="submit" name="desubmit" value="実行"><br>
    </form>
    
    
    
    <P>編集</P>
        <!--フォームを開始-->
    <form action="mission_5-1.php" method="post">
        <!--番号入力欄-->
    <font>編集対象番号:</font>
    <input type="text" name="rewnum1" 
    placeholder="編集対象番号を入力" 
    size="50">
    <br>
        <!--名前入力欄-->
    <font>名前:</font>
    <input type="text" name="rename" 
    placeholder="名前を編集してください"
    size="50">
    <br>
        <!--コメント入力欄-->
    <font>コメント:</font>
    <input type="text" name="recomment" 
    placeholder="コメントを編集してください"
    size="50"><br>
        <!--パスワード入力欄-->
    <font>パスワード:</font>
    <input type="text" name="repassword" 
    placeholder="パスワードを入力してください"
    value="" size="50"/>
    <br>
        <!--ボタン-->
    <input type="submit" name="resubmit"value="実行"><br>
    </form>

        <?php 
        
//サーバー接続              
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        
//入力するやつ
        $pdo = new PDO($dsn, $user, $password, 
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
       
//テーブルを作成   
        $sql = "CREATE TABLE IF NOT EXISTS onepiece"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        ."date DATE,"
        ."password TEXT"
        .");";
        $stmt = $pdo->query($sql);
        
       
//入力
    if(!empty($_POST['comsubmit'])){
           if(!empty($_POST['name'])&&!empty($_POST['comment'])
           &&!empty($_POST['compassword'])){
        $password=$_POST["compassword"];
                
    $sql = $pdo -> prepare
    ("INSERT INTO onepiece (name, comment,date) VALUES 
    (:name, :comment,:date)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':date', $date, PDO::PARAM_STR);
        
        
        $name = $_POST["name"];
        $comment =$_POST["comment"];
        $date = date("Y/m/d H:i:s"); 
        $sql -> execute();
    
    }
    }
//編集
 if(!empty($_POST['resubmit'])){
        if(!empty($_POST['rename'])&&!empty($_POST['recomment'])&&!empty($_POST['repassword'])){
             $password=$_POST["repassword"];
             //どのパスワードでもできるようにすること！
                $id =  $_POST["rewnum1"]; 
                $name =  $_POST["rename"];
                $comment =$_POST["recomment"]; 
                $sql = 'update onepiece set name=:name,comment=:comment 
                where id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
             }
        }
    
//削除（こんなにシンプルにできたんか…）
        if(!empty($_POST['desubmit'])){
        if(!empty($_POST['delete'])&&!empty($_POST['depassword'])){
             $password=$_POST["depassword"];
             
             

                $id = $_POST["delete"];
                $sql = 'delete from onepiece where id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
             }
            }
    //表示したい
    $sql = 'SELECT * FROM onepiece';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){

        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";
}
?>