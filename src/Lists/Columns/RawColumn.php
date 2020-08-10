<?php


namespace zedsh\zadmin\Lists\Columns;



class RawColumn extends BaseColumn
{
    protected $content;
    protected $closure;

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setClosure($closure)
    {
        $this->closure = $closure;
        return $this;
    }

    public function render()
    {
        if(!empty($this->closure)){
            $closure = $this->closure;
            return $closure($this->model);
        }else{
            return $this->content;
        }
    }

}
