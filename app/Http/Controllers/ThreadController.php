<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Filters\ThreadsFilters;
use App\Http\Requests\CreateThreadRequest;
use App\Trending;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }
    public function index(ThreadsFilters $filter,Trending $trending) 
    {
        $threads = Thread::filter($filter)->latest()->paginate(5);
        return view('threads.index',[
            'threads' => $threads,
            'trending' => $trending->all()
        ]);
    }

    public function show($channelId,Thread $thread,Trending $trending) 
    {
       if(auth()->check()) auth()->user()->read($thread);
        $trending->push($thread);
        $thread->increment('visits');
       return view('threads.show',compact('thread')); 
    }

    public function create() 
    {
       return view('threads.create');
    }

    public function store(CreateThreadRequest $request) 
    {
       //dd('jk');
       auth()->user()->threads()->create($request->except('g-recaptcha-response'));
       return redirect('/threads')->with('flash','Your thread created');
    }

    public function update($channel, Thread $thread)
    {
        $data = request()->validate([
            'title' => 'required|min:3',
            'body' => 'required|min:6'
        ]);
        $thread->update($data);
        return response('Thread Updated',202);
    }

    public function destroy($channelId,Thread $thread) 
    {
        $thread->delete();
       return redirect('/threads')->with('flash','Your thread deleted');
    }
}
