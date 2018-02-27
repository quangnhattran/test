@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           <avatar-form :user="{{$profileUser}}"></avatar-form>
            @forelse ($activities as $date=>$activity)
                <h4>{{ $date }}</h4>
                @foreach($activity as $act)
                   @if (view()->exists('users.activities.'.$act->type))
                       @include("users.activities.{$act->type}",['activity'=>$act->subject])
                   @endif
                @endforeach
            @empty
                <p>There is no activity yet.</p>
            @endforelse
            
        </div>
    </div>
</div>
@endsection
