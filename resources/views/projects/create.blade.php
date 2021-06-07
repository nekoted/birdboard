<x-app-layout>
    <div class="w-1/2 mx-auto p-6 bg-card rounded shadow">
        <h2 class="text-2xl font-normal mb-10 text-center">
            {{ __('New project') }}
        </h2>
        <form action="/projects" method="post">
            @csrf
            @include('projects.form', ["submitButtonText"=>"Create"])
        </form>
    </div>
</x-app-layout>
