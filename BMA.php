<?php

if(array_key_exists("proc", $_POST))
{
    if($_POST["proc"] == "set")
    {
        $result_cd_json = test_class::setData($_POST["sortnum"]);
        header('Content-type: application/json');
        echo  json_encode($result_cd_json);
        exit();
    }
    elseif($_POST["proc"] == "delete")
    {
        $postData = test_class::getPostData();          //ポストされたデータの取り込み
        
        $result_ch = test_class::deleteData($postData);
        
        $result_cd_json = array('result_cd'=>0 , 'stop_row'=>0);
        header('Content-type: application/json');
        echo  json_encode($result_cd_json);
        exit();
    }
    elseif($_POST["proc"] == "search")
    {
        $result_cd_json = test_class::searchData($_POST["searchword"],$_POST["sortnum"]);
        header('Content-type: application/json');
        echo  json_encode($result_cd_json);
        exit();
    }
    else
    {
        $postData = test_class::getPostData();          //ポストされたデータの取り込み
        //DB処理 
        if(test_class::checkDuplicate($postData) == false)//false = データの重複がある
        {
            $result_cd_json = array('result_cd'=>1 , 'stop_row'=>0);
        }
        else//true = データの重複がない
        {
            if($_POST["proc"] == "insert")
            {
                $result_ch = test_class::insertData($postData);
            }
            elseif($_POST["proc"] == "update")
            {
                $result_ch = test_class::updateData($postData);
            }
            
            $result_cd_json = array('result_cd'=>0 , 'stop_row'=>0);
        }
        
        header('Content-type: application/json');
        echo  json_encode($result_cd_json);
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--jqueryの読み込み-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!--Ajaxを記述したjsファイルの読み込み-->
<script src="BMA.js"></script>
<script src="jquery.blockUI.js"></script>

<?php
//アクセス元がスマホかPCかチェックする＝「ダイナミックサービング」でやり方を見つけたがコレは「レスポンシブ方式」では……？⇒スマホとPCで変数とか分けないとだから結局「ダイナミックサービング」
function is_mobile() {
return preg_match( '/android.+mobile/i', $_SERVER['HTTP_USER_AGENT'] ) ||preg_match( '/iphone/i', $_SERVER['HTTP_USER_AGENT'] )||preg_match( '/iPad/i', $_SERVER['HTTP_USER_AGENT'] );
}
// **********
// 以下ページ表示部
// **********
?>

<?php if (is_mobile()): //以下スマホページ ?>
<meta charset="UTF-8"http-equiv="Refresh" content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=2.0,user-scalable=yes,url=http://yuito02ex.starfree.jp/bookmanagerAdministrator.php"name="viewport">
<link rel="stylesheet" href="BMAforPhone.css">
<title>bookmanagerAdministrator_ForPhone</title>
</head>
<!------------　以下html本文　------------>
<body style="background: linear-gradient(#f7fcfe, #badcad) fixed;"><!--　背景色設定　-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.4/css/all.css">
<div id="page_top"><a href="#"></a></div>
<br>
<br>
<a href="http://yuito02ex.starfree.jp/">ホーム画面</a>
<h1 style="background-color:#88cb7f">　<span class="title">書籍管理</span></h1><!--　ヘッダー　-->

<header><span style="background-color:#EEE8AA;font-size: 150%">キーワード検索</span> 
<button type="button" name="search" onclick="searchDB(0)" class="button">検索</button> 
<button type="button" name="backhome" onclick="setDB(0);textBoxClear();" class="button2">一覧に戻る</button>
<input type="text" name="searchBox"id="searchBox"class="txt3" value=""></header><!--　動くヘッダー　-->

<p><span style="background-color:#EEE8AA;font-size: 120%">書籍名</span> <input type="text" name="Box1" id="Box1" class="txt" tabindex="1"value=""><input type='hidden' id='hiddenBox1' name='hiddenBox1' value=''></p>
<p><span style="background-color:#EEE8AA;font-size: 120%">著者名</span> <input type="text" name="Box2" id="Box2" class="txt" tabindex="2"value=""><input type='hidden' id='hiddenBox2' name='hiddenBox2' value=''></p>
<p><span style="background-color:#EEE8AA;font-size: 120%">出版社</span> <input type="text" name="Box3" id="Box3" class="txt" tabindex="3"value=""><input type='hidden' id='hiddenBox3' name='hiddenBox3' value=''></p>
<p><span style="background-color:#EEE8AA;font-size: 120%">価　格</span> <input type="text" name="Box4" id="Box4" tabindex="4"class="txt2" value=""><input type='hidden' id='hiddenBox4' name='hiddenBox4' value=''></p>
<p><span style="background-color:#EEE8AA;font-size: 120%">在　庫</span> <input type="text" name="Box5" id="Box5" tabindex="5"class="txt2" value=""><input type='hidden' id='hiddenBox5' name='hiddenBox5' value=''></p>
<input type='hidden' id='hiddenBox' name='hiddenBox' value=''>

<p> 
<button type="button"  name="insert" onclick="insertDB()" tabindex="6"class="button">登録</button> <!--　複数のonclickイベントは;で区切る　-->
<button type="button"  name="updata" onclick="updateDB()" tabindex="7"class="button">変更</button> 
<button type="button"  name="remove" onclick="deleteDB()" tabindex="8"class="button">削除</button>
<input type="reset" value="クリア"    onclick="textBoxClear()" tabindex="9"class="button"/>
</p>

<div style="width:380; overflow-x:auto;">
<div id="tabledata"></div>
</div>

</body>
</html>

<?php else: //以下PCページ ?>
<link rel="stylesheet" href="BMA.css">
<title>bookmanagerAdministrator</title>
</head>
<!------------　以下html本文　------------>
<body style="background: linear-gradient(#f7fcfe, #badcad) fixed;"><!--　背景色設定　-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.4/css/all.css">
<div id="page_top"><a href="#"></a></div>
<header>
<p>
<span style="background-color:#EEE8AA">キーワード検索</span> 
<input type="text" name="searchBox"id="searchBox"class="txt" value=""> 
<button type="button" name="search" onclick="searchDB(0)" class="button">検索</button> 
<button type="button" name="backhome" onclick="setDB(0);textBoxClear();" class="button">一覧に戻る</button>
</p>
</header><!--　動くヘッダー　-->
<br>
<br>
<br>
<a href="http://yuito02ex.starfree.jp/">ホーム画面</a>
<h1 style="background-color:#88cb7f">　<span class="title">書籍管理</span></h1><!--　ヘッダー　-->

<p>　<span style="background-color:#EEE8AA">書籍名</span> <input type="text" name="Box1" id="Box1" class="txt" tabindex="1"value=""><input type='hidden' id='hiddenBox1' name='hiddenBox1' value=''></p>
<p>　<span style="background-color:#EEE8AA">著者名</span> <input type="text" name="Box2" id="Box2" class="txt" tabindex="2"value=""><input type='hidden' id='hiddenBox2' name='hiddenBox2' value=''></p>
<p>　<span style="background-color:#EEE8AA">出版社</span> <input type="text" name="Box3" id="Box3" class="txt" tabindex="3"value=""><input type='hidden' id='hiddenBox3' name='hiddenBox3' value=''>　　　　　　　　　　
<p>　<span style="background-color:#EEE8AA">価　格</span> <input type="text" name="Box4" id="Box4" tabindex="4"class="txt2" value=""><input type='hidden' id='hiddenBox4' name='hiddenBox4' value=''>　　
<span style="background-color:#EEE8AA">在　庫</span> <input type="text" name="Box5"  id="Box5" tabindex="5"class="txt2" value=""><input type='hidden' id='hiddenBox5' name='hiddenBox5' value=''>
<input type='hidden' id='hiddenBox' name='hiddenBox' value=''>
<p>　　　　 
<button type="button"  name="insert" onclick="insertDB()" tabindex="6"class="button">登録</button> <!--　複数のonclickイベントは;で区切る　-->
<button type="button"  name="updata" onclick="updateDB()" tabindex="7"class="button">変更</button> 
<button type="button"  name="remove" onclick="deleteDB()" tabindex="8"class="button">削除</button>
<input type="reset" value="クリア"    onclick="textBoxClear()" tabindex="9"class="button"/>
</p>

<div id="tabledata"></div>

</body>
</html>
<?php
 endif; 
 // **********
// 以上ページ表示部
// **********
 ?>


<?php

class test_class
{
    public static function dbConnect($sql)
    {
        $mysqli = new mysqli();
        
        if ($mysqli ->connect_error) {
            return false;
        } else {
            $mysqli ->set_charset('utf8');
        }
        $result = $mysqli->query($sql);
        //$result->close();
        //$mysqli->close();
        
        return $result;
    }

    public static function getPostData()
    {
        $item_data = new item_data();
        $item_data->ip_key          = ($_POST["p_key"]);
        $item_data->sbook_nm        = ($_POST["book_nm"]);
        $item_data->sbook_kana      = mb_convert_kana(self::exchangeKana($_POST["book_nm"]),'Hc');
        $item_data->sauthor_nm      = ($_POST["author_nm"]);
        $item_data->sauthor_kana    = mb_convert_kana(self::exchangeKana($_POST["author_nm"]),'Hc');
        $item_data->spublisher_nm   = ($_POST["publisher_nm"]);
        $item_data->spublisher_kana = mb_convert_kana(self::exchangeKana($_POST["publisher_nm"]),'Hc');
        $item_data->iprice_num      = mb_convert_kana(($_POST["price_num"]), 'kvrn');
        $item_data->izaiko_num      = mb_convert_kana(($_POST["zaiko_num"]), 'kvrn');
        return $item_data;
    }
    
    public static function checkDuplicate($value)//重複チェック
    {
        $ssql  = "SELECT *";
        $ssql .= " FROM bookmanagerSource";
        $ssql .= " WHERE NOT p_key = ".$value->ip_key;      //これがあることで「更新」時にそのデータ自体での重複を避ける
        $ssql .= " ORDER BY p_key";    
        $dbresult = self::dbConnect($ssql);
        
        //DBから取得出来たら = $dbresult->num_rows が 0 でない
        if($dbresult->num_rows > 0)
        {
            for ($i = 0; $i < $dbresult->num_rows;$i++)
            {
                $row = $dbresult->fetch_assoc();
                $item_data = new item_data();
                $item_data->sbook_nm       = $row["book_nm"];
                $item_data->sauthor_nm     = $row["author_nm"];
                $item_data->spublisher_nm  = $row["publisher_nm"];
                
                $result[] = $item_data;
            }
        }
        else
        {
            return true;     //DBにそもそもデータがない
        }
        
        //一致チェック　
        foreach($result as $item_data)
        {
            if($item_data->sbook_nm == $value->sbook_nm && $item_data->sauthor_nm == $value->sauthor_nm && $item_data->spublisher_nm == $value->spublisher_nm)
            {
                return false;
            }
        }
        
        return true;      //ここまで着たら重複なし
    }
    
    public static function setData($num)
    {
        $ssql  = "SELECT *";
        $ssql .= " FROM bookmanagerSource";
        if($num == 0)
        {
            $ssql .= " ORDER BY p_key"; 
        }
        elseif($num == 1)
        {
            $ssql .= " ORDER BY book_kana"; 
        }
        elseif($num == 2)
        {
            $ssql .= " ORDER BY book_kana DESC"; 
        }
        elseif($num == 3)
        {
            $ssql .= " ORDER BY author_kana"; 
        }
        elseif($num == 4)
        {
            $ssql .= " ORDER BY author_kana DESC"; 
        }
        elseif($num == 5)
        {
            $ssql .= " ORDER BY publisher_kana"; 
        }
        elseif($num == 6)
        {
            $ssql .= " ORDER BY publisher_kana DESC"; 
        }
        elseif($num == 7)
        {
            $ssql .= " ORDER BY price_num"; 
        }
        elseif($num == 8)
        {
            $ssql .= " ORDER BY price_num DESC"; 
        }
        elseif($num == 9)
        {
            $ssql .= " ORDER BY zaiko_num"; 
        }
        elseif($num == 10)
        {
            $ssql .= " ORDER BY zaiko_num DESC"; 
        }
        elseif($num == 11)
        {
            $ssql .= " ORDER BY ins_time"; 
        }
        elseif($num == 12)
        {
            $ssql .= " ORDER BY ins_time DESC"; 
        }
        
        $dbresult = self::dbConnect($ssql);
        
        //DBから取得出来たら = $dbresult->num_rows が 0 でない
        if($dbresult->num_rows > 0)
        {
            for ($i = 0; $i < $dbresult->num_rows;$i++)
            {
                $row = $dbresult->fetch_assoc();
                $item_data = new item_data();
                $item_data->ip_key         = $row["p_key"];
                $item_data->sbook_nm       = $row["book_nm"];
                $item_data->sauthor_nm     = $row["author_nm"];
                $item_data->spublisher_nm  = $row["publisher_nm"];
                $item_data->iprice_num     = $row["price_num"];
                $item_data->izaiko_num     = $row["zaiko_num"];
                $item_data->iins_time      = $row["ins_time"];
                
                $result[] = $item_data;
            }
        }
        else     //DBから取得出来ない場合 item_dataの初期値で配列一つ作る
        {
            
            $result[]  = null;
        }
        
        return $result;
    }
    
    public static function searchData($searchword,$num)
    {
        $ssql  = "SELECT *";
        $ssql .= " FROM bookmanagerSource";
        $ssql .= " WHERE book_nm   LIKE '%".$searchword."%' ";    
        $ssql .= " OR author_nm    LIKE '%".$searchword."%' ";  
        $ssql .= " OR publisher_nm LIKE '%".$searchword."%' ";  
        if($num == 0)
        {
            $ssql .= " ORDER BY p_key"; 
        }
        elseif($num == 1)
        {
            $ssql .= " ORDER BY book_kana"; 
        }
        elseif($num == 2)
        {
            $ssql .= " ORDER BY book_kana DESC"; 
        }
        elseif($num == 3)
        {
            $ssql .= " ORDER BY author_kana"; 
        }
        elseif($num == 4)
        {
            $ssql .= " ORDER BY author_kana DESC"; 
        }
        elseif($num == 5)
        {
            $ssql .= " ORDER BY publisher_kana"; 
        }
        elseif($num == 6)
        {
            $ssql .= " ORDER BY publisher_kana DESC"; 
        }
        elseif($num == 7)
        {
            $ssql .= " ORDER BY price_num"; 
        }
        elseif($num == 8)
        {
            $ssql .= " ORDER BY price_num DESC"; 
        }
        elseif($num == 9)
        {
            $ssql .= " ORDER BY zaiko_num"; 
        }
        elseif($num == 10)
        {
            $ssql .= " ORDER BY zaiko_num DESC"; 
        }
        elseif($num == 11)
        {
            $ssql .= " ORDER BY ins_time"; 
        }
        elseif($num == 12)
        {
            $ssql .= " ORDER BY ins_time DESC"; 
        }
        
        $dbresult = self::dbConnect($ssql);
        
        //DBから取得出来たら = $dbresult->num_rows が 0 でない
        if($dbresult->num_rows > 0)
        {
            for ($i = 0; $i < $dbresult->num_rows;$i++)
            {
                $row = $dbresult->fetch_assoc();
                $item_data = new item_data();
                $item_data->ip_key         = $row["p_key"];
                $item_data->sbook_nm       = $row["book_nm"];
                $item_data->sauthor_nm     = $row["author_nm"];
                $item_data->spublisher_nm  = $row["publisher_nm"];
                $item_data->iprice_num     = $row["price_num"];
                $item_data->izaiko_num     = $row["zaiko_num"];
                $item_data->iins_time      = $row["ins_time"];
                
                $result[] = $item_data;
            }
        }
        else     //DBから取得出来ない場合 item_dataの初期値で配列一つ作る
        {
            $result[]  = null;
        }
        
        return $result;
    }
    
    //学習のためDB処理の関数を別途で作成
    public static function insertData($item_data)
    {
        $ssql =  "INSERT INTO bookmanagerSource ";
        $ssql .= "(book_nm, book_kana, author_nm, author_kana, publisher_nm, publisher_kana, price_num, zaiko_num)";
        $ssql .= " VALUES ";
        $ssql .= "('{$item_data->sbook_nm}', '{$item_data->sbook_kana}' ,'{$item_data->sauthor_nm}','{$item_data->sauthor_kana}', '{$item_data->spublisher_nm}', '{$item_data->spublisher_kana}', {$item_data->iprice_num}, {$item_data->izaiko_num});";
        
        $dbresult = self::dbConnect($ssql);
        return $dbresult;
    }
    
    //学習のためDB処理の関数を別途で作成
    public static function updateData($item_data)
    {
        $ssql =  "UPDATE bookmanagerSource SET";
        $ssql .= "  book_nm        = '".$item_data->sbook_nm."'";
        $ssql .= ", book_kana      = '".$item_data->sbook_kana."'";
        $ssql .= ", author_nm      = '".$item_data->sauthor_nm."'";
        $ssql .= ", author_kana    = '".$item_data->sauthor_kana."'";
        $ssql .= ", publisher_nm   = '".$item_data->spublisher_nm."'";
        $ssql .= ", publisher_kana = '".$item_data->spublisher_kana."'";
        $ssql .= ", price_num      =  ".$item_data->iprice_num;
        $ssql .= ", zaiko_num      =  ".$item_data->izaiko_num;
        $ssql .= " WHERE p_key     =  ".$item_data->ip_key.";";     //これがあるので一行文ずつしか更新できない ← ここが初期値のままだったから登録⇒更新に変わらなかった
        
        $dbresult = self::dbConnect($ssql);
        return $dbresult;
    }
    
    public static function deleteData($item_data)
    {
        $ssql =  "DELETE FROM bookmanagerSource ";
        $ssql .= " WHERE p_key = ".$item_data->ip_key.";";     //これがあるので一行文ずつしか更新できない ← ここが初期値のままだったから登録⇒更新に変わらなかった
        
        $dbresult = self::dbConnect($ssql);
        return $dbresult;
    }
    
    //漢字⇒よみがな変換　YahooAPIを使用
    //https://www.pahoo.org/e-soul/webtech/php06/php06-39-01.shtm
    function exchangeKana($sentence) {
    $url = 'https://jlp.yahooapis.jp/FuriganaService/V2/furigana';
    $post = array(
        'id'       => '',                           //ID
        'jsonrpc'  => '2.0',                          //固定値
        'method'   => 'jlp.furiganaservice.furigana', //固定値
        'params'   => array(
            'grade'    =>  1,                 //学年
            'sentence' => (string)$sentence                //対象テキスト
        )
    );
    $json = json_encode($post);

    //WebAPIにパラメータをPOST渡しする
    $stream = stream_context_create(array('http' => array(
        'header'  => "Content-Type: application/json\r\n" .
                    "User-Agent: Yahoo AppID:  \r\n",
        'method'  => 'POST',
        'content' => $json,
    )));
    //WebAPIリクエスト
    $res = file_get_contents($url, FALSE, $stream);

    //応答を配列へ代入
    $items = array();
    $results = json_decode($res);
    if (! isset($results->result->word))   return FALSE;
    $i = 0;
    
    //中身だけを多次元配列$itemsに格納
    foreach ($results->result->word as $word) {
        $items[$i]['surface'] = isset($word->surface) ?
            (string)$word->surface : '';
        $items[$i]['furigana'] = isset($word->furigana) ?
            (string)$word->furigana : '';
        $items[$i]['roman'] = isset($word->roman) ?
            (string)$word->roman : '';
        //subwordを配列へ代入
        if (isset($word->subword)) {
            $j = 0;
            foreach ($word->subword as $subword) {
                $items[$i]['subword'][$j]['surface'] =
                    isset($subword->surface) ? (string)$subword->surface : '';
                $items[$i]['subword'][$j]['furigana'] =
                    isset($subword->furigana) ? (string)$subword->furigana : '';
                $items[$i]['subword'][$j]['roman'] =
                    isset($subword->roman) ? (string)$subword->roman : '';
                $j++;
            }
        }
        $i++;
    }
    
    $yomigana = "";
    foreach($items as $array)
    {
        //形態素で分けて
        if($array['furigana'] == "")   //フリガナがない＝漢字じゃない　ならそのまま格納
        {
            $yomigana .= $array['surface'];
        }
        else    //フリガナがある＝ふりがなを格納
        {
            $yomigana .= $array['furigana'];
        }
        
    }
    return $yomigana;
}
}

class item_data
{
    public $ip_key          = 0;
    public $sbook_nm        = "";
    public $sbook_kana      = "";
    public $sauthor_nm      = "";
    public $sauthor_kana    = "";
    public $spublisher_nm   = "";
    public $spublisher_kana = "";
    public $iprice_num      = 0;
    public $izaiko_num      = 0;
    public $iins_time       = 0;
}

?>