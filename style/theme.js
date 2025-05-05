document.addEventListener('DOMContentLoaded', function() {
    const themeSwitcher = document.getElementById('theme-switcher');
    const body = document.body;
    const themeIcon = themeSwitcher.querySelector('i');
    const themeText = themeSwitcher.querySelector('.theme-text');
    
    // التحقق من تفضيلات المستخدم
    function checkPreferredTheme() {
      const savedTheme = localStorage.getItem('theme');
      const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      
      if (savedTheme) {
        return savedTheme;
      } else if (systemPrefersDark) {
        return 'dark';
      } else {
        return 'light';
      }
    }
    
    // تطبيق الوضع
    function applyTheme(theme) {
      if (theme === 'dark') {
        body.classList.add('dark-mode');
        themeIcon.classList.replace('fa-moon', 'fa-sun');
        themeText.textContent = 'الوضع الفاتح';
      } else {
        body.classList.remove('dark-mode');
        themeIcon.classList.replace('fa-sun', 'fa-moon');
        themeText.textContent = 'الوضع الداكن';
      }
    }
    
    // تبديل الوضع
    function toggleTheme() {
      const currentTheme = body.classList.contains('dark-mode') ? 'dark' : 'light';
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      
      localStorage.setItem('theme', newTheme);
      applyTheme(newTheme);
    }
    
    // تهيئة الوضع الأولي
    const preferredTheme = checkPreferredTheme();
    applyTheme(preferredTheme);
    
    // إضافة مستمع الحدث
    themeSwitcher.addEventListener('click', toggleTheme);
    
    // تتبع تغييرات نظام التشغيل
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
      if (!localStorage.getItem('theme')) {
        applyTheme(e.matches ? 'dark' : 'light');
      }
    });
  });