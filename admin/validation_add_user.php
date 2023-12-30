<?php
class UserValidator
{
    private $data = [];
    private $errors = [];
    private static $fields = ['email', 'emp-id' ,'password', 'cpassword'];

    public function __construct($post_data)
    {
        $this->data = $post_data;
    }

    public function validateForm()
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                trigger_error("$field does not exist");
                return;
            }
        }
        $this->validateEmail();
        $this->validateEmpId();
        $this->validatePassword();
        $this->validateCpassword();
        return $this->errors;
    }


    private function validateEmail()
    {
        $val = trim($this->data['email']);
        if (empty($val)) {
            $this->addErrors('email', 'email cannot be empty');
        } else {
            if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
                $this->addErrors('email', 'email is not vaild');
            }
        }
    }

    private function validateEmpId(){
        $val = trim($this->data['emp-id']);
        if (empty($val)) {
            $this->addErrors('emp-id', 'employee id number cannot be empty');
        } else {
            if (!preg_match("/^[0-9]{7}+$/",$val)) {
                $this->addErrors('emp-id', 'employee id is not vaild');
            }
        }
    }

    private function validatePassword()
    { 
        $val = trim($this->data['password']);
        if (empty($val)) {
            $this->addErrors('password', 'password cannot be empty');
        }
        else if (strlen($val) < 8) {
            $this->addErrors('password', 'password must be at least 8 characters');
        }
        else if (!preg_match("/[a-z]/i", $val)) {
            $this->addErrors('password', 'password must  contain atleast one letter');
        }
        else if (!preg_match("/[0-9]/", $val)) {
            $this->addErrors('password', 'password must  contain atleast one number');
        }
    }

    private function validateCpassword(){
        if($this->data['password']!==$this->data['cpassword']){
            $this->addErrors('cpassword','passwords must match');
        }
    }

    private function addErrors($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
