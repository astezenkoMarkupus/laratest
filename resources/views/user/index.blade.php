<div>
  @if(!empty($users))
    @foreach($users as $user)
      <div>
        <h3>{{ $user->name . ' ' . $user->email . ', orders (' . count($user->orders) . '):' }}</h3>
        @if(count($user->orders))
          <ul>
            @foreach($user->orders as $order)
              <li>
                {{ $order->status . ', total: ' . $order->total }}

                {{--@if(count($order->products))
                  <ol>
                    @foreach($order->products as $product)
                      <li>{{ $product->name }}</li>
                    @endforeach
                  </ol>
                @endif--}}
              </li>
            @endforeach
          </ul>
        @else
          <strong>No orders</strong>
        @endif
      </div>
    @endforeach
  @endif
</div>