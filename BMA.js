

//オブジェクトを読み込み終わった時点
$(function () {
    setDB(0);
});

//ソートのできるヘッダーボタン用
function setHeader(num) {
    let header = "";
    header  = '<table border="0" width="100%">';
    header += '<tr>';
    header += '<thead>';
    
    //書籍名
    if(num == 1){
        header += '<th><input type="button" id="H1" value="                                 書籍名▽                                 " onclick="setDB(2);"class="tableHButton"></th>'; 
    }
    else if (num == 2){
        header += '<th><input type="button" id="H1" value="                                 書籍名△                                 " onclick="setDB(1);"class="tableHButton"></th>'; 
    }
    else{
        header += '<th><input type="button" id="H1" value="                                 書籍名▼                                 " onclick="setDB(1);"class="tableHButton"></th>'; 
    }
    
    //著者名
    if (num == 3) {
        header += '<th><input type="button" id="H1" value="        著者名▽        " onclick="setDB(4);"class="tableHButton"></th>';
    }
    else if (num == 4) {
        header += '<th><input type="button" id="H1" value="        著者名△        " onclick="setDB(3);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="        著者名▼        " onclick="setDB(3);"class="tableHButton"></th>';
    }
    
    //出版社
    if (num == 5) {
        header += '<th><input type="button" id="H1" value="        出版社▽       " onclick="setDB(6);"class="tableHButton"></th>';
    }
    else if (num == 6) {
        header += '<th><input type="button" id="H1" value="        出版社△        " onclick="setDB(5);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="        出版社▼        " onclick="setDB(5);"class="tableHButton"></th>';
    }
    
    //価格
    if (num == 7) {
        header += '<th><input type="button" id="H1" value="価格▽" onclick="setDB(8);"class="tableHButton"></th>';
    }
    else if (num == 8) {
        header += '<th><input type="button" id="H1" value="価格△" onclick="setDB(7);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="価格▼" onclick="setDB(7);"class="tableHButton"></th>';
    }
    
    //在庫数
    if (num == 9) {
        header += '<th><input type="button" id="H1" value="在庫数▽" onclick="setDB(10);"class="tableHButton"></th>';
    }
    else if (num == 10) {
        header += '<th><input type="button" id="H1" value="在庫数△" onclick="setDB(9);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="在庫数▼" onclick="setDB(9);"class="tableHButton"></th>';
    }
    
    //登録日時
    if (num == 11) {
        header += '<th><input type="button" id="H1" value="   登録日時▽   " onclick="setDB(12);"class="tableHButton"></th>';
    }
    else if (num == 12) {
        header += '<th><input type="button" id="H1" value="   登録日時△   " onclick="setDB(11);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="   登録日時▼    " onclick="setDB(11);"class="tableHButton"></th>';
    }
    
    header += '</thead>';
    header += '</tr>';
    
    return header;
}

function setDB(num) {
    //ポスト用の連想配列を用意
    let postData = {};
    postData["proc"] = "set";
    postData["sortnum"] = num;
    $.ajax({
        url: "BMA.php",
        type: "POST",
        data: postData,
        dataType: "json"
    })
        .done(function (data) {
            let data_stringify = JSON.stringify(data);
            let data_json = JSON.parse(data_stringify);
            let html = "";
            if (data_json[0] != null) {
                
                html = setHeader(num);
                
                for (var i = 0; i < data_json.length; i++) {
                    html += '<tr>';
                    html += '<input type="hidden" id="' + 'HD' + i + '" value="' + data_json[i].ip_key + '">';
                    html += '<td><input type="button" id="' + 'BN' + i + '" value="' + data_json[i].sbook_nm + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += '<td><input type="button" id="' + 'WN' + i + '" value="' + data_json[i].sauthor_nm + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += '<td><input type="button" id="' + 'PN' + i + '" value="' + data_json[i].spublisher_nm + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += '<td align="right"><input type="button" id="' + 'BV' + i + '" value="' + data_json[i].iprice_num + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += '<td align="right"><input type="button" id="' + 'ZV' + i + '" value="' + data_json[i].izaiko_num + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += '<td align="right"><input type="button" id="' + 'TM' + i + '" value="' + data_json[i].iins_time + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += "</tr>";
                }
            } else {
                html = setHeader(num);
            }
            
            html += "</table>";
            document.getElementById("tabledata").innerHTML = html;
        })
        .fail(function (data) {
            alert("接続エラー");
        });
}

