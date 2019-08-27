<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    
	private $secretkey;
	private $publishableKey;

	public function __construct(){
		//para ir para o modo live é necessário substituir as chaves pelas do modo live
		$this->secretkey = "sk_test_xhUK629AQcOp4AqmXDiHUQER";
		$this->publishableKey = "pk_test_rOSEcgdKPdwldxOssVVZ4SDg";

		\Stripe\Stripe::setApiKey($this->secretkey);
		\Stripe\Stripe::setVerifySslCerts(false);

	}

	###############################################
	#### Payments
	###############################################

	//função que retorna uma tela de pagamento
	public function index1(){

		$products = array(
			"product1" => array(
				"title" => "My amazing product 1",
				"price" => 6700,
				"features" => array(
					"feature1", "feature2", "feature3"
				)
			),
			"product2" => array(
				"title" => "My amazing product 2",
				"price" => 14700,
				"features" => array(
					"feature1", "feature2", "feature3"
				)
			),
			"product3" => array(
				"title" => "My amazing product 3",
				"price" => 3700,
				"features" => array(
					"feature1", "feature2", "feature3"
				)
			)
		);
		
		$pubKey = $this->publishableKey;

		return view('index1', compact("products", "pubKey"));

	}

	public function index2(){

		$pubKey = $this->publishableKey;

		return view('index2', compact("pubKey"));

	}

	//função que gera um pagamento e cria um customer para utilizar nas outras operações
	//como subscription 
	public function pagamentoStripe(){

		$token = $_POST['stripeToken'];
		$email = $_POST['stripeEmail'];
		//$productID = $_GET['id'];

		//ID do último customer criado: cus_Dt8tmj8rlkprRF
		$customer = \Stripe\Customer::create([
		    'source' => $token,
		    'email' => 'paying.user@example.com',
		]);

		$charge = \Stripe\Charge::create([
		    'amount' => '6700',
		    'currency' => 'usd',
		    'description' => 'test',
		    'customer' => $customer->id,
		    //'source' => $token,
		]);

		dd($charge);

	}

	public function pagamentoStripeElements(Request $request){

		try{
			$charge = \Stripe\Charge::create([
			    'amount' => '2000',
			    'currency' => 'brl',
			    'source' => $request->stripeToken,
			    'description' => 'test',
		    	'email' => $request->email,
			    //'source' => $token,
			]);

			return back()->with('success_message', 'Obrigado! Seu pagamento foi efetuado com sucesso!');
		}
		catch(/*Exception*/\Stripe\Error\Card $e){
			return back()->withErrors('Erro! '.$e->getMessage());
		}
		//dd($request->all());

	}

	//ID do último pagamento: ch_1DRMybBdcsnyYyzeOxnb2Wzt
	public function refund(){

		$refund = \Stripe\Refund::create([
		    'charge' => 'ch_1DRMybBdcsnyYyzeOxnb2Wzt',
		    //amount é opcional. Nele podemos especificar uma quantidade em particular
		    //caso não seja passado todo o valor de cobrança é reembolsado.
		    'amount' => 6700,
		]);

		dd($refund);

	}

	//adiciona um novo cartão de crédito à um customer já existente
	public function saveCard(){
		dd($_POST);
		$customer = \Stripe\Customer::retrieve("cus_Dt8tmj8rlkprRF");
		$customer->sources->create(["source" => "src_18eYalAHEMiOZZp1l9ZTjSU0"]);

	}

	###################################################
	#### Usuários
	###################################################

	//cria um usuário de exemplo
	public function createUser(){

		$customer = \Stripe\Customer::create([
		    'email' => 'jenny.rosen@example.com',
		    'source' => 'src_18eYalAHEMiOZZp1l9ZTjSU0',
		]);

		dd($customer);

	}

	//retorna um usuário pelo ID passado
	public function searchUser(){

		$customer = \Stripe\Customer::retrieve("cus_Dt8tmj8rlkprRF");

		dd($customer);

	}

	###################################################
	#### Subscriptions
	###################################################

	//cria um produto para poder ter o tipo de plano associado
	//ID do último retorno: prod_DsmIEcbcFidF06
	public function createProduct(){

		$product = \Stripe\Product::create([
		    'name' => 'My SaaS Platform',
		    'type' => 'service',
		]);

		dd($product);

	}

	//cria um plano que será associado a um produto pela sua "ID"
	//ID do último plano: plan_DsmJptcRLTviS3
	public function createPlan(){

		$plan = \Stripe\Plan::create([
		  'product' => 'prod_DsmIEcbcFidF06',
		  'nickname' => 'SaaS Platform USD',
		  'interval' => 'month',
		  'currency' => 'usd',
		  'amount' => 10000,
		]);

		dd($plan);

	}

	//adiciona o customer à um plano
	public function createSubscription(){

		$subscription = \Stripe\Subscription::create([
		    'customer' => 'cus_Dt8tmj8rlkprRF',
		    'items' => [['plan' => 'plan_DsmJptcRLTviS3']],
		]);

		dd($subscription);

	}


	#################################################
	#### Notificações
	#################################################

	public function eventListener(){

		$input = @file_get_contents('php://input');
		//$event_json = json_decode($input);

		file_put_contents("webhook.log", $input/*, FILE_APPEND*/);

		http_response_code(200);

	}

}
