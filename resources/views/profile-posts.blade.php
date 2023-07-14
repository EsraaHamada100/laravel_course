{{-- :variableName => we write that way if the variable is dynamic 
  this variable is comming from getSharedData function in UserController class--}}
<x-profile :sharedData="$sharedData" docTitle="{{$sharedData['username']}}'s Profile">
  @include('profile-posts-only')
</x-profile>