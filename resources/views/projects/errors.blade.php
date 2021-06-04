@if ($errors->{$errorBag ?? 'default'}->any())
    <div class="m-4">
        <ul class="text-red-800">
            @foreach ($errors->{$errorBag ?? 'default'}->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
