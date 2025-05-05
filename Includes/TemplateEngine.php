<?php
class TemplateEngine {
    private $templateDir;
    private $variables = [];

    /**
     * Constructor
     * @param string $templateDir مسار مجلد القوالب
     */
    public function __construct($templateDir = 'template') {
        $this->templateDir = rtrim($templateDir, '/') . '/';
    }

    /**
     * تعيين متغيرات القالب
     * @param string $name اسم المتغير
     * @param mixed $value قيمة المتغير
     */
    public function assign($name, $value) {
        $this->variables[$name] = $value;
    }

    /**
     * تعيين عدة متغيرات مرة واحدة
     * @param array $vars مصفوفة المتغيرات
     */
    public function assignMultiple($vars) {
        foreach ($vars as $name => $value) {
            $this->assign($name, $value);
        }
    }

    /**
     * عرض ملف القالب
     * @param string $templateFile اسم ملف القالب
     * @param array $additionalVars متغيرات إضافية
     * @return string المحتوى المعالج
     */
    public function render($templateFile, $additionalVars = []) {
        $templatePath = $this->templateDir . $templateFile;

        if (!file_exists($templatePath)) {
            throw new Exception("ملف القالب غير موجود: " . $templatePath);
        }

        // دمج المتغيرات الإضافية مع المتغيرات الأساسية
        $allVars = array_merge($this->variables, $additionalVars);

        // استخراج المتغيرات لتكون متاحة في القالب
        extract($allVars);

        // بدء التقاط الإخراج
        ob_start();

        // تضمين ملف القالب
        include $templatePath;

        // الحصول على المحتوى الملتقط وإفراغ المخزن المؤقت
        $content = ob_get_clean();

        // استبدال المتغيرات على شكل {$var}
        foreach ($allVars as $name => $value) {
            $content = str_replace('{$' . $name . '}', $value, $content);
        }

        return $content;
    }

    /**
     * عرض ملف القالب مع أجزاء أخرى (هيدر، فوتر، نافبار، إلخ)
     * @param string $templateFile اسم ملف القالب الرئيسي
     * @param array $parts أجزاء الصفحة
     * @param array $additionalVars متغيرات إضافية
     * @return string المحتوى الكامل المعالج
     */
    public function renderWithParts($templateFile, $parts = [], $additionalVars = []) {
        $partsContent = [];

        // تحميل جميع الأجزاء المطلوبة
        foreach ($parts as $partName => $partFile) {
            $partsContent[$partName] = $this->render($partFile, $additionalVars);
        }

        // دمج محتوى الأجزاء مع المتغيرات الإضافية
        $allVars = array_merge($additionalVars, $partsContent);

        // عرض القالب الرئيسي
        return $this->render($templateFile, $allVars);
    }
}