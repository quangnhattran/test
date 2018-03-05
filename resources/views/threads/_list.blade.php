@forelse ($threads as $thread)
<div class="card">
    <div class="card-header level">
        <div>
        <a href="{{ $thread->path() }}">
            @if (auth()->check() && $thread->hasUpdateFor(auth()->user()))
            <h5><strong>{{ $thread->title }}</strong></h5>
            @else
                <h5>{{ $thread->title }}</h5>
            @endif
            
        </a>
        <h6>Posted by <a href="/profiles/{{$thread->creator->name}}">{{$thread->creator->name}}</a> {{$thread->creator->reputation}} XP</h6>
        </div>
        <span class="ml-auto">{{$thread->replies_count}} {{str_plural('reply',$thread->replies_count)}}</span>
    </div>

    <div class="card-body trix-content">
        {!! $thread->body !!}
    </div>
    <div class="card-footer">
        {{ $thread->visits }} visits
    </div>
</div>
<hr>
@empty
    <p>There is no posts yet.</p>
@endforelse