<x-app-layout>
    <div class="w-1/2 mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-normal mb-10 text-center">
            {{ __('Edit project') }}
        </h2>
        <form action="{{ $project->path() }}" method="post">
            @method('PATCH')
            @include('projects.form', ["submitButtonText"=>"Update"])
        </form>
    </div>
</x-app-layout>
