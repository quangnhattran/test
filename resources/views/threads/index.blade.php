@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @include('threads._list')
            {{ $threads->links() }}
        </div>

        <div class="col-md-4">
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
