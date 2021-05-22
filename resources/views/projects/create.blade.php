<x-app-layout>
    <div class="w-1/2 mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-normal mb-10 text-center">
            {{ __('New project') }}
        </h2>
        <form action="/projects" method="post">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div class="field mb-6">
                    <label for="title" class="label text-sm mb-2 block">Title</label>
                    <input class="w-full border border-gray-400 p-2 rounded" type="text" name="title" id="title">
                </div>
                <div class="field mb-6">
                    <label for="description" class="label text-sm mb-2 block">Description</label>
                    <textarea class="w-full border border-gray-400 p-2 rounded" name="description" id="description" cols="30" rows="10"></textarea>
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
    </div>
</x-app-layout>
