<?php
class FRegister extends System
{
    public function __construct()
    {
        return $this->GetView();
    }

    protected function GetView()
    {
        if (System::SuperArrayGet('register_submit', 'post')) {
            // التحقق من البيانات المدخلة
            $errors = $this->ValidateInput();

            if (empty($errors)) {
                // تسجيل المستخدم الجديد
                $result = $this->RegisterUser();

                if ($result) {
                    System::ReDir('?p=login&registered=1');
                } else {
                    $form = $this->BuildView();
                    $form['input']['user_name']['error'] = 'حدث خطأ أثناء التسجيل';
                    return System::FormCreate($form);
                }
            } else {
                // عرض الأخطاء
                $form = $this->BuildView();
                foreach ($errors as $field => $error) {
                    $form['input'][$field]['error'] = $error;
                }
                return System::FormCreate($form);
            }
        } else {
            // عرض النموذج الابتدائي
            $form = $this->BuildView();
            return System::FormCreate($form);
        }
    }

    protected function ValidateInput()
    {
        $errors = [];

        // التحقق من اسم المستخدم
        if (empty(System::SuperArrayGet('user_name', 'post'))) {
            $errors['user_name'] = 'اسم المستخدم مطلوب';
        } elseif (strlen(System::SuperArrayGet('user_name', 'post')) < 3) {
            $errors['user_name'] = 'اسم المستخدم يجب أن يكون 3 أحرف على الأقل';
        }

        // التحقق من كلمة المرور
        if (empty(System::SuperArrayGet('user_password', 'post'))) {
            $errors['user_password'] = 'كلمة المرور مطلوبة';
        } elseif (strlen(System::SuperArrayGet('user_password', 'post')) < 6) {
            $errors['user_password'] = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
        }

        // التحقق من تأكيد كلمة المرور
        if (System::SuperArrayGet('user_password', 'post') !== System::SuperArrayGet('user_password_confirm', 'post')) {
            $errors['user_password_confirm'] = 'كلمتا المرور غير متطابقتين';
        }

        // التحقق من البريد الإلكتروني
        if (empty(System::SuperArrayGet('user_email', 'post'))) {
            $errors['user_email'] = 'البريد الإلكتروني مطلوب';
        } elseif (!filter_var(System::SuperArrayGet('user_email', 'post'), FILTER_VALIDATE_EMAIL)) {
            $errors['user_email'] = 'البريد الإلكتروني غير صالح';
        }

        // التحقق من رقم الجوال
        if (empty(System::SuperArrayGet('user_mobile', 'post'))) {
            $errors['user_mobile'] = 'رقم الجوال مطلوب';
        }

        // التحقق من الموافقة على الشروط
        if (empty(System::SuperArrayGet('accept_terms', 'post'))) {
            $errors['accept_terms'] = 'يجب الموافقة على الشروط والأحكام';
        }

        return $errors;
    }

    protected function RegisterUser()
    {
        $user_name = System::SuperArrayGet('user_name', 'post');
        $user_password = password_hash(System::SuperArrayGet('user_password', 'post'), PASSWORD_DEFAULT);
        $user_email = System::SuperArrayGet('user_email', 'post');
        $user_mobile = System::SuperArrayGet('user_mobile', 'post');
        $user_reg_date = date('Y-m-d H:i:s');
        $user_type_id = 2; // القيمة الافتراضية لنوع المستخدم (عادي)
        $user_active_code = md5(uniqid(rand(), true));
        $user_status = 'new';
        $user_ip = $_SERVER['REMOTE_ADDR'];

        $query = "INSERT INTO users (
            user_name, 
            user_password, 
            user_email, 
            user_mobile, 
            user_reg_date, 
            user_type_id, 
            user_active_code, 
            user_status, 
            user_ip
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $user_name,
            $user_password,
            $user_email,
            $user_mobile,
            $user_reg_date,
            $user_type_id,
            $user_active_code,
            $user_status,
            $user_ip
        ];

