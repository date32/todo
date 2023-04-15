@extends('layouts.todo')

@section('todo')

@include('components.header', ['user' => $user])

<div class="con8">

    <h1 class="tc mab30">todo変更</h1>

    <div class="mab50">
        <form action="/todo/update" method="post">
            @csrf
            <div class="flex">
                <div class="mar30">
                    <input class="c-form-text" type="text" name="todo" value="{{$todo->todo}}">
                    <input type="hidden" name="todo_id" value="{{$todo->id}}">
                    @error('todo')
                        <p class="error tc">{{$message}}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="original-button1">変更します</button>
                </div>
            </div>
        </form>
    </div>
    
    <p class="f24"><a href="/todo">戻る</a></p>

</div>

@endsection
