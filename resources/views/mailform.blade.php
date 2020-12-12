@extends('layouts.template')

@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-5">社会の窓が空いている人に匿名でメールを送ろう！</h1>
        <p class="lead">
            目の前にいる友人や恋人の社会の窓が空いている。気になるけれど、気軽には言えない。<br />
            そんな相手に匿名でメールを送ってみましょう。
        </p>
    </div>
</div>
<div class="container">
    <form action="{{ route('inquiry') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">社会の窓が空いている人のお名前</label>
              <input type="text"
              name="name" 
              class="form-control @error('name') is-invalid @enderror" 
              id="name" 
              placeholder="お名前" 
              value="{{ old('name', session('inquiry.name')) }}"/>
            <div class="invalid-feedback">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="email">社会の窓が空いている人のメールアドレス</label>
             <input type="text" 
             name="email" 
             class="form-control @error('email') is-invalid @enderror" 
             id="email" 
             placeholder="メールアドレス"
             value="{{ old('email', session('inquiry.email')) }}"/>
            <div class="invalid-feedback">
                @error('email')
                    {{ $message }}
                @enderror
            </div>
        <div class="form-group">
            <label for="relations">社会の窓が空いている人との関係</label>
           <select name="relations" class="form-control @error('relations') is-invalid @enderror" id="relations">
                <option value="">選択してください</option>
                @foreach (config('relations') as $value)
                    <option value="{{ $value }}"@if (old('relations', session('inquiry.relations')) === $value) selected  @endif>{{ $value }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                @error('relations')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="content">何か伝えたいこと</label>
           <textarea name="content" 
           class="form-control @error('content') is-invalid @enderror" 
           id="content" 
           rows="3" 
           placeholder="伝えたいことを入力してください">{{ old('content', session('inquiry.content')) }}</textarea>
            <div class="invalid-feedback">
                @error('content')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary" type="submit">確認画面へ</button>
        </div>
    </form>        
</div>
@endsection
