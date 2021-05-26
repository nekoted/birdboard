<div class="card mt-3">
    <ul>
        @foreach ($project->activities as $activity)
            <li>@includeFirst(["projects.activity.{$activity->description}","projects.activity.default"])</li>
        @endforeach
    </ul>
</div>