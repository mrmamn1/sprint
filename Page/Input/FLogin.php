<?php
class FLogin extends System
{

    public function __construct()
    {
        return $this->GetView();
    }
    protected function GetView()
    {
        if (System::SuperArrayGet('login_submit', 'post')) {

            $Query_LogInUserInfo = SQLCommands::LogInUserInfo();
            $Acc = Database::select($Query_LogInUserInfo['query'], $Query_LogInUserInfo['params']);


            if (isset($Acc[0]) && password_verify(System::SuperArrayGet('user_password'), $Acc[0]['user_password'])) {
                // System::Print($Acc);
                System::SuperArraySet('Acc', $Acc[0], 's');
                System::ReDir('?p=index');
            } else {
                // خطا تسجيل في تسجيل الدخول

                $form = $this->BuildView();
                // اضافة الاخطأ
                $form['input']['user_email']['error'] = 'يرجى التحقق من المدخلات';
                $form['input']['user_password']['error'] = 'يرجى التحقق من المدخلات';
                return System::FormCreate($form);
            }
        } else {
            // عرض النموذج الابتدائي
            $form = $this->BuildView();
            return System::FormCreate($form);
        }
    }
    protected function BuildView()
    {

        $form['title'] = 'تسجيل الدخول';
        $form['id'] = 'login';
        $form['class'] = 'login';
        $form['name'] = 'login';
        $form['action'] = '';
        $form['method'] = 'post';
        $form['enctype'] = 'multipart/form-data';
        $form['target'] = '_self';
        $form['autocomplete'] = 'off';

        $form['input']['user_email']['type'] = 'email';
        $form['input']['user_email']['name'] = 'user_email';
        $form['input']['user_email']['title'] = 'ايميل المستخدم';
        $form['input']['user_email']['id'] = 'user_email';
        $form['input']['user_email']['class'] = 'user_email';
        $form['input']['user_email']['style'] = '';
        $form['input']['user_email']['value'] = '';
        $form['input']['user_email']['placeholder'] = 'ايميل المستخدم';


        $form['input']['user_password']['type'] = 'password';
        $form['input']['user_password']['name'] = 'user_password';
        $form['input']['user_password']['title'] = ' كلمة السر';
        $form['input']['user_password']['id'] = 'user_password';
        $form['input']['user_password']['class'] = 'user_password';
        $form['input']['user_password']['style'] = '';
        $form['input']['user_password']['value'] = '';
        $form['input']['user_password']['placeholder'] = '';


        $form['input']['login_submit']['type'] = 'submit';
        $form['input']['login_submit']['name'] = 'login_submit';
        $form['input']['login_submit']['title'] = 'تسجيل الدخول';
        $form['input']['login_submit']['id'] = 'login_submit';
        $form['input']['login_submit']['class'] = 'login_submit';
        $form['input']['login_submit']['style'] = '';
        $form['input']['login_submit']['value'] = 'تسجيل الدخول';

        return $form;
    }
}
