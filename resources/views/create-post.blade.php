<x-layout>
    <div class="container py-md-5 container--narrow">
        <form action="/create-post" method="POST">
        {{-- we should add this @csrf below each post , because if we don't add 
        it Laravel will not allow us to do the request because it will think that
        is a milicious attack --}}
          @csrf
          <div class="form-group">
            <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
            <input value="{{old('title')}}" name="title" id="post-title" class="form-control form-control-lg form-control-title" type="text" placeholder="" autocomplete="off" />
            @include('components.error', ['name'=>'title'])
          </div>
  
          <div class="form-group">
            <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
            <textarea  name="body" id="post-body" class="body-content tall-textarea form-control" type="text">{{old('body')}}</textarea>
            @include('components.error', ['name'=> 'body'])
          </div>
  
          <button class="btn btn-primary">Save New Post</button>
        </form>
      </div>  
</x-layout>