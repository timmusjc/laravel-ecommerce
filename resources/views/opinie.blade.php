@extends('layout')

@section('title')
    Opinie
@endsection

@section('main_content')
    <div class="container">
        <h1>Komentarze</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/opinie/check">
            @csrf
            <input type="email" name="email" id="email" placeholder="Podaj swój email" class="form-control"><br>
            <input type="text" name="subject" id="subject" placeholder="Napisz temat" class="form-control"><br>
            <textarea name="message" id="message" cols="30" rows="10" class="form-control"
                placeholder="Napisz komentarz"></textarea><br>
            <button type="submit" class="btn btn-success">Wyślij</button><br>
        </form>
    </div>
@endsection
