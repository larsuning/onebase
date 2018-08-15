<?php
namespace {$space};

class {$class} extends {$modules}Base
{

    public function index()
    {
        return $this->apiReturn($this->logic{$name}->{$names}Action($this->param));
    }

}