function setSearchHeader(num) {
    let header = "";
    header = '<table border="0" width="100%">';
    header += '<tr>';
    header += '<thead>';

    //書籍名
    if (num == 1) {
        header += '<th><input type="button" id="H1" value="                                 書籍名▽                                 " onclick="searchDB(2);"class="tableHButton"></th>';
    }
    else if (num == 2) {
        header += '<th><input type="button" id="H1" value="                                 書籍名△                                 " onclick="searchDB(1);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="                                 書籍名▼                                 " onclick="searchDB(1);"class="tableHButton"></th>';
    }

    //著者名
    if (num == 3) {
        header += '<th><input type="button" id="H1" value="        著者名▽        " onclick="searchDB(4);"class="tableHButton"></th>';
    }
    else if (num == 4) {
        header += '<th><input type="button" id="H1" value="        著者名△        " onclick="searchDB(3);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="        著者名▼        " onclick="searchDB(3);"class="tableHButton"></th>';
    }

    //出版社
    if (num == 5) {
        header += '<th><input type="button" id="H1" value="        出版社▽       " onclick="searchDB(6);"class="tableHButton"></th>';
    }
    else if (num == 6) {
        header += '<th><input type="button" id="H1" value="        出版社△        " onclick="searchDB(5);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="        出版社▼        " onclick="searchDB(5);"class="tableHButton"></th>';
    }

    //価格
    if (num == 7) {
        header += '<th><input type="button" id="H1" value="価格▽" onclick="searchDB(8);"class="tableHButton"></th>';
    }
    else if (num == 8) {
        header += '<th><input type="button" id="H1" value="価格△" onclick="searchDB(7);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="価格▼" onclick="searchDB(7);"class="tableHButton"></th>';
    }

    //在庫数
    if (num == 9) {
        header += '<th><input type="button" id="H1" value="在庫数▽" onclick="searchDB(10);"class="tableHButton"></th>';
    }
    else if (num == 10) {
        header += '<th><input type="button" id="H1" value="在庫数△" onclick="searchDB(9);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="在庫数▼" onclick="searchDB(9);"class="tableHButton"></th>';
    }

    //登録日時
    if (num == 11) {
        header += '<th><input type="button" id="H1" value="   登録日時▽   " onclick="searchDB(12);"class="tableHButton"></th>';
    }
    else if (num == 12) {
        header += '<th><input type="button" id="H1" value="   登録日時△   " onclick="searchDB(11);"class="tableHButton"></th>';
    }
    else {
        header += '<th><input type="button" id="H1" value="   登録日時▼    " onclick="searchDB(11);"class="tableHButton"></th>';
    }

    header += '</thead>';
    header += '</tr>';

    return header;
}

function searchDB(num) {
    if (document.getElementById("searchBox").value.trim() == "") {
        alert('検索する文字を入力してください');
        return false;
    }
    //ポスト用の連想配列を用意
    let postData = {};
    postData["proc"] = "search";
    postData["sortnum"] = num;
    postData["searchword"] = document.getElementById("searchBox").value.trim();
    $.ajax({
        url: "BMA.php",
        type: "POST",
        data: postData,
        dataType: "json"
    })
        .done(function (data) {
            let data_stringify = JSON.stringify(data);
            let data_json = JSON.parse(data_stringify);
            let html = "";
            if (data_json[0] != null) {
                
                html = setSearchHeader(num);;
                
                for (var i = 0; i < data_json.length; i++) {
                    html += '<tr>';
                    html += '<input type="hidden" id="' + 'HD' + i + '" value="' + data_json[i].ip_key + '">';
                    html += '<td><input type="button" id="' + 'BN' + i + '" value="' + data_json[i].sbook_nm + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += '<td><input type="button" id="' + 'WN' + i + '" value="' + data_json[i].sauthor_nm + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += '<td><input type="button" id="' + 'PN' + i + '" value="' + data_json[i].spublisher_nm + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += '<td align="right"><input type="button" id="' + 'BV' + i + '" value="' + data_json[i].iprice_num + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += '<td align="right"><input type="button" id="' + 'ZV' + i + '" value="' + data_json[i].izaiko_num + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += '<td align="right"><input type="button" id="' + 'TM' + i + '" value="' + data_json[i].iins_time + '" onclick="OutputTextAndGetNumber(' + i + ')"class="tableButton"></td>';
                    html += "</tr>";
                }
            } else {
                html = setSearchHeader(num);
            }

            html += "</table>";
            document.getElementById("tabledata").innerHTML = html;
        })
        .fail(function (data) {
            alert("接続エラー");
        });
}

