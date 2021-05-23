@csrf
<div class="grid grid-cols-1 gap-6">
    <div class="field mb-6">
        <label for="title" class="label text-sm mb-2 block">Title</label>
        <input class="w-full border border-gray-400 p-2 rounded" type="text" name="title" id="title"
            value="{{ $project->title }}" required>
    </div>
    <div class="field mb-6">
        <label for="description" class="label text-sm mb-2 block">Description</label>
        <textarea class="w-full border border-gray-400 p-2 rounded" name="description" id="description" cols="30"
            rows="10" required>{{ $project->description }}</textarea>
    </div>
    <div>
        <button type="submit"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ $submitButtonText }}
        </button>
        <a href="/projects" class="ml-2">Cancel</a>
    </div>
</div>
@if ($errors->any())
    <div class="m-4">
        <ul class="text-red-800">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
