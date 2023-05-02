<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>天気予報</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 
  <script src='https://use.fontawesome.com/releases/v5.0.13/js/all.js'></script>
  <!-- css -->
  <link rel="stylesheet" href="/css/style2.css">
  {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
  {{-- <link rel="stylesheet" href="{{ url('css/style.css') }}"> --}}
</head>
<body>

<div class="wi1200 he300 mcenter bi1 mb30">
  <h1 class="tcenter pt30">全国お天気検索</h1>

  <div class="dis">

    <div class="wi500 bor5 mr20 ml90 tcenter">
      <h2>郵便番号で検索</h2>
    
      <p>
      <label>郵便番号（半角数字のみ7桁）:<input class="f1-5" type="text" id="number" value="" placeholder="1234567"></label>
      <input class="f1-5" type="button" value="検索" id="checkButton">
      </p>
      
    </div>
      
    <div class="wi500 bor5 tcenter">
      <h2>都道府県名で検索</h2><br>

      <select name="" id="pref" class="f1-5">
        <option value="">選択してください</option>
        @foreach($prefs as $pref)
        <option value="{{$pref->letter}}">{{$pref->pref}}</option>
        @endforeach
      </select>
      <input class="f1-5" type="button" value="検索" id="slot">
    </div>

  </div>

</div>
  
<div class="dis wi1200 mcenter">
  <div id="weather">
    <div id="weather1" class="dis mr2"></div>
  </div>

  <div id="weather2">
    <div id="weather3" class="dis mr2"></div>
  </div>
</div>
  




<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>

// 「検索ボタン」を押すと↓の関数発動
let checkButton = document.getElementById('checkButton');
checkButton.addEventListener('click', buttonClick);

const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
const day = new Date();
const today = day.toLocaleDateString('ja-JP', options);

function buttonClick(){

  // フォームの郵便番号取得してURLに転記
  let number1 = document.getElementById('number');
  let postal1 = number1.value;
  let urlPost1 = `http://api.openweathermap.org/geo/1.0/zip?zip=${postal1},JP&appid=d49f6992e904b3ad121a49dab818c5e6`;
  
  $.ajax({
      url:urlPost1,
      type:'get',
      cache:false,
      dataType:'json'
    }).done(function(data1){
        
        let lat1 = data1.lat;
        let lon1 = data1.lon;
        let url1 = `https://api.openweathermap.org/data/2.5/weather?lat=${lat1}&lon=${lon1}&appid=d49f6992e904b3ad121a49dab818c5e6&lang=ja&units=metric`
        const icon1 = "https://openweathermap.org/img/wn/";
                  
          $.ajax({
            url:url1,
            type:'get',
            cache:false,
            dataType:'json'
          }).done(function(data2){
            console.log(data2);
                // htmlを定義
              let html1 = '';
              // 配列の中の必要な情報を全て取り出す
              html1 = `<div class="bor5 p mr20 mb30 bi2">
                        <h3>${data2.name}の天気予報です</h3>
                        <div>
                          <div>日時：${today}</div>
                          <div>気温：${data2.main.temp}℃</div>
                          <div>湿度：${data2.main.humidity}%</div>
                          <div>気圧：${data2.main.pressure}hpa</div>
                          <div>風速：${data2.wind.speed}m/s</div>
                          <div>天気：${data2.weather[0].description}</div>
                          <div><img src="${icon1+data2.weather[0].icon}@2x.png"></div>
                        </div>
                      </div>
              `;
              $("#weather1").append(html1);
            });
      });

}

// 「検索ボタン」を押すと↓の関数発動
let slot = document.getElementById('slot');
slot.addEventListener('click', slotClick);

function slotClick(){

// フォームの都道府県を取得してその郵便番号をURLに転記
let number2 = document.getElementById('pref');
let postal2 = number2.value;

let urlPost2 = `http://api.openweathermap.org/geo/1.0/zip?zip=${postal2},JP&appid=d49f6992e904b3ad121a49dab818c5e6`;
console.log(number2);
$.ajax({
    url:urlPost2,
    type:'get',
    cache:false,
    dataType:'json'
  }).done(function(data3){
      // ↑のURLから緯度経度を取得　それを使ったURLを作成
      let lat2 = data3.lat;
        let lon2 = data3.lon;
        let url2 = `https://api.openweathermap.org/data/2.5/weather?lat=${lat2}&lon=${lon2}&appid=d49f6992e904b3ad121a49dab818c5e6&lang=ja&units=metric`
        const icon2 = "https://openweathermap.org/img/wn/";
      // let lat2 = data2.response.location[0].y;
      // let lon2 = data2.response.location[0].x;
      // const key2 = "d49f6992e904b3ad121a49dab818c5e6";
      // const icon2 = "https://openweathermap.org/img/wn/";
      // let urlw2 = 'http://api.openweathermap.org/data/2.5/forecast?lat=' + lat2 + '&lon=' + lon2 + '&appid=' + key2 + '&lang=ja&units=metric';
        
        $.ajax({
          url:url2,
          type:'get',
          cache:false,
          dataType:'json'
        }).done(function(data4){
          console.log(data4);
              // htmlを定義
            let html2 = '';
            // 配列の中の必要な情報を全て取り出す
            html2 = `<div class="bor5 p mr20 mb30 bi2">
                        <h3>${data4.name}の天気予報です</h3>
                        <div>
                          <div>日時：${today}</div>
                          <div>気温：${data4.main.temp}℃</div>
                          <div>湿度：${data4.main.humidity}%</div>
                          <div>気圧：${data4.main.pressure}hpa</div>
                          <div>風速：${data4.wind.speed}m/s</div>
                          <div>天気：${data4.weather[0].description}</div>
                          <div><img src="${icon2+data4.weather[0].icon}@2x.png"></div>
                        </div>
                      </div>
              `;
            $("#weather3").append(html2);
          });
    });

}









</script>
  
</body>
</html>