<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="/projects/create">New project</a>
        </div>
    </x-slot>
    <section class="grid gap-6 sm:grid-cols-1 xl:grid-cols-3">
        @forelse($projects as $project)
            <article class="bg-white p-5 gap-4 rounded shadow" style="height: 200px;">
                <h3 class="text-xl py-4"><a href="{{ $project->path() }}">{{ $project->title }}</a></h3>
                <div class="text-gray">{{ Str::limit($project->description,100) }}</div>
            </article>
        @empty
            <div>No projects yet !</div>
        @endforelse
    </section>
</x-app-layout>
