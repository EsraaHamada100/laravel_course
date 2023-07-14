<div class="list-group">
    @foreach($followingTheseUsers as $following)
    
        <a href="/profile/{{$following->userDoingTheFollowing->username}}" class="list-group-item list-group-item-action">
            <img class="avatar-tiny" src="{{$following->userBeingFollowed->avatar}}" />
            {{$following->userBeingFollowed->username}}
        </a>
    @endforeach
</div>