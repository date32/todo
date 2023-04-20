<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 
  <script src='https://use.fontawesome.com/releases/v5.0.13/js/all.js'></script>
  <link rel="stylesheet" href="">
</head>
<body>
<h1>全国お天気検索</h1>

<div>
  <h2>郵便番号で検索</h2>

  <p>
  <label>郵便番号（半角数字のみ7桁）：<input type="text" id="number" value="" placeholder="1234567"></label>
  <input type="button" value="検索" id="checkButton">
  </p>
  

  

  <div id="weather">
    <div id="weather1"></div>
  </div>


<select name="" id="pref">
  <option value="">選択してください</option>
  @foreach($prefs as $pref)
  <option value="{{$pref->letter}}">{{$pref->pref}}</option>
  @endforeach
</select>
<input type="button" value="検索" id="slot">




<div id="weather2">
  <div id="weather3"></div>
</div>




</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>

  // 「検索ボタン」を押すと↓の関数発動
let slot = document.getElementById('slot');
slot.addEventListener('click', slotClick);


function slotClick(){

  // divを消す（２回目用）
  let ele = document.getElementById("weather3");
  ele.remove();

  // 消したdivを復活（初期化）
  let text = document.getElementById('weather2');
  let add = '<div id="weather3"></div>';
  text.insertAdjacentHTML( 'beforeend', add);

  // フォームの番号取得してURLに転記
  let num = document.getElementById('pref');
  let pos = num.value;
  // let pos = '8700100';
  let url2 = 'http://geoapi.heartrails.com/api/json?method=searchByPostal&postal=' + pos;
  
  $.ajax({
      url:url2,
      type:'get',
      cache:false,
      dataType:'json'
    }).done(function(data2){
        // ↑のURLから緯度経度を取得　それを使ったURLを作成
        let lat2 = data2.response.location[0].y;
        let lon2 = data2.response.location[0].x;
        const key2 = "d49f6992e904b3ad121a49dab818c5e6";
        const icon2 = "https://openweathermap.org/img/wn/";
        let urlw2 = 'http://api.openweathermap.org/data/2.5/forecast?lat=' + lat2 + '&lon=' + lon2 + '&appid=' + key2 + '&lang=ja&units=metric';
          
          $.ajax({
            url:urlw2,
            type:'get',
            cache:false,
            dataType:'json'
          }).done(function(dataw2){
            console.log(dataw2);
                // htmlを定義
              let htmlw2 = '';
              // 配列の中の必要な情報を全て取り出す
              htmlw2 = `<h3>${dataw2.city.name}の天気予報です</h3>`;
                for(let i=0; i<dataw2.list.length; i++) {
                  htmlw2 += `
                    <div>
                      <div>日時：${dataw2.list[i].dt_txt}</div>
                      <div>気温：${(Math.round(dataw2.list[i].main.temp *10)) / 10}℃</div>
                      <div>湿度：${dataw2.list[i].main.humidity}%</div>
                      <div>気圧：${dataw2.list[0].main.pressure}hpa</div>
                      <div>風速：${dataw2.list[0].wind.speed}m/s</div>
                      <div>天気：${dataw2.list[i].weather[0].description}</div>
                      <div><img src="${icon2+dataw2.list[i].weather[0].icon}@2x.png"></div>
                    </div>
                    `;
                }
              $("#weather3").append(htmlw2);
            });
      });

}










// 「検索ボタン」を押すと↓の関数発動
let checkButton = document.getElementById('checkButton');
checkButton.addEventListener('click', buttonClick);

function buttonClick(){

  // divを消す（２回目用）
  let element = document.getElementById("weather1");
  element.remove();

  // 消したdivを復活（初期化）
  let textbox = document.getElementById('weather');
  let add_code = '<div id="weather1"></div>';
  textbox.insertAdjacentHTML( 'beforeend', add_code);

  // フォームの番号取得してURLに転記
  let number = document.getElementById('number');
  let postal = number.value;
  let url = 'http://geoapi.heartrails.com/api/json?method=searchByPostal&postal=' + postal;
  // let url = 'http://geoapi.heartrails.com/api/json?method=searchByGeoLocation&x=139.03359&y=36.23258'
 

  $.ajax({
      url:url,
      type:'get',
      cache:false,
      dataType:'json'
    }).done(function(data){
      
        // ↑のURLから緯度経度を取得　それを使ったURLを作成
        let lat = data.response.location[0].y;
        let lon = data.response.location[0].x;
        // let lat = '36.23258';
        // let lon = '139.03359';
        
        const key = "d49f6992e904b3ad121a49dab818c5e6";
        const icon = "https://openweathermap.org/img/wn/";
        let urlw = 'http://api.openweathermap.org/data/2.5/forecast?lat=' + lat + '&lon=' + lon + '&appid=' + key + '&lang=ja&units=metric';
          
          $.ajax({
            url:urlw,
            type:'get',
            cache:false,
            dataType:'json'
          }).done(function(dataw){
            
                // htmlを定義
              let htmlw = '';
              // 配列の中の必要な情報を全て取り出す
              htmlw = `<h3>${dataw.city.name}の天気予報です</h3>`;
                for(let i=0; i<dataw.list.length; i++) {
                  htmlw += `
                    <div>
                      <div>日時：${dataw.list[i].dt_txt}</div>
                      <div>気温：${(Math.round(dataw.list[i].main.temp *10)) / 10}℃</div>
                      <div>湿度：${dataw.list[i].main.humidity}%</div>
                      <div>気圧：${dataw.list[0].main.pressure}hpa</div>
                      <div>風速：${dataw.list[0].wind.speed}m/s</div>
                      <div>天気：${dataw.list[i].weather[0].description}</div>
                      <div><img src="${icon+dataw.list[i].weather[0].icon}@2x.png"></div>
                    </div>
                    `;
                }
              $("#weather1").append(htmlw);
            });
      });
}

</script>
  
</body>
</html>