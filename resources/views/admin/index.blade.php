@extends('admin.layouts')
@section('content')
<div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Orders List</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-primary" href="{{ route('admin.create') }}"> Create Order</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>User Name</th>
                    <th>Total</th>
                    <th>Created At</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody id="contact-list">
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->UserData->name }}</td>
                        <td>₹{{ $order->grand_total }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td><a class="btn btn-primary" href="{{ route('admin.show',$order->id) }}">View</a></td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        {!! $orders->links() !!}
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endsection
