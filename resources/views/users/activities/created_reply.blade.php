@component('users.activities.activity')
    @slot('heading')
        {{$profileUser->name}} replied to
        <a href="{{ $activity->thread->path() }}">{{$activity->thread->title}}</a>
    @endslot

    @slot('body')
        {{$activity->body}}
    @endslot
@endcomponent