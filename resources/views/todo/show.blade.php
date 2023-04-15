@extends('layouts.todo')

@section('todo')

@include('components.header', ['user' => $user])

<div class="con12 mab50">
    <h1 class="tc">完了済のtodo</h1>
    <table>
        <tr class="f24 bb">
            <th width="600">todo名</th>
            <th width="150"></th>
            <th width="150"></th>
        </tr>
        
        @foreach($todos as $todo)
            @if($todo->comp_flag)
            <tr class="bbd" height="70px">
                <td class="f24">{{$todo->todo}}</td>
                <td>
                    <form action="/todo/start" method="post">
                    @csrf
                    <input type="hidden" name="todo_id" value="{{$todo->id}}">
                    <button type="submit" class="original-button2-2"><i class="fa-solid fa-square-check"></i><span class="mal15">リストに戻す</span></button>
                    </form>
                </td>
            
                <td>
                    <form action="/todo/delete" method="post" onsubmit="return deletetodo();">
                    @csrf
                    <input type="hidden" name="todo_id" value="{{$todo->id}}">
                    <button type="submit" class="original-button4-2"><i class="fa-regular fa-trash-can"></i><span class="mal15">削除</span></button>
                    </form>
                </td>
            </tr>
            @endif
        @endforeach
    </table>
</div>

<p class="tc f20"><a href="/todo">戻る</a></p>




@endsection
