<?php

namespace App\Controllers;
use App\Models\DepartmentModel;

class Department extends BaseController
{
    private $departmentModel;
    private $departmentFields;
    //$data['employeeFields'] = $employeeFields; <- used for passing into a view
    
    public function __construct(){
        $this->departmentModel = new DepartmentModel();
        $this->departmentFields = $this->departmentModel->get_columnNames();
    }

    public function view($seg1 = false){
        $data['pageTitle'] = "View Departments";
        $departments = $this->departmentModel->get_department($seg1);
        $data['departments'] = $departments;

        echo view('templates/header.php', $data);
        echo view('department/view.php', $data);
        echo view('templates/footer.php');
    }

    public function create(){
        $data['pageTitle'] = "Create Department";
        $data['formFields'] = $this->departmentFields;

        echo view('templates/header.php', $data);

        if($this->request->getMethod() === 'post' && $this->validate([
            'Name' => 'required|min_length[3]|max_length[30]',
            'Description' => 'required|min_length[3]|max_length[50]'
           // 'departmentName' => 'required'
        ])){
            $this->departmentModel->save(
                [
                    'Name' => $this->request->getpost('Name'),
                    'Description' => $this->request->getpost('Description')
                    //'departmentName' => $this->request->getpost('departmentName')
                ]
            );
            $data['message'] = $this->request->getpost('Name') . ' was created successfully.';
            $data['callback_link'] = '/department/create';
            echo view('templates/success_message.php', $data);
            
            //echo ($this->request->getpost('firstName') . ' was created successfully.');
        }
        else{
            echo view('department/create.php');
        }
        
        echo view('templates/footer.php');
    }

    public function update($seg1 = false){
        $data['pageTitle'] = "Update Department";
        $data['formFields'] = $this->departmentFields;

        echo view('templates/header.php', $data);

        if(!$seg1) {
            //reject navigation to this page if an employee isn't selected
            $data['message'] = "An department must be selected.";
            $data['callback_link'] = "/department";
            echo view('templates/error_message.php', $data);
        }
        else{
            //if employee was selected, get it from db and send to update view
            if($this->request->getMethod() === 'post' && $this->validate([
                'Name' => 'required|min_length[3]|max_length[30]',
                'Description' => 'required|min_length[3]|max_length[50]'
                //'departmentName' => 'required'
            ])){
                $this->departmentModel->save(
                    [
                        //'id' => $this->request->getpost('id'),
                        'Name' => $this->request->getpost('Name'),
                        'Description' => $this->request->getpost('Description')
                        //'dob' => $this->request->getpost('dob'),
                        //'departmentName' => $this->request->getpost('departmentName')
                    ]
                );
                echo ("department was saved!");
            } else {
                $data['department'] = $this->departmentModel->get_department($seg1);
                echo view('department/update.php', $data);
            }
        }

        echo view('templates/footer.php');
    }

    public function delete($seg1 = false, $seg2 = false){
        $data['pageTitle'] = "Delete Department";

        echo view('templates/header.php', $data);
        if(!$seg1){
            $data['message'] = "Please select a valid department.";
            $data['callback_link'] = "/department";
            echo view('templates/error_message.php', $data);
        }
        else{
            $department = $this->departmentModel->get_department($seg1);
            if($seg2 == 1){
                $data['callback_link'] = "/department";
                if($this->departmentModel->delete($seg1)){
                    $data['message'] = "The department was successfully deleted.";
                    echo view('templates/success_message.php', $data);
                }
                else{
                    $data['message'] = "The department could not be deleted.";
                    echo view('templates/error_message.php', $data);
                }
            }
            else{
                $data['confirm'] = "Do you want to delete " . $department[0]->firstName;
                $data['confirm_link'] = "/department/delete/". $seg1 ."/1";
                echo view('department/delete.php', $data);
            }
            
        }
        echo view('templates/footer.php');
    }
}