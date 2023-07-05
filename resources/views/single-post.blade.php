<x-layout>
    
    <div class="container py-md-5 container--narrow">
        <div class="d-flex justify-content-between">
            <h2>{{$post->title}}</h2>
            {{-- The buttons will only appear for the users who make this post--}}
            @can('update', $post)
                <span class="pt-2">
                    <a href="/post/{{$post->id}}/edit" class="text-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
                    <form class="delete-post-form d-inline" action="/post/{{$post->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
                    </form>
                </span>
            @endcan
        </div>

        <p class="text-muted small mb-4">
            <a href="#"><img class="avatar-tiny" src="{{$post->user->avatar}}" /></a>
            Posted by <a href="#">{{$post->user->username}}</a> on {{$post->created_at->format('j/n/Y')}}
        </p>

        <div class="body-content">
            {{-- We make that to allow injection of tags , note only do that
                if you 100% sure that will not couse any security issues --}}
            {!!$post->body !!}
        </div>
  </div>
</x-layout>
