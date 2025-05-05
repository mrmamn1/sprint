<?php
class System
{

    public static function Print($any = '', $type = true, $exit = true)
    {
        echo '<div class="System-print">';
        echo '<pre>';
        if ($type == true) {
            var_dump($any);
        } else {
            print_r($any);
        }
        $backtrace = debug_backtrace();
        $caller = $backtrace[0];
        echo '</pre>';
        echo '<span>  ';
        echo '<span class="bold"> file: </span> ';
        echo '<span class="red">' . $caller['file'] . '</span>';
        echo '<span class="bold"> line: </span>';
        echo '<span class="red">' . $caller['line'] . '</span>';
        echo "</span> \n";
        echo '</div>';

        if ($exit == true) {
            exit;
        }
    }

    public static function ReDir($dir)
    {
        header('location:' . $dir);
    }


    public static function SuperArraySet($key, $val, $type = 'post', $time = 0)
    {
        switch ($type) {
            case 'k':
                setcookie($key, $val, time() + $time);
                break;
            case 'r':
                $_REQUEST[$key] = $val;
                break;
            case 's':
                $_SESSION[$key] = $val;
                break;
            case 'g':
                $GLOBALS[$key] = $val;
                break;
            case 'get':
                $_GET[$key] = $val;
                break;
            case 'post':
            default:
                $_POST[$key] = $val;
                break;
        }
    }

    public static function SuperArrayGet($key, $type = 'post')
    {
        switch ($type) {
            case 'k':
                return (isset($_COOKIE[$key])) ? $_COOKIE[$key] : '';
                break;
            case 'r':
                return (isset($_REQUEST[$key])) ? $_REQUEST[$key] : '';
                break;
            case 's':
                return (isset($_SESSION[$key])) ? $_SESSION[$key] : '';
                break;
            case 'g':
                return (isset($GLOBALS[$key])) ? $GLOBALS[$key] : '';
                break;
            case 'get':
                return (isset($_GET[$key])) ? $_GET[$key] : '';
                break;
            case 'post':
            default:
                return (isset($_POST[$key])) ? $_POST[$key] : '';
                break;
        }
    }

    public static function convertToCamelCase($string)
    {
        // استبدال جميع الفواصل غير المرغوب فيها بعلامة /
        $string = str_replace(['_', '-', ' '], '/', $string);

        // تقسيم النص
        $parts = explode('/', $string);
        $parts = array_filter($parts);

        $camelCase = '';
        foreach ($parts as $part) {
            $camelCase .= ucfirst(strtolower($part));
        }

        return $camelCase;
    }

    public static function arrayKeysToIds($originalArray)
    {
        $newArray = array();

        foreach ($originalArray as $item) {
            if (isset($item['link'])) {
                $id = self::convertToCamelCase($item['link']);
                $newArray[$id] = $item;
            }
        }

        return $newArray;
    }

    public static function GetPage($file_type, $file_name)
    {
        // تحميل الملف إذا كان يحتوي على كلاس
        $file_path = 'Page/' . $file_type . '/' . $file_name . '.php';

        if (file_exists($file_path)) {
            require_once $file_path;

            // إذا كان اسم الملف يطابق اسم كلاس
            if (class_exists($file_name)) {
                $class = new $file_name();
                if (method_exists($class, 'GetView')) {
                    return $class->GetView();
                }
                return $class;
            }

            // إذا كان الملف يعيد قيمة (مثل view)
            return require $file_path;
        }

        throw new Exception("الملف غير موجود: " . $file_path);
    }

