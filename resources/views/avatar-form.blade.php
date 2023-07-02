<x-layout>
    <div class="container contanier--narrow py-md-5">
        <h2 class="text-center mb-3">Upload a New Avatar</h2>
        <!-- You should write enctype="multipart/form-data" if you will upload anythin
        other than text-->
        <form action="/manage-avatar" method='POST' enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name='avatar' required>
                @include('components.error', ['name'=>'avatar'])
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</x-layout>