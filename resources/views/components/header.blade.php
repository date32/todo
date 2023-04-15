<div class="bc-b mab50">
    <div class="flex con12 c-w h100">
        <div class="f32 hc">
            <i class="fa-solid fa-briefcase"></i><span class="mal30">todoアプリ</span>
        </div>
        <div class="mar flex">
            <div class="hc mar30">
                こんにちは<span class="f24">{{$user->name}}</span>さん<br>
                <a href="/dashboard">ダッシュボードへ</a>
            </div>
            <div><img class="img" src="{{asset($user->img)}}" alt=""></div>
        </div>
    </div>
</div>


