<?php

namespace App\Controllers;
use App\Models\EmployeeModel;

class Employee extends BaseController
{
    private $employeeModel;
    private $employeeFields;
    //$data['employeeFields'] = $employeeFields; <- used for passing into a view
    
    public function __construct(){
        $this->employeeModel = new EmployeeModel();
        $this->employeeFields = $this->employeeModel->get_columnNames();
    }

    public function view($seg1 = false){
        $data['pageTitle'] = "View Employees";
        $employees = $this->employeeModel->get_employee($seg1);
        $data['employees'] = $employees;

        echo view('templates/header.php', $data);
        echo view('employee/view.php', $data);
        echo view('templates/footer.php');
    }

    public function create(){
        $data['pageTitle'] = "Create Employee";
        $data['formFields'] = $this->employeeFields;

        echo view('templates/header.php', $data);

        if($this->request->getMethod() === 'post' && $this->validate([
            'firstName' => 'required|min_length[3]|max_length[30]',
            'lastName' => 'required|min_length[3]|max_length[30]',
            'departmentName' => 'required'
        ])){
            $this->employeeModel->save(
                [
                    'firstName' => $this->request->getPost('firstName'),
                    'lastName' => $this->request->getPost('lastName'),
                    'departmentName' => $this->request->getPost('departmentName')
                ]
            );
            $data['message'] = $this->request->getPost('firstName') . ' was created successfully.';
            $data['callback_link'] = '/employee/create';
            echo view('templates/success_message.php', $data);
            
            //echo ($this->request->getPost('firstName') . ' was created successfully.');
        }
        else{
            echo view('employee/create.php');
        }
        
        echo view('templates/footer.php');
    }

    public function update($seg1 = false){
        $data['pageTitle'] = "Update Employee";
        $data['formFields'] = $this->employeeFields;

        echo view('templates/header.php', $data);

        if(!$seg1) {
            //reject navigation to this page if an employee isn't selected
            $data['message'] = "An employee must be selected.";
            $data['callback_link'] = "/employee";
            echo view('templates/error_message.php', $data);
        }
        else{
            //if employee was selected, get it from db and send to update view
            if($this->request->getMethod() === 'post' && $this->validate([
                'firstName' => 'required|min_length[3]|max_length[30]',
                'lastName' => 'required|min_length[3]|max_length[30]',
                'departmentName' => 'required'
            ])){
                $this->employeeModel->save(
                    [
                        'id' => $this->request->getPost('id'),
                        'firstName' => $this->request->getPost('firstName'),
                        'lastName' => $this->request->getPost('lastName'),
                        'dob' => $this->request->getPost('dob'),
                        'departmentName' => $this->request->getPost('departmentName')
                    ]
                );
                echo ("Employee was saved!");
            } else {
                $data['employee'] = $this->employeeModel->get_employee($seg1);
                echo view('employee/update.php', $data);
            }
        }

        echo view('templates/footer.php');
    }

    public function delete($seg1 = false, $seg2 = false){
        $data['pageTitle'] = "Delete Employee";

        echo view('templates/header.php', $data);
        if(!$seg1){
            $data['message'] = "Please select a valid employee.";
            $data['callback_link'] = "/employee";
            echo view('templates/error_message.php', $data);
        }
        else{
            $employee = $this->employeeModel->get_employee($seg1);
            if($seg2 == 1){
                $data['callback_link'] = "/employee";
                if($this->employeeModel->delete($seg1)){
                    $data['message'] = "The employee was successfully deleted.";
                    echo view('templates/success_message.php', $data);
                }
                else{
                    $data['message'] = "The employee could not be deleted.";
                    echo view('templates/error_message.php', $data);
                }
            }
            else{
                $data['confirm'] = "Do you want to delete " . $employee[0]->firstName;
                $data['confirm_link'] = "/employee/delete/". $seg1 ."/1";
                echo view('employee/delete.php', $data);
            }
            
        }
        echo view('templates/footer.php');
    }
}