    function FormCreate($form)
    {

        $str_form = '';
        $str_form .= '<div class="form-c ' . $form['name'] . '-form-c">';
        $str_form .= '<div class="form-w ' . $form['name'] . '-form-w">';
        $str_form .= '<div class="form ' . $form['name'] . '-form">';

        $str_form .= '<form';
        $str_form .= ' id="' . $form['id'] . '"';
        $str_form .= ' class="' . $form['class'] . '"';
        $str_form .= ' action="' . $form['action'] . '"';
        $str_form .= ' method="' . $form['method'] . '"';
        $str_form .= ' enctype="' . $form['enctype'] . '"';
        $str_form .= ' target="' . $form['target'] . '"';
        $str_form .= ' autocomplete="' . $form['autocomplete'] . '"';
        $str_form .= '>';



        $str_form .= '<div class="form-title-c ' . $form['id'] . '-form-title-c">';
        $str_form .= '<div class="form-title-w ' . $form['id'] . '-form-title-w">';
        $str_form .= '<div class="form-title ' . $form['id'] . '-form-title">';

        $str_form .= '' . $form['title'] . '';

        $str_form .= '</div>'; //form-title
        $str_form .= '</div>'; //form-title-w
        $str_form .= '</div>'; //form-title-c




        foreach ($form['input'] as $input) {
            if (isset($input['type']) == true && isset($input['name']) == true) {

                if (isset($input['id']) == false) {
                    $input['id'] = $input['name'];
                }

                $str_form .= '<span class="input-c ' . $form['id'] . '-input-c">';
                $str_form .= '<span class="input-w ' . $form['id'] . '-input-w">';
                $str_form .= '<span class="input ' . $form['id'] . '-input">';

                switch ($input['type']) {
                    case 'textarea':
                        # code...
                        break;
                    case 'number':
                        # code...
                        break;
                    case 'color':
                        # code...
                        break;
                    case 'date':
                        # code...
                        break;
                    case 'time':
                        # code...
                        break;
                    case 'datetime-local':
                        # code...
                        break;
                    case 'checkbox':
                        $checked = (isset($input['value']) && $input['value']) ? ' checked' : '';
                        $str_form .= '<label class="checkbox-label">';
                        $str_form .= '<input type="checkbox"';
                        $str_form .= ' name="' . $input['name'] . '"';
                        $str_form .= ' id="' . ($input['id'] ?? $input['name']) . '"';
                        $str_form .= ' class="checkbox-input"';
                        $str_form .= ' value="1"';
                        $str_form .= $checked;
                        $str_form .= (isset($input['required']) ? ' required' : '');
                        $str_form .= '>';
                        $str_form .= '<span class="checkbox-text">' . $input['title'] . '</span>';
                        $str_form .= '</label>';
                        break;
                    case 'radio':
                        # code...
                        break;
                    case 'range':
                        # code...
                        break;
                    case 'file':
                        $str_form .= '<input';
                        $str_form .= ' type="' . $input['type'] . '"';
                        $str_form .= ' name="' . $input['name'] . '"';
                        $str_form .= ' id="' . $input['id'] . '"';
                        $str_form .= ' class="' . $input['class'] . '"';
                        $str_form .= ' style="' . $input['style'] . '"';
                        $str_form .= ' value="' . $input['value'] . '"';
                        $str_form .= ' placeholder="' . $input['placeholder'] . '"';
                        $str_form .= ' >';
                        break;
                    case 'files':
                        $str_form .= '<input multiple type="file"';
                        $str_form .= ' name="' . $input['name'] . '"';
                        $str_form .= ' id="' . $input['id'] . '"';
                        $str_form .= ' class="' . $input['class'] . '"';
                        $str_form .= ' style="' . $input['style'] . '"';
                        $str_form .= ' value="' . $input['value'] . '"';
                        $str_form .= ' placeholder="' . $input['placeholder'] . '"';
                        $str_form .= ' >';
                        break;
                    case 'button':
                        # code...
                        break;
                    case 'reset':
                        # code...
                        break;
                    case 'submit':
                        $str_form .= '<input';
                        $str_form .= ' type="' . $input['type'] . '"';
                        $str_form .= ' name="' . $input['name'] . '"';
                        $str_form .= (isset($input['id'])) ? ' id="' . $input['id'] . '"' : '';
                        $str_form .= (isset($input['class'])) ? ' class="' . $input['class'] . '"' : '';
                        $str_form .= (isset($input['style'])) ? ' style="' . $input['style'] . '"' : '';
                        $str_form .= (isset($input['value'])) ? ' value="' . $input['value'] . '"' : '';
                        $str_form .= (isset($input['placeholder'])) ? ' placeholder="' . $input['placeholder'] . '"' : '';
                        $str_form .= (isset($input['pattern'])) ? ' pattern="' . $input['pattern'] . '"' : '';
                        $str_form .= ' >';
                        break;
                    case 'text':
                    case 'password':
                    case 'email':
                    case 'tel':
                    case 'url':
                    case 'url':
                    case 'hidden':
                    default:
                        if (isset($input['error'])) {
                            $str_form .= '<span class=" error-span ">' . $input['error'] . '</span>';
                            (isset($input['class'])) ? $input['class'] .= ' error-input ' : '';
                        }
                        $str_form .= '<label for="' . $input['id'] . '">';
                        $str_form .= '' . $input['title'] . '';
                        $str_form .= '</label>';
                        $str_form .= '<input';
                        $str_form .= ' type="' . $input['type'] . '"';
                        $str_form .= ' name="' . $input['name'] . '"';
                        $str_form .= (isset($input['id'])) ? ' id="' . $input['id'] . '"' : '';
                        $str_form .= (isset($input['class'])) ? ' class="' . $input['class'] . '"' : '';
                        $str_form .= (isset($input['style'])) ? ' style="' . $input['style'] . '"' : '';
                        $str_form .= (isset($input['value'])) ? ' value="' . $input['value'] . '"' : '';
                        $str_form .= (isset($input['placeholder'])) ? ' placeholder="' . $input['placeholder'] . '"' : '';
                        $str_form .= (isset($input['pattern'])) ? ' pattern="' . $input['pattern'] . '"' : '';
                        $str_form .= ' >';
                        break;
                }

                $str_form .= '</span>'; //input
                $str_form .= '</span>'; //input-w
                $str_form .= '</span>'; //input-c


            } else {
                continue;
            }
        }

        $str_form .= '</form>';

        $str_form .= '</div>'; //form
        $str_form .= '</div>'; //form-w
        $str_form .= '</div>'; //form-c

        return $str_form;
    }
}
