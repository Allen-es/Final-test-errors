<?php

namespace App\Controllers;
use App\Models\AddressModel;

class Address extends BaseController
{
    private $addressModel;
    private $addressFields;
    //$data['employeeFields'] = $employeeFields; <- used for passing into a view
    
    public function __construct(){
        $this->addressModel = new AddressModel();
        $this->addressFields = $this->addressModel->get_columnNames();
    }

    public function view($seg1 = false){
        $data['pageTitle'] = "View Addresses";
        $addresses = $this->addressModel->get_address($seg1);
        $data['addresses'] = $addresses;

        echo view('templates/header.php', $data);
        echo view('address/view.php', $data);
        echo view('templates/footer.php');
    }

    public function create(){
        $data['pageTitle'] = "Create Address";
        $data['formFields'] = $this->addressFields;

        echo view('templates/header.php', $data);

        if($this->request->getMethod() === 'post' && $this->validate([
            'firstName' => 'required|min_length[3]|max_length[30]',
            'lastName' => 'required|min_length[3]|max_length[30]',
            'departmentName' => 'required'
        ])){
            $this->addressModel->save(
                [
                    'firstName' => $this->request->getPost('firstName'),
                    'lastName' => $this->request->getPost('lastName'),
                    'departmentName' => $this->request->getPost('departmentName')
                ]
            );
            $data['message'] = $this->request->getPost('firstName') . ' was created successfully.';
            $data['callback_link'] = '/address/create';
            echo view('templates/success_message.php', $data);
            
            //echo ($this->request->getPost('firstName') . ' was created successfully.');
        }
        else{
            echo view('address/create.php');
        }
        
        echo view('templates/footer.php');
    }

    public function update($seg1 = false){
        $data['pageTitle'] = "Update Address";
        $data['formFields'] = $this->addressFields;

        echo view('templates/header.php', $data);

        if(!$seg1) {
            //reject navigation to this page if an employee isn't selected
            $data['message'] = "An address must be selected.";
            $data['callback_link'] = "/address";
            echo view('templates/error_message.php', $data);
        }
        else{
            //if employee was selected, get it from db and send to update view
            if($this->request->getMethod() === 'post' && $this->validate([
                'firstName' => 'required|min_length[3]|max_length[30]',
                'lastName' => 'required|min_length[3]|max_length[30]',
                'departmentName' => 'required'
            ])){
                $this->addressModel->save(
                    [
                        'id' => $this->request->getPost('id'),
                        'firstName' => $this->request->getPost('firstName'),
                        'lastName' => $this->request->getPost('lastName'),
                        'dob' => $this->request->getPost('dob'),
                        'departmentName' => $this->request->getPost('departmentName')
                    ]
                );
                echo ("Address was saved!");
            } else {
                $data['address'] = $this->addressModel->get_address($seg1);
                echo view('address/update.php', $data);
            }
        }

        echo view('templates/footer.php');
    }

    public function delete($seg1 = false, $seg2 = false){
        $data['pageTitle'] = "Delete Address";

        echo view('templates/header.php', $data);
        if(!$seg1){
            $data['message'] = "Please select a valid address.";
            $data['callback_link'] = "/address";
            echo view('templates/error_message.php', $data);
        }
        else{
            $address = $this->addressModel->get_address($seg1);
            if($seg2 == 1){
                $data['callback_link'] = "/address";
                if($this->addressModel->delete($seg1)){
                    $data['message'] = "The address was successfully deleted.";
                    echo view('templates/success_message.php', $data);
                }
                else{
                    $data['message'] = "The address could not be deleted.";
                    echo view('templates/error_message.php', $data);
                }
            }
            else{
                $data['confirm'] = "Do you want to delete " . $address[0]->firstName;
                $data['confirm_link'] = "/address/delete/". $seg1 ."/1";
                echo view('address/delete.php', $data);
            }
            
        }
        echo view('templates/footer.php');
    }
}