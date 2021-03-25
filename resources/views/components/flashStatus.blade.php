@if (session('message'))
    <div class="alert alert-{{ session('message')['alert-type'] }}">
        {{ session('message')['content'] }}
    </div>
@endif
