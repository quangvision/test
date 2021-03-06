@extends('layouts.app')
@section('header')
    <link rel="stylesheet" href="/css/vendor/atwho.css">
@endsection
@section('content')
<thread-view :thread="{{$thread}}" inline-template>
    <div class="container">
    <div class="row">
        <div class="col-md-8">
            @include('threads._question')
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
                <div class="card-body level" v-if="signedIn">
                    <subscribe-button :active="{{json_encode($thread->isSubscribed)}}"></subscribe-button>
                    <button class="btn btn-sm btn-default" v-if="authorize('isAdmin')" 
                                    @click="toggleLock"
                                    v-text="locked ? 'Unlock' : 'Lock'"></button>
                </div>
            </div>
        </div>
    </div>
    </div>
</thread-view>
@endsection
