@extends('layouts.app')
@section('header')
    <link rel="stylesheet" href="/css/vendor/atwho.css">
@endsection
@section('content')
<thread-view :data="{{$thread}}" inline-template>
    <div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header level">
                    <a href="{{ $thread->path() }}">
                    {{ $thread->title }}
                    
                    </a>
                    @can('update',$thread)
                    <form action="{{ $thread->path() }}" method="post" class=" ml-auto">
                        {{ csrf_field() }} {{method_field('delete')}}
                        <button class="btn btn-sm" type="submit">Delete</button>
                    </form>
                    
                    @endcan
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
            <hr>
            
            <replies  @added="replies_count++" @removed="replies_count--">
            </replies>
            {{--  Add New Reply  --}}
            
            @include('partials.errors')
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <a href="/profiles/{{$thread->creator->name}}">{{ ucfirst($thread->creator->name)}}</a>
                     started this thread 
                    {{ $thread->created_at->diffForHumans()}}
                    and it has @{{replies_count}} {{ str_plural('reply',$thread->replies_count) }}
                </div>

                <subscribe-button :active="{{json_encode($thread->isSubscribed)}}"></subscribe-button>
            </div>
        </div>
    </div>
    </div>
</thread-view>
@endsection
