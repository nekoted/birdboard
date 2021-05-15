<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->title }}
        </h2>
    </x-slot>
    <p>{{ $project->description }}</p>
    <div class="my-4"></div>
    <a href="/projects">Go back</a>
</x-app-layout>
