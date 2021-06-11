<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data['pageTitle'] = "Welcome to our Company Website!";

		echo view('templates/header', $data);
		echo view('home');
		echo view('templates/footer');
	}

/* 	Approach to handling pages with parameters
public function create($page = false){
		//predefined params: employee, department
		if($page == false){
			$page = "Default Page";
		}

		$data['pageTitle'] = $page;

		echo view('templates/header');
		if($page == 'employee'){
			echo view('employee/create.php');
		}

		else if($page == 'department'){
			echo view('department/create.php');
		}
		else{
			echo view("welcome_message");
		}
		echo view('templates/footer');
	}

	public function update($page){
		//predefined params: employee, department
		echo view('templates/header');
		if($page == 'employee'){
			echo view('employee/create.php');
		}

		else if($page == 'department'){
			echo view('department/create.php');
		}
		echo view('templates/footer');
	}

	public function delete($page){
		//predefined params: employee, department
		echo view('templates/header');
		if($page == 'employee'){
			echo view('employee/create.php');
		}

		else if($page == 'department'){
			echo view('department/create.php');
		}
		echo view('templates/footer');
	}

	public function view($page){
		//predefined params: employee, department
		echo view('templates/header');
		if($page == 'employee'){
			echo view('employee/create.php');
		}

		else if($page == 'department'){
			echo view('department/create.php');
		}
		echo view('templates/footer');
	} */
}
