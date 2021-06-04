<div class="card flex flex-col">
    <h3 class="text-black font-bold text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4"><a class="text-black"
            href="{{ $project->path() }}">{{ $project->title }}</a></h3>
    <div class="text-gray mb-4 flex-1">{{ Str::limit($project->description, 100) }}</div>
    <footer>
        <form action="{{ $project->path() }}" method="post" class="text-right">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs">Delete</button>
        </form>
    </footer>
</div>
