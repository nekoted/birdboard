<section class="card card-invite flex flex-col mt-3">
    <h3 class="text-black font-bold text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4">Invite a user</h3>
    <form action="{{ $project->path() . '/invite' }}" method="post">
        @csrf
        <div class="mb-3">
            <input type="text" name="email" placeholder="Email address" class="w-full border-gray-light rounded">
        </div>
        <button type="submit" class="button">Invite</button>
    </form>
    @include('projects.errors',['errorBag'=>'invitation'])
</section>
