<div class="container">
    <ul class="list-group">
    @foreach ($notifications as $notification)
        <li class="list-group-item">
            <strong>{{ $notification->data['title'] }}</strong><br>
            {!! $notification->data['message'] !!}<br>
            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
        </li>
    @endforeach
</ul>
</div>