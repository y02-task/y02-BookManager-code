<?php
$word = '漢字を読み仮名に変換';
var_dump($word);
var_dump(getRuby_Yahoo($word));

function getRuby_Yahoo($sentence) {
    $url = 'https://jlp.yahooapis.jp/FuriganaService/V2/furigana';
    $post = array(
        'id'       => '1234-1',                           //ID任意値
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
                    "User-Agent: Yahoo AppID: ここにyahooAPIのID \r\n",
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
?>