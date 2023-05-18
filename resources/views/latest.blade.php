<!--@php-->
<div class="row container-fluid">
    <div class="col-md-6">
        <h1 class="page-title">Latest Pending Orders</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Order Code</th>
                    <th>Order Date</th>
                    <th>Address</th>
                    <th>Customer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latest_orders As $latest_order)
                <?php $user = \App\User::where('id', $latest_order->user_id)->first(); ?>
                <tr>
                    <td><a style="text-decoration: none;" href="/admin/vieworder/{{ $latest_order->id }}">{{$latest_order->order_code}}</a></td>
                    <td>{{ $latest_order->order_date }}</td>
                    <td>{{ $latest_order->delivery_address }}</td>
                    <td><a style="text-decoration: none;" href="{{ route('voyager.users.show', [$latest_order->user_id]) }}" >{{$user->name}}</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h1 class="page-title">New Customers</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latest_users as $latest_user)
                <tr>
                    <td>{{$latest_user->id}}</td>
                    <td><a style="text-decoration: none;" href="{{ route('voyager.users.show', [$latest_user->id]) }}" >{{$latest_user->name}}</a></td>
                    <td>{{$latest_user->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>