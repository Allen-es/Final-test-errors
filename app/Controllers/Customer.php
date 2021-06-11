<?php

namespace App\Controllers;
use App\Models\CustomerModel;

class Customer extends BaseController
{
    private $customerModel;
    private $customerFields;
    //$data['employeeFields'] = $employeeFields; <- used for passing into a view
    
    public function __construct(){
        $this->customerModel = new CustomerModel();
        $this->customerFields = $this->customerModel->get_columnNames();
    }

    public function view($seg1 = false){
        $data['pageTitle'] = "View Customers";
        $customers = $this->customerModel->get_customer($seg1);
        $data['customers'] = $customers;

        echo view('templates/header.php', $data);
        echo view('customer/view.php', $data);
        echo view('templates/footer.php');
    }

    public function create(){
        $data['pageTitle'] = "Create Customer";
        $data['formFields'] = $this->customerFields;

        echo view('templates/header.php', $data);

        if($this->request->getMethod() === 'post' && $this->validate([
            'firstName' => 'required|min_length[3]|max_length[30]',
            'lastName' => 'required|min_length[3]|max_length[30]',
            'departmentName' => 'required'
        ])){
            $this->customerModel->save(
                [
                    'firstName' => $this->request->getPost('firstName'),
                    'lastName' => $this->request->getPost('lastName'),
                    'departmentName' => $this->request->getPost('departmentName')
                ]
            );
            $data['message'] = $this->request->getPost('firstName') . ' was created successfully.';
            $data['callback_link'] = '/customer/create';
            echo view('templates/success_message.php', $data);
            
            //echo ($this->request->getPost('firstName') . ' was created successfully.');
        }
        else{
            echo view('customer/create.php');
        }
        
        echo view('templates/footer.php');
    }

    public function update($seg1 = false){
        $data['pageTitle'] = "Update Customer";
        $data['formFields'] = $this->customerFields;

        echo view('templates/header.php', $data);

        if(!$seg1) {
            //reject navigation to this page if an employee isn't selected
            $data['message'] = "An customer must be selected.";
            $data['callback_link'] = "/customer";
            echo view('templates/error_message.php', $data);
        }
        else{
            //if employee was selected, get it from db and send to update view
            if($this->request->getMethod() === 'post' && $this->validate([
                'firstName' => 'required|min_length[3]|max_length[30]',
                'lastName' => 'required|min_length[3]|max_length[30]',
                'departmentName' => 'required'
            ])){
                $this->customerModel->save(
                    [
                        'id' => $this->request->getPost('id'),
                        'firstName' => $this->request->getPost('firstName'),
                        'lastName' => $this->request->getPost('lastName'),
                        'dob' => $this->request->getPost('dob'),
                        'departmentName' => $this->request->getPost('departmentName')
                    ]
                );
                echo ("Customer was saved!");
            } else {
                $data['customer'] = $this->customerModel->get_customer($seg1);
                echo view('customer/update.php', $data);
            }
        }

        echo view('templates/footer.php');
    }

    public function delete($seg1 = false, $seg2 = false){
        $data['pageTitle'] = "Delete Customer";

        echo view('templates/header.php', $data);
        if(!$seg1){
            $data['message'] = "Please select a valid customer.";
            $data['callback_link'] = "/customer";
            echo view('templates/error_message.php', $data);
        }
        else{
            $customer = $this->customerModel->get_customer($seg1);
            if($seg2 == 1){
                $data['callback_link'] = "/customer";
                if($this->customerModel->delete($seg1)){
                    $data['message'] = "The customer was successfully deleted.";
                    echo view('templates/success_message.php', $data);
                }
                else{
                    $data['message'] = "The customer could not be deleted.";
                    echo view('templates/error_message.php', $data);
                }
            }
            else{
                $data['confirm'] = "Do you want to delete " . $customer[0]->firstName;
                $data['confirm_link'] = "/customer/delete/". $seg1 ."/1";
                echo view('customer/delete.php', $data);
            }
            
        }
        echo view('templates/footer.php');
    }
}