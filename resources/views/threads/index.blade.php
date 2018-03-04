@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @include('threads._list')
            {{ $threads->links() }}
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <form action="/threads/search" method="get">
                        <div class="form-group">
                            <input type="text" name="q" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            @if(count($trending))
            <div class="card">
                <div class="card-header">Trending Threads</div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach ($trending as $thread)
                            <div class="list-group-item">
                                <a href="{{$thread->link}}">
                                    {{$thread->title}}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
