<?php
class UserValidator
{
    private $data = [];
    private $errors = [];
    private static $fields = ['name'];

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
        $this->validateName();
        return $this->errors;
    }

    private function validateName()
    {
        $val = $_POST['name'];
        if (empty($val)) {
            $this->addErrors('name', 'name is required');
        }else{
            if (ctype_alpha(str_replace(' ', '', $val)) === false) {
                $this->addErrors('name','name must contain only alphabets');
              }              
        }
    }
    private function addErrors($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
