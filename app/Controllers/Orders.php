<?php

namespace App\Controllers;
use App\Models\OrdersModel;

class Orders extends BaseController
{
    private $ordersModel;
    private $ordersFields;
    //$data['orderFields'] = $orderFields; <- used for passing into a view
    
    public function __construct(){
        $this->ordersModel = new OrdersModel();
        $this->ordersFields = $this->ordersModel->get_columnNames();
    }

    public function view($seg1 = false){
        $data['pageTitle'] = "View Orders";
        $orderss = $this->ordersModel->get_orders($seg1);
        $data['orderss'] = $orderss;

        echo view('templates/header.php', $data);
        echo view('orders/view.php', $data);
        echo view('templates/footer.php');
    }

    public function create(){
        $data['pageTitle'] = "Create Order";
        $data['formFields'] = $this->ordersFields;

        echo view('templates/header.php', $data);

        if($this->request->getMethod() === 'post' && $this->validate([
            'firstName' => 'required|min_length[3]|max_length[30]',
            'lastName' => 'required|min_length[3]|max_length[30]',
            'departmentName' => 'required'
        ])){
            $this->ordersModel->save(
                [
                    'firstName' => $this->request->getPost('firstName'),
                    'lastName' => $this->request->getPost('lastName'),
                    'departmentName' => $this->request->getPost('departmentName')
                ]
            );
            $data['message'] = $this->request->getPost('firstName') . ' was created successfully.';
            $data['callback_link'] = '/orders/create';
            echo view('templates/success_message.php', $data);
            
            //echo ($this->request->getPost('firstName') . ' was created successfully.');
        }
        else{
            echo view('orders/create.php');
        }
        
        echo view('templates/footer.php');
    }

    public function update($seg1 = false){
        $data['pageTitle'] = "Update Orders";
        $data['formFields'] = $this->ordersFields;

        echo view('templates/header.php', $data);

        if(!$seg1) {
            //reject navigation to this page if an employee isn't selected
            $data['message'] = "An order must be selected.";
            $data['callback_link'] = "/orders";
            echo view('templates/error_message.php', $data);
        }
        else{
            //if employee was selected, get it from db and send to update view
            if($this->request->getMethod() === 'post' && $this->validate([
                'firstName' => 'required|min_length[3]|max_length[30]',
                'lastName' => 'required|min_length[3]|max_length[30]',
                'departmentName' => 'required'
            ])){
                $this->ordersModel->save(
                    [
                        'id' => $this->request->getPost('id'),
                        'firstName' => $this->request->getPost('firstName'),
                        'lastName' => $this->request->getPost('lastName'),
                        'dob' => $this->request->getPost('dob'),
                        'departmentName' => $this->request->getPost('departmentName')
                    ]
                );
                echo ("Order was saved!");
            } else {
                $data['orders'] = $this->ordersModel->get_order($seg1);
                echo view('orders/update.php', $data);
            }
        }

        echo view('templates/footer.php');
    }

    public function delete($seg1 = false, $seg2 = false){
        $data['pageTitle'] = "Delete orders";

        echo view('templates/header.php', $data);
        if(!$seg1){
            $data['message'] = "Please select a valid order.";
            $data['callback_link'] = "/orders";
            echo view('templates/error_message.php', $data);
        }
        else{
            $order = $this->ordersModel->get_orders($seg1);
            if($seg2 == 1){
                $data['callback_link'] = "/orders";
                if($this->ordersModel->delete($seg1)){
                    $data['message'] = "The order was successfully deleted.";
                    echo view('templates/success_message.php', $data);
                }
                else{
                    $data['message'] = "The order could not be deleted.";
                    echo view('templates/error_message.php', $data);
                }
            }
            else{
                $data['confirm'] = "Do you want to delete " . $order[0]->firstName;
                $data['confirm_link'] = "/orders/delete/". $seg1 ."/1";
                echo view('orders/delete.php', $data);
            }
            
        }
        echo view('templates/footer.php');
    }
}