//最大文字数のチェック関数
function checkNum(value) {
    let search_word = value;            //検索対象文字列
    let pattern1 = /[^0-9０-９]/;   //検索する特殊文字
    
    //検索した文字列が含まれない（チェックに引っかからない）場合は、戻り値として-1を返す
    if (search_word.search(pattern1) == -1) {
        return true;     //数字以外が含まれない　全角数字はPHP側で処理
    }
    else {
        return false;     //数字以外が含まれる　問題あり
    }
}

//特殊文字のチェック関数
function checkCd(value) {
    let search_word = value;            //検索対象文字列
    let pattern = /"|'|&|<|>|%/u;   //検索する特殊文字

    //検索した文字列が含まれない（チェックに引っかからない）場合は、戻り値として-1を返す
    if (search_word.search(pattern) == -1) {
        return true;     //特殊文字が含まれない　問題なし
    }
    else {
        return false;     //特殊文字が含まれる　問題あり
    }
}

//ボタンにもIDが振れる＝PHPとの間でvalueの受け渡しができる 
function OutputTextAndGetNumber(num) {
    document.getElementById("Box1").value      = document.getElementById("BN" + num).value;
    document.getElementById("Box2").value      = document.getElementById("WN" + num).value;
    document.getElementById("Box3").value      = document.getElementById("PN" + num).value;
    document.getElementById("Box4").value      = document.getElementById("BV" + num).value;
    document.getElementById("Box5").value      = document.getElementById("ZV" + num).value;
    document.getElementById("hiddenBox").value = document.getElementById("HD" + num).value;;//配列の要素番号受け渡し用のボタンに値を入れておく
    
    document.getElementById("hiddenBox1").value = document.getElementById("BN" + num).value;
    document.getElementById("hiddenBox2").value = document.getElementById("WN" + num).value;
    document.getElementById("hiddenBox3").value = document.getElementById("PN" + num).value;
    document.getElementById("hiddenBox4").value = document.getElementById("BV" + num).value;
    document.getElementById("hiddenBox5").value = document.getElementById("ZV" + num).value;
}

//全角数字判定用
function hankaku2Zenkaku(str) {
    return str.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) {
        return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
    });
}

//未入力チェック
function checkAllBox() {
    let alertMessage = "";
    if(document.getElementById("Box1").value.trim() == "" ){
        alertMessage += "書籍名" + "\n"; 
    }
    
    if(document.getElementById("Box2").value.trim() == "") {
        alertMessage += "著者名" + "\n";
    }
    
    if (document.getElementById("Box3").value.trim() == "") {
        alertMessage += "出版社" + "\n";
    }
    
    if (document.getElementById("Box4").value.trim() == "") {
        alertMessage += "価格" + "\n";
    }
    
    if (document.getElementById("Box5").value.trim() == "") {
        alertMessage += "在庫" + "\n";
    }
    
    return alertMessage;
}

function keydown(e) {
    if (e.keyCode === 13) {
        var obj = document.activeElement;
        obj.nextElementSibling.focus();
    }
}
window.onkeydown = keydown;

// **********
// ボタン処理部
// **********

function insertDB() {
    //未入力チェック
    if(checkAllBox() != ""){
        alert(checkAllBox() + "が未入力です");
        return false;
    }
    //文字列チェックに引っかかった場合はエラーのポップアップを出してその時点で処理を止める
    for (let i = 1; i <= 3; i++) {
        let value = document.getElementById("Box" + i).value.trim();     //チェックする値を格納(この段階で空白をトリム = 空白のせいで文字数オーバーなど防ぐ)
        //特殊文字のチェック
        if (checkCd(value) == false) {
            alert("テキストボックス" + i + "に登録不可能な文字が含まれています");
            return false;
        }
    }
    for (let i = 4; i <= 5; i++) {
        let value = document.getElementById("Box" + i).value.trim();     //チェックする値を格納(この段階で空白をトリム = 空白のせいで文字数オーバーなど防ぐ)
        //特殊文字のチェック
        if (checkNum(value) == false) {
            alert("テキストボックス" + i + "に数字以外の文字が含まれています");
            return false;
        }
    }
    //文字のチェックにかからなければ以下の処理に進む
    let postData = {};
    postData["proc"] = "insert";
    
    postData["p_key"]        = document.getElementById("hiddenBox").value;
    postData["book_nm"]      = document.getElementById("Box1").value;
    postData["author_nm"]    = document.getElementById("Box2").value;
    postData["publisher_nm"] = document.getElementById("Box3").value;
    postData["price_num"]    = document.getElementById("Box4").value;
    postData["zaiko_num"]    = document.getElementById("Box5").value;
    
    $.blockUI();
    $.ajax({
        url: "BMA.php",
        type: "POST",
        timeout: 60000,
        dataType: "json",
        data: postData
    })
        .done(function (data) {
            let data_stringify = JSON.stringify(data);
            let data_json = JSON.parse(data_stringify);
            //処理結果コード [0]=成功 [1]=データ重複[それ以外]=予期しないエラー
            if (data_json["result_cd"] == 0) {
                alert("データを登録しました");
                setDB(0);
                textBoxClear();
                $.unblockUI();
            }
            else if (data_json["result_cd"] == 1) {
                alert("同じ書籍のデータが存在します");
                $.unblockUI();
            }
            else {
                alert("非同期通信時に予期しないエラーが発生しました");
                $.unblockUI();
            }
        })
        .fail(function (data) {
            $.unblockUI();
            alert("非同期通信時に失敗しました");
        });
}

function updateDB() {
    //未入力チェック
    if (checkAllBox() != "") {
        alert(checkAllBox() + "が未入力です");
        return false;
    }
    //文字列チェックに引っかかった場合はエラーのポップアップを出してその時点で処理を止める
    for (let i = 1; i <= 3; i++) {
        let value = document.getElementById("Box" + i).value.trim();     //チェックする値を格納(この段階で空白をトリム = 空白のせいで文字数オーバーなど防ぐ)
        //特殊文字のチェック
        if (checkCd(value) == false) {
            alert("テキストボックス" + i + "に登録不可能な文字が含まれています");
            return false;
        }
    }
    for (let i = 4; i <= 5; i++) {
        let value = document.getElementById("Box" + i).value.trim();     //チェックする値を格納(この段階で空白をトリム = 空白のせいで文字数オーバーなど防ぐ)
        //特殊文字のチェック
        if (checkNum(value) == false) {
            alert("テキストボックス" + i + "に数字以外の文字が含まれています");
            return false;
        }
    }
    //文字のチェックにかからなければ以下の処理に進む
    let postData = {};
    postData["proc"] = "update";
    postData["p_key"]        = document.getElementById("hiddenBox").value;
    postData["book_nm"]      = document.getElementById("Box1").value;
    postData["author_nm"]    = document.getElementById("Box2").value;
    postData["publisher_nm"] = document.getElementById("Box3").value;
    postData["price_num"]    = document.getElementById("Box4").value;
    postData["zaiko_num"]    = document.getElementById("Box5").value;
    
    let alertMessage = "";
    alertMessage += document.getElementById("hiddenBox1").value + "⇒" + document.getElementById("Box1").value + "\n";
    alertMessage += document.getElementById("hiddenBox2").value + "⇒" + document.getElementById("Box2").value + "\n";
    alertMessage += document.getElementById("hiddenBox3").value + "⇒" + document.getElementById("Box3").value + "\n";
    alertMessage += document.getElementById("hiddenBox4").value + "⇒" + document.getElementById("Box4").value + "\n";
    alertMessage += document.getElementById("hiddenBox5").value + "⇒" + document.getElementById("Box5").value + "\n";
    
    let check_result = window.confirm(alertMessage + '以上のデータを更新しますか？');
    if (check_result == true) {
        //$.blockUI();
        $.ajax({
            url: "BMA.php",
            type: "POST",
            timeout: 60000,
            dataType: "json",
            data: postData
        })
            .done(function (data) {
                let data_stringify = JSON.stringify(data);
                let data_json = JSON.parse(data_stringify);
                //処理結果コード [0]=成功 [1]=データ重複[それ以外]=予期しないエラー
                if (data_json["result_cd"] == 0) {
                    //$.unblockUI();
                    setDB(0);
                    textBoxClear();
                    alert("データを更新しました");
                }
                else if (data_json["result_cd"] == 1) {
                    //$.unblockUI();
                    alert("同じ書籍のデータが存在します");
                }
                else {
                    //$.unblockUI();
                    alert("非同期通信時に予期しないエラーが発生しました");
                }
            })
            .fail(function (data) {
                //$.unblockUI();
                alert("非同期通信時に失敗しました");
            });
    }
}

