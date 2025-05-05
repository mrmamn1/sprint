<?php
class Register extends System
{

    public function __construct()
    {
        return $this->GetView();
    }
    protected function GetView()
    {
        $html = '';
        $html .=  System::GetPage('Input', 'FRegister');
        return $html;
    }
}
