<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between">
            <p class="text-gray text-sm"><a href="/projects" class="text-gray">My projects</a> /
                {{ $project->title }}</p>
        </div>
    </x-slot>

    <div class="lg:flex -mx-3">
        <section class="lg:w-3/4 px-3 mb-6">
            <section class="mb-6">
                <h3 class="font-normal text-gray text-lg mb-3">Tasks</h3>
                <div class="card mb-3">Lorem ipsum</div>
                <div class="card mb-3">Lorem ipsum</div>
                <div class="card mb-3">Lorem ipsum</div>
                <div class="card">Lorem ipsum</div>
            </section>
            <section>
                <h3 class="font-normal text-gray text-lg mb-3">General notes</h3>
                <textarea class="card w-full" style="min-height:200px;">Lorem ipsum</textarea>
            </section>
        </section>
        <section class="lg:w-1/4 px-3">
            @include('projects.card')
        </section>
    </div>
</x-app-layout>
