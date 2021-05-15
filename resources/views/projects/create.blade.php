<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New project') }}
        </h2>
    </x-slot>
    <form action="/projects" method="post">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="title" class="block">Title</label>
                <input type="text" name="title" id="title">
            </div>
            <div>
                <label for="description" class="block">Description</label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
            </div>
            <div>
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create
                </button>
                <a href="/projects" class="ml-2">Cancel</a>
            </div>
        </div>
    </form>
</x-app-layout>
