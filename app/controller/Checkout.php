<?php

use Core\BaseController\BaseController;

class Checkout extends BaseController
{

    public function __construct()
    {

        $this->productModel = $this->model('Product');
    }
    public function index()
    {

        $data = [];

        if (!empty($_POST['productId'])) {
            $productId = $_POST['productId'];

            $productData = $this->productModel->getCurrentProduct($productId);
            $data = ['productData' => $productData];
        }

        $this->view('Checkout', $data);
    }

    public function productOrder()
    {
        try {
            $getRequest = file_get_contents('php://input');
            $getData = json_decode($getRequest);

            $placeOrder = $this->productModel->placeOrder($getData);
            if ($placeOrder == true) {
                $output = [
                    'status' => 'success',
                ];
            } else {
                $output = [
                    'status' => 'failed',
                ];
            }
            json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    public function checkoutSuccess()
    {
        $data = [];
        if (isset($_GET['redirect_status'])) {
            $paymentStatus = $_GET['redirect_status'];
            if ($_GET['redirect_status'] == 'succeeded') {
                // ProductOrder::UpdateOrderStatus(1, $_GET['payment_intent_client_secret']);
                $data['status'] = $_GET['redirect_status'];
            }
        }
        $this->view("CheckoutSuccess", $data);
    }
}