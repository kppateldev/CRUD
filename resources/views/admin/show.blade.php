@extends('admin.layouts')
@section('content')
<div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Order</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-primary" href="{{ route('admin.orders') }}"> Back</a>
                </div>
            </div>
        </div>
        <p>Order ID: #{{ $data['order']->id}}</p>
        <p>User Name: {{ $data['order']->UserData->name }}</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="contact-list">
                @foreach ($data['products'] as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->qty }}</td>
                        <td>₹{{ $product->amount }}</td>
                        <td>₹{{ $product->total }}</td>
                    </tr>
                    @endforeach
            </tbody>
            <tfoot>
                <tr>
                <th colspan="4">Grand Total</th>
                <th>₹{{ $data['order']->grand_total }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
