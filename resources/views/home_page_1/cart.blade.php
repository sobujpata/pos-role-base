@extends('layouts.app1')

@section('content')
<div class="container">
    <h3>🛒 Cart</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th><th>Products</th><th>Price</th><th>Qty</th><th>Total</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cart as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['price'] }}</td>
                    <td id="qty">{{ $item['quantity'] }}</td>
                    <td>{{ $item['price'] * $item['quantity'] }}</td>
                    <td>
                        <a href="{{ route('cart.remove', $item['id']) }}" class="btn btn-sm btn-danger">Remove</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Cart is empty.</td></tr>
            @endforelse
        </tbody>
    </table>

    <hr>

    <h4>Add Product (Test)</h4>
    <form id="addToCartForm">
        @csrf
        <input type="hidden" name="id" value="1">
        <input type="hidden" name="name" value="Toy Car">
        <input type="hidden" name="price" value="150">

        <div class="form-group">
            <label>Quantity:</label>
            <input type="number" name="quantity" value="1" class="form-control" style="width: 150px;">
        </div>

        <button type="submit" class="btn btn-success mt-2">Add to Cart</button>
    </form>
</div>
@endsection

@section('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
<script>
    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = new FormData(this);

        axios.post("{{ route('cart.add') }}", form)
            .then(res => {
                if (res.data.success) {
                    alert('Product added to cart!');
                    window.location.reload(); // Refresh to show updated cart
                }
            }).catch(err => {
                console.error(err);
                alert('Error adding to cart');
            });
    });

    
</script>
<script>
$(document).ready(function(){
    $('input[name="quantity"]').on('input', function(){
        $('#qty').text($(this).val());
    });
});
</script>
@endsection
