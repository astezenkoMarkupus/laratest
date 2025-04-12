<div class="orders">
    @if(!empty($orders))
        @foreach($orders as $order)
            {{$order['id']}}, {{$order['status']}}<br>
        @endforeach
    @endif
</div>