<?php
class About extends System
{

    public function __construct()
    {
        return $this->GetView();
    }
    protected function GetView()
    {
        $html = '';
        $html .= 'About';
        return $html;
    }
}
