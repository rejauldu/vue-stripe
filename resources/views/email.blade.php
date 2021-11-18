<!DOCTYPE html>
<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{{ config('app.name') ?? url('/') }}</title>
	</head>
	<body>

		<div style='width:92%; max-width:800px; margin:0 auto; border:1px solid #dedede; padding:0 3% 5% 3%; display:block; overflow:hidden; font-family:myriad-pro;'>
			<div style="width:96%;padding:0">
				<div style="margin:0 auto; width:160px; max-width:30%;"><img style="width:100%; max-width:100%" src="https://ict4today.com/{{ config('app.logo') ?? 'images/logo.png' }}" alt="Logo" /></div>
			</div>
			<hr style="border:1px solid #555;">
			<div style="width:100%;">
				<h3 style="text-transform: uppercase;">Order Confirmation</h3>
			</div>
			<div style="width:100%;text-align:justify">
				<p>Dear {{ $first_name ?? 'Customer'}} {{ $last_name ?? '' }},</p>
				<p>Thank you for shopping with us. Your order details are indicated below.</p>
			</div>
			@php($date = date('M d, Y', strtotime($order_date ?? now())))

			<div style="width:100%; overflow:hidden;">
				<table style="width:100%; text-align:center;">
					<thead>
						<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Line Total</th></tr>
					</thead>
					<tbody>
                        @php($total = 0)
						@foreach ($products as $product)
                            @php($product = (object) $product)
						<tr style="border-top:1px dotted #555; border-bottom:1px dotted #555;">
							<td>
								{{ $product->name ?? '' }}
							</td>
							<td>
                                ${{ $product->price ?? '' }}
							</td>
							<td>
								{{ $product->quantity ?? '' }}
							</td>
							<td>
                                ${{ $product->price*$product->quantity }}
							</td>
						</tr>
                            @php($total+=$product->price * $product->quantity)
						@endforeach
                        <tr style="border-top:1px dotted #555; border-bottom:1px dotted #555">
                            <td colspan="3">
                                Subtotal
                            </td>
                            <td>
                                ${{ $total }}
                            </td>
                        </tr>
                        <tr style="border-top:1px dotted #555; border-bottom:1px dotted #555">
                            <td colspan="3">
                                Tax 20%
                            </td>
                            <td>
                                ${{ $total*20/100 }}
                            </td>
                        </tr>
                        <tr style="border-top:1px dotted #555; border-bottom:1px dotted #555">
                            <td colspan="3">
                                Total
                            </td>
                            <td>
                                ${{ $total+$total*20/100 }}
                            </td>
                        </tr>
					</tbody>
				</table>
			</div>
			<div style="width:100%; height:30px;"></div>
			<hr style="color:#555; border-top:1px dotted #555;">
			<div style="width:100%; height:30px;"></div>
            <span style="color:#555">Thanks for ordering,</span><br/>
            <span style="color:#555"></span><br/>
            <span style="color:#555"><strong>{{ config('app.name') ?? url('/') }} Team</strong></span>
		</div>
	</body>
</html>
