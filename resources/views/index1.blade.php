<!DOCTYPE html>
<html>
<head>
	<title>Pricing page</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">

	<style type="text/css">
		.container{
			margin-top:100px;
		}
		.card{
			width:300px;
		}
		.card:hover{
			-webkit-transform: scale(1.05);;
			-moz-transform: scale(1.05);
			-ms-transform: scale(1.05);
			-o-transform: scale(1.05);
			transform: scale(1.05);
			-webkit-transition: all .3s ease-in-out;
			-moz-transition: all .3s ease-in-out;
			-ms-transition: all .3s ease-in-out;
			-o-transition: all .3s ease-in-out;
			transition: all .3s ease-in-out;
		}
		.list-group-item{
			border: 0px;
			padding: 5px;
		}
		.price{
			font-size: 72px;
		}
		.currency{
			position: relative;
			font-size: 25px;
			top: -31px;
		}
	</style>

</head>
<body>


	<div class="container">

		
		<div class="row">
			@foreach($products as $productID => $attibutes)
			<div class="col-md-4">
				<div class="card">
					<div class="card-header text-center">
						<h2 class="price"><span class="currency">$</span>{{ ($attibutes['price']/100) }}</h2>
					</div>
					<div class="card-body text-center">
						<div class="card-title">
							<h2>{{ $attibutes['title'] }}</h2>
						</div>
						<ul class="list-group">
						@foreach($attibutes['features'] as $feature)
							<li class="list-group-item">{{ $feature }}</li>
						@endforeach	
						</ul>
						<br>

						<!-- form de pagamento do stripe -->
						<form action="/pagamentoStripe" method="POST">
						@csrf
						  <script
						    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						    data-key="{{ $pubKey }}"
						    data-amount="{{ $attibutes['price'] }}"
						    data-name="{{ $attibutes['title'] }}"
						    data-description="Widget"
						    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
						    data-locale="auto">
						  </script>
						</form>

					</div>
				</div>
			</div>
			@endforeach

		</div>	

		



		
	</div>



	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>

</body>
</html>