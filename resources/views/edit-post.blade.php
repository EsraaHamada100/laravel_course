<x-layout docTitle="Editing: {{$post->title}}">
    <div class="container py-md-5 container--narrow">
        <p><small><strong><a href="/post/{{$post->id}}">&laquo; Back to post permalink</a></strong></small><p>
        <form action="/post/{{$post->id}}" method="POST">
        {{-- we should add this @csrf below each post , because if we don't add 
        it Laravel will not allow us to do the request because it will think that
        is a milicious attack --}}
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
            <!-- Here I told him if there is no old title he will get it from database-->
            <input value="{{old('title', $post->title)}}" name="title" id="post-title" class="form-control form-control-lg form-control-title" type="text" placeholder="" autocomplete="off" />
            @include('components.error', ['name'=>'title'])
          </div>
  
          <div class="form-group">
            <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
            <textarea  name="body" id="post-body" class="body-content tall-textarea form-control" type="text">{{old('body', $post->body)}}</textarea>
            @include('components.error', ['name'=> 'body'])
          </div>
  
          <button class="btn btn-primary">Save Changes</button>
        </form>
      </div>  
</x-layout>