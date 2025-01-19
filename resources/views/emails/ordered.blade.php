<p class="mb-4">{{$product['ownerName']}}様の商品が注文されました。</p>

商品内容
<ul class="mb-4">
    <li>商品名：{{$product['name']}}</li>
    <li>商品金額：{{number_format($product['price'])}}円</li>
    <li>商品数：{{$product['quantity']}}</li>
    <li>合計金額：{{number_format($product['price'] * $product['quantity'])}}</li>
</ul>

購入者情報
{{$user->name}}様