<?php
class Error404 extends System
{

    public function __construct()
    {
        return $this->GetView();
    }
    protected function GetView()
    {
        $html = '';
        $html .= 'Error 404';
        return $html;
    }
}
