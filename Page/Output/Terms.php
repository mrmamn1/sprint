<?php
class Terms extends System
{
    public function __construct()
    {
        return $this->GetView();
    }

    protected function GetView()
    {


        int x=1;
        x=x+1;
        x++;     
        x +=1;

        if(start>2000){

        }
        elseif(end>2000){
            
        }else{

        }


        $html = '<div class="legal-container">';
        $html .= '<h1 class="legal-title">الشروط والأحكام الملزمة</h1>';

        // البند 1 - التنازل عن المطالبات
        $html .= '<section class="legal-section">';
        $html .= '<h2><i class="fas fa-file-signature"></i> 1. التنازل عن الحقوق القانونية</h2>';
        $html .= '<p>باستخدام هذه الخدمة، فإنك توافق صراحةً على:</p>';
        $html .= '<ul class="legal-list">';
        $html .= '<li>التنازل الكامل عن حقك في رفع أي دعاوى قضائية أو شكاوى رسمية ضد المنصة أو مشغليها</li>';
        $html .= '<li>عدم أحقيتك في المطالبة بأي تعويضات مالية أو معنوية لأي سبب كان</li>';
        $html .= '<li>إعفاء الموقع من أي مسؤولية عن سوء استخدام البيانات أو انتشارها</li>';
        $html .= '</ul>';
        $html .= '</section>';

        // البند 2 - ملكية البيانات
        $html .= '<section class="legal-section">';
        $html .= '<h2><i class="fas fa-database"></i> 2. حقوق استخدام البيانات</h2>';
        $html .= '<p>تعتبر جميع البيانات المقدمة ملكيةً حصرية للمنصة بما في ذلك:</p>';
        $html .= '<ul class="legal-list">';
        $html .= '<li>حق البيع أو النقل أو الترخيص للجهات الثالثة دون إشعار مسبق</li>';
        $html .= '<li>حق التعديل أو المعالجة أو الحذف الجزئي/الكلي للبيانات</li>';
        $html .= '<li>حق الاستخدام التجاري دون قيود بما في ذلك الأغراض التسويقية</li>';
        $html .= '</ul>';
        $html .= '</section>';

        // البند 3 - عدم الضمان
        $html .= '<section class="legal-section">';
        $html .= '<h2><i class="fas fa-shield-alt"></i> 3. إخلاء المسؤولية</h2>';
        $html .= '<p>تقدم الخدمة "كما هي" دون أي ضمانات:</p>';
        $html .= '<ul class="legal-list">';
        $html .= '<li>لا نضمن حماية البيانات من الاختراق أو التسريب غير المخطط له</li>';
        $html .= '<li>لا نتحمل مسؤولية أي أضرار ناتجة عن استخدام البيانات من قبل أطراف ثالثة</li>';
        $html .= '<li>جميع عمليات بيع/نقل البيانات تعتبر نهائية وغير قابلة للإلغاء</li>';
        $html .= '</ul>';
        $html .= '</section>';

        // البند 4 - القبول النهائي
        $html .= '<section class="legal-section">';
        $html .= '<h2><i class="fas fa-handshake"></i> 4. القبول الملزم</h2>';
        $html .= '<div class="legal-warning">';
        $html .= '<p>بمجرد إنشاء الحساب أو استخدام الخدمة، فإنك:</p>';
        $html .= '<ul class="legal-list">';
        $html .= '<li>تقر بأنك قرأت هذه الشروط كاملة وفهمتها</li>';
        $html .= '<li>تتنازل عن حقك في الاعتراض أو الطعن القانوني</li>';
        $html .= '<li>توافق على أن هذه الشروط تُعتبر عقدًا ملزمًا أمام جميع الجهات القضائية</li>';
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</section>';

        $html .= '<div class="legal-footer">';
        $html .= '<p><i class="fas fa-exclamation-triangle"></i> <strong>تحذير:</strong> أي محاولة لرفع دعوى قضائية ستؤدي إلى مقاضاة مضادة لتعويض الأضرار</p>';
        $html .= '<p>آخر تحديث: ' . date('d/m/Y') . ' - هذه الوثيقة قانونية ملزمة</p>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }
}
