<?php
class Login extends System
{

    public function __construct()
    {
        return $this->GetView();
    }
    protected function GetView()
    {
        $html = '';
        $html .=  System::GetPage('Input', 'FLogin');
        return $html;
    }
}
