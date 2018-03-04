<?php
class A {
    public function call()
    {
        return 'from class A';
    }
}
class Name 
{
    protected $name;
    static  function __callStatic($name, $arguments)
    {
        //var_dump($name);
        return (new static)->get(...$arguments);
    }

    public  function set(...$arguments)
    {
        //var_dump($arguments);
        $this->name = $arguments[0];
        return $this;
    }
    public function get(A $a)
    {
        return $a->call();
        return $this->name; 
    }
    public function __toString()
    {
        return 'My name is QT';
    }
}

$my = Name::sett();
echo $my;