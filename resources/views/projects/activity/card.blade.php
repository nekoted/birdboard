<div class="card mt-3">
    <ul>
        @foreach ($project->activities as $activity)
            <li>
                @includeFirst(["projects.activity.{$activity->description}","projects.activity.default"])
                <span class="text-gray">{{$activity->created_at->diffForHumans(null,true)}}</span>
            </li>
        @endforeach
    </ul>
</div>