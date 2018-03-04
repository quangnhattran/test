@extends('layouts.app')

@section('content')
    <div class="container">
        <template>
            <ais-index
                app-id="{{config('scout.algolia.id')}}"
                api-key="{{config('scout.algolia.key')}}"
                index-name="threads"
            >
                <ais-search-box></ais-search-box>

                <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>

                <ais-results>
                <template slot-scope="{ result }">
                    <a :href="result.path">
                    <p>
                    <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                    </p>
                    </a>
                </template>
                </ais-results>
            </ais-index>
        </template>
    </div>
@endsection