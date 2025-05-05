<?php
class Logout extends System
{

    public function __construct()
    {
        return $this->GetView();
    }
    protected function GetView()
    {
        session_destroy();
        System::ReDir('?p=index');
    }
}
