@extends('layouts.todo')

@section('todo')

@include('components.header', ['user' => $user])

<div class="flex jc con12 mab50">
        <form action="/todo/store" method="post">
            @csrf
            <div class="flex">
                <div class="mar30">
                    <input class="c-form-text" type="text" name="todo" placeholder="todoを入力してください">
                    @error('todo')
                        <p class="error tc">{{$message}}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="original-button1">登録します</button>
                </div>
            </div>
        </form>
        <form class="f16 " method="POST" action="/todo/upload" enctype="multipart/form-data">
            @csrf
            <div>
                <p>プロフィール画像登録</p>
                <input type="file" name="image" class="mab15">
                <br>
                <button>アップロード</button>
            </div> 
        </form>
</div>

<div class="con12">
    <h1 class="tc f32">todo一覧</h1>
    <table>
        <tr class="f24 bb">
            <th width="600">todo名</th>
            <th width="150"></th>
            <th width="150"></th>
            <th width="150"><a class="f16" href="/todo/show">完了済のtodo</a></th>
        </tr>
        
        @foreach($todos as $todo)
            @if($todo->comp_flag)
            @else
            <tr class="bbd" height="70px">
                <td class="f24">{{$todo->todo}}</td>
                <td>
                    <form action="/todo/finish" method="post">
                    @csrf
                    <input type="hidden" name="todo_id" value="{{$todo->id}}">
                    <button type="submit" class="original-button2"><i class="fa-solid fa-square-check"></i><span class="mal15">完了</span></button>
                    </form>
                </td>
                <td>
                    <form action="/todo/edit/{{$todo->id}}" method="get">
                    @csrf
                    <input type="hidden" name="todo_id" value="{{$todo->id}}">
                    <button type="submit" class="original-button3"><i class="fa-solid fa-pen-nib"></i><span class="mal15">変更</span></button>
                    </form>
                </td>
                <td>
                    <form action="/todo/delete" method="post" onsubmit="return deletetodo();">
                    @csrf
                    <input type="hidden" name="todo_id" value="{{$todo->id}}">
                    <button type="submit" class="original-button4"><i class="fa-regular fa-trash-can"></i><span class="mal15">削除</span></button>
                    </form>
                </td>
            </tr>
            @endif
        @endforeach
    </table>
</div>

    
<script>
    function deletetodo() {
        if (confirm('本当に削除しますか？')) {
            return true;
        } else {
            return false;
        }
    }
</script>





@endsection