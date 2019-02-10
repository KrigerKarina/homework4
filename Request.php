<?php
class Request
{
    protected $errors = [];
    protected $cleanPostParams = [];

    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === "GET";
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === "POST";
    }

    public function required($name)
    {
        if(empty($this->getFromPostWithClean($name))) 
        {
            $this->errors[$name][] = 'Обязательное поле';
        }
        return $this;
    }

    public function max($name, $max)
    {
        if(mb_strlen($this->getFromPostWithClean($name)) > $max) 
        {
            $this->errors[$name][] = 'Максимальное количество символов - ' . $max;
        }
        return $this;
    }

    public function min($name, $min)
    {
        if(mb_strlen($this->getFromPostWithClean($name)) < $min) 
        {
            $this->errors[$name][] = 'Минимальное количество символов - ' . $min;
        }
        return $this;
    }

    public function isValid()
    {
        return !count($this->errors);
    }
    public function getErrors()
    {
        return $this->errors;
    }
  
    public function getFromPostWithClean($name)
    {
        if(isset($this->cleanPostParams[$name]) && $this->cleanPostParams[$name]) 
        {
            return $this->cleanPostParams[$name];
        }
        else {
            $value = $_POST[$name];
            $value = trim($value);
            $value = htmlspecialchars($value);
            $this->cleanPostParams[$name] = $value;
            return $value;
        }
    }

    public function checkEmail($name)
    {
        $name = '';
        if (filter_var($name, FILTER_VALIDATE_EMAIL) !== false)
        { 
            return $name;
        }
    }

     public function isInt($name)
    {
        if(!is_numeric($this->getFromPostWithClean($name)) || $this->getFromPostWithClean($name)<0)    
        {
            $this->errors[$name][] = 'Количество просмотров может быть только положительным числом';
        }
        return $this;
    }

    public function validateDate($name)
    {
        if(strtotime($this->getFromPostWithClean($name)) < mktime())   
        {
            $this->errors[$name][] = 'Публикация не может быть раньше текущей даты';
        }
        return $this;
    }

 public function checkIndexPublish($name)
    {
        if(!$this->getFromPostWithClean($name)) {
            $this->errors[$name][] = 'Обязательное поле';
        }
        return $this;
    }

  public function checkCategory($name, $var1, $var2, $var3)
    {
        if ($this->getFromPostWithClean($name)!=$var1 && $this->getFromPostWithClean($name)!=$var2 &&
            $this->getFromPostWithClean($name)!=$var3){
            $this->errors[$name][] = 'Необходимо выбрать категорию';
        }
        return $this;
    }
}

  
