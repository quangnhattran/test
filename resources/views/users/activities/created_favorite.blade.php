@component('users.activities.activity')
    @slot('heading')
        <a href="{{$activity->favorited->path()}}">
                {{ $profileUser->name }} favorited a reply
        </a>
    @endslot

    @slot('body')
        {{$activity->favorited->body}}
    @endslot
@endcomponent