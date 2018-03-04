@extends('layouts.app')
@section('header')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Create New Thread
                </div>
                <div class="card-body">
                    <form action="/threads" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="channel">Choose a Channel</label>
                        <select name="channel_id" class="form-control">
                            <option value="" selected>Which channel?</option>
                            @foreach ($channels as $channel)
                                <option value="{{ $channel->id }}" {{$channel->id==old('channel_id') ? 'selected' : null}}>{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Thread's Title</label>
                        <input type="text" name="title" value="{{old('title')}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Thread's Body</label>
                        <wysiwyg :name="`body`"></wysiwyg>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LfTLkoUAAAAAHzP4MFUOjHWd4qzjtwgLnvS0OAo"></div>
                    </div>
                    <button class="btn btn-primary" type="submit">Create</button>
                    </form>
                    @include('partials.errors')
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