function deleteDB() {
    //未入力チェック
    if (document.getElementById("hiddenBox").value == "") {
        alert("削除するデータを選んでください");
        return false;
    }
    let postData = {};
    postData["proc"] = "delete";
    postData["p_key"] = document.getElementById("hiddenBox").value;

    let alertMessage = "";
    alertMessage += document.getElementById("hiddenBox1").value + "\n";
    alertMessage += document.getElementById("hiddenBox2").value + "\n";
    alertMessage += document.getElementById("hiddenBox3").value + "\n";
    alertMessage += document.getElementById("hiddenBox4").value + "\n";
    alertMessage += document.getElementById("hiddenBox5").value + "\n";

    let check_result = window.confirm(alertMessage + '以上のデータを削除しますか？');
    if (check_result == true) {
        //$.blockUI();
        $.ajax({
            url: "BMA.php",
            type: "POST",
            timeout: 60000,
            dataType: "json",
            data: postData
        })
            .done(function (data) {
                let data_stringify = JSON.stringify(data);
                let data_json = JSON.parse(data_stringify);
                if (data_json["result_cd"] == 0) {
                    //$.unblockUI();
                    setDB(0);
                    textBoxClear();
                    alert("データを削除しました");
                }
                else {
                    //$.unblockUI();
                    alert("非同期通信時に予期しないエラーが発生しました");
                }
            })
            .fail(function (data) {
                //$.unblockUI();
                alert("非同期通信時に失敗しました");
            });
    }
}

function textBoxClear() {
    document.getElementById("Box1").value = "";
    document.getElementById("Box2").value = "";
    document.getElementById("Box3").value = "";
    document.getElementById("Box4").value = "";
    document.getElementById("Box5").value = "";
    document.getElementById("hiddenBox").value = "";
    document.getElementById("searchBox").value = "";
}

//エンターでタブ移動　コピペ
class FocusOrder {

    constructor() {
        this.nextElements = new Map();//tabOrderを記憶するマップ
        this.init = false;
    }

    initOrder() {
        //初期化
        //DOMを読み込んだ後に実行してください。

        if (this.init) {
            //このコードをは複数回呼ばれるのを想定していません
            console.log('すでに初期化済みです');
            return;
        }

        this.init = true;

        //ターゲットとなる要素をここに指定してください。 
        //textareaは実運用では外してください
        let target = document.querySelectorAll("input, button, select, textarea");

        //getElementsByClassNameで取得することも可能です
        //let target = document.getElementsByClassName("inputs");

        //tabIndexにマイナスを指定してあったら除外
        let wk1 = [];
        for (let i = 0; i < target.length; i++) {
            if (0 <= target[i].tabIndex) {
                wk1.push(target[i]);
            }
        }

        //tabIndex順にソート
        let wk2 = wk1.sort((a, b) => {
            if (a.tabIndex == b.tabIndex) {
                return 0;
            } else if (a.tabIndex > b.tabIndex) {
                return 1;
            } else {
                return -1;
            }
        });

        //次にフォーカスするエレメントをMapにセット
        for (let i = 0; i < wk2.length - 1; i++) {
            this.nextElements.set(wk2[i], wk2[i + 1]);
        }
        this.nextElements.set(wk2[wk2.length - 1], wk2[0]);

        //各エレメントにイベントをセット
        const keyevent = event => {
            if (event.key === 'Enter') {
                this.nextElements.get(event.target).focus();
            }
        };

        for (let i = 0; i < wk2.length; i++) {
            wk2[i].onkeydown = function (event) { keyevent(event) };
        }
    }
};

//クラスのインスタンスを作成
//クラスの定義の後に記述する必要があります。
let f = new FocusOrder();
//初期化
f.initOrder();