@extends('layouts.app')

@section('content')
<div class="container">
    
        <template>
            <ais-index
                app-id="{{config('scout.algolia.id')}}"
                api-key="{{config('scout.algolia.key')}}"
                index-name="threads"
                query="{{request('q')}}"
            >
            <div class="row">
                <div class="col-md-8">
                        <ais-results>
                            <template slot-scope="{ result }">
                                <p>
                                <a :href="result.path">
                                    <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                </a>
                                </p>
                            </template>
                        </ais-results>
                </div>

                <div class="col-md-4">
                    <div class="card mb-2">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                            <ais-search-box>
                                <ais-input placeholder="Find threads..." autofocus="true" class="form-control"></ais-input>
                            </ais-search-box>
                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="card-header">Filter By Channel</div>
                        <div class="card-body">
                                <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
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
            </ais-index>
        </template>
   
</div>
@endsection
