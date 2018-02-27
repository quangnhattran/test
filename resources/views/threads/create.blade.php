@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
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
                    <textarea name="body" rows="4" class="form-control">{{old('body')}}</textarea>
                </div>
                <button class="btn btn-primary" type="submit">Create</button>
            </form>
            @include('partials.errors')
        </div>
    </div>
</div>
@endsection
