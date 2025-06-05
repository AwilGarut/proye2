@extends('layouts.app')

@section('content')
<h2>Daftar </h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Produk</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name }}</td>
            <td>{{ $order->campProduct->name }}</td>
            <td>{{ ucfirst($order->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection