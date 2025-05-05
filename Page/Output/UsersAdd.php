<?php
class UsersAdd extends System
{

    public function __construct()
    {
        return $this->GetView();
    }
    protected function GetView()
    {
        $html = '';
        $html .= 'UsersAdd page00';
        return $html;
    }
}
