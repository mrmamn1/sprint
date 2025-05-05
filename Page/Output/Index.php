<?php
class Index extends System
{

    public function __construct()
    {
        return $this->GetView();
    }
    protected function GetView()
    {
        $Acc = System::SuperArrayGet('Acc', 's');
        $AccID = $Acc['user_id'];
        $AccName = $Acc['user_name'];
        $AccEmail = $Acc['user_email'];
        $html = '';
        $html .= 'Index page';
        $html .= "{$AccName}{$AccID}{$AccEmail}";

        return $html;
    }
}
