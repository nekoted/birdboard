<article class="card" style="height: 200px;">
    <h3 class="text-black font-bold text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4"><a class="text-black"
            href="{{ $project->path() }}">{{ $project->title }}</a></h3>
    <div class="text-gray">{{ Str::limit($project->description, 100) }}</div>
</article>
