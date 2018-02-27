@component('users.activities.activity')
    @slot('heading')
        {{$profileUser->name}} created thread
        <a href="{{ $activity->path() }}">{{$activity->title}}</a>
    @endslot

    @slot('body')
        {{$activity->body}}
    @endslot
@endcomponent