        return Database::execute($query, $params);
    }

    protected function BuildView()
    {
        $form['title'] = 'تسجيل مستخدم جديد';
        $form['id'] = 'register';
        $form['class'] = 'register';
        $form['name'] = 'register';
        $form['action'] = '';
        $form['method'] = 'post';
        $form['enctype'] = 'multipart/form-data';
        $form['target'] = '_self';
        $form['autocomplete'] = 'off';

        // حقل اسم المستخدم
        $form['input']['user_name']['type'] = 'text';
        $form['input']['user_name']['name'] = 'user_name';
        $form['input']['user_name']['title'] = 'اسم المستخدم';
        $form['input']['user_name']['id'] = 'user_name';
        $form['input']['user_name']['class'] = 'user_name';
        $form['input']['user_name']['style'] = '';
        $form['input']['user_name']['value'] = System::SuperArrayGet('user_name', 'post', '');
        $form['input']['user_name']['placeholder'] = 'اسم المستخدم';
        $form['input']['user_name']['required'] = true;

        // حقل البريد الإلكتروني
        $form['input']['user_email']['type'] = 'email';
        $form['input']['user_email']['name'] = 'user_email';
        $form['input']['user_email']['title'] = 'البريد الإلكتروني';
        $form['input']['user_email']['id'] = 'user_email';
        $form['input']['user_email']['class'] = 'user_email';
        $form['input']['user_email']['style'] = '';
        $form['input']['user_email']['value'] = System::SuperArrayGet('user_email', 'post', '');
        $form['input']['user_email']['placeholder'] = 'البريد الإلكتروني';
        $form['input']['user_email']['required'] = true;

        // حقل كلمة المرور
        $form['input']['user_password']['type'] = 'password';
        $form['input']['user_password']['name'] = 'user_password';
        $form['input']['user_password']['title'] = 'كلمة المرور';
        $form['input']['user_password']['id'] = 'user_password';
        $form['input']['user_password']['class'] = 'user_password';
        $form['input']['user_password']['style'] = '';
        $form['input']['user_password']['value'] = '';
        $form['input']['user_password']['placeholder'] = 'كلمة المرور';
        $form['input']['user_password']['required'] = true;

        // حقل تأكيد كلمة المرور
        $form['input']['user_password_confirm']['type'] = 'password';
        $form['input']['user_password_confirm']['name'] = 'user_password_confirm';
        $form['input']['user_password_confirm']['title'] = 'تأكيد كلمة المرور';
        $form['input']['user_password_confirm']['id'] = 'user_password_confirm';
        $form['input']['user_password_confirm']['class'] = 'user_password_confirm';
        $form['input']['user_password_confirm']['style'] = '';
        $form['input']['user_password_confirm']['value'] = '';
        $form['input']['user_password_confirm']['placeholder'] = 'تأكيد كلمة المرور';
        $form['input']['user_password_confirm']['required'] = true;

        // حقل رقم الجوال
        $form['input']['user_mobile']['type'] = 'tel';
        $form['input']['user_mobile']['name'] = 'user_mobile';
        $form['input']['user_mobile']['title'] = 'رقم الجوال';
        $form['input']['user_mobile']['id'] = 'user_mobile';
        $form['input']['user_mobile']['class'] = 'user_mobile';
        $form['input']['user_mobile']['style'] = '';
        $form['input']['user_mobile']['value'] = System::SuperArrayGet('user_mobile', 'post', '');
        $form['input']['user_mobile']['placeholder'] = 'رقم الجوال';
        $form['input']['user_mobile']['required'] = true;

        // حقل الموافقة على الشروط
        $form['input']['accept_terms']['type'] = 'checkbox';
        $form['input']['accept_terms']['name'] = 'accept_terms';
        $form['input']['accept_terms']['title'] = 'أوافق على <a href="?p=terms" target="_blank">الشروط والأحكام</a>';
        $form['input']['accept_terms']['id'] = 'accept_terms';
        $form['input']['accept_terms']['class'] = 'accept_terms';
        $form['input']['accept_terms']['style'] = '';
        $form['input']['accept_terms']['value'] = '1';
        $form['input']['accept_terms']['required'] = true;

        // زر التسجيل
        $form['input']['register_submit']['type'] = 'submit';
        $form['input']['register_submit']['name'] = 'register_submit';
        $form['input']['register_submit']['title'] = 'تسجيل حساب جديد';
        $form['input']['register_submit']['id'] = 'register_submit';
        $form['input']['register_submit']['class'] = 'register_submit';
        $form['input']['register_submit']['style'] = '';
        $form['input']['register_submit']['value'] = 'تسجيل حساب جديد';

        return $form;
    }
}
