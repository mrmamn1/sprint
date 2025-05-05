<?php
class Database extends System
{
    private static $instance;
    private static $host;
    private static $username;
    private static $password;
    private static $database;
    private static $port;
    private static $connection;
    private static $error;

    /**
     * تهيئة الإعدادات (بدون إنشاء اتصال فوري)
     */
    public static function init($host, $username, $password, $database, $port = 3306)
    {
        self::$host = $host;
        self::$username = $username;
        self::$password = $password;
        self::$database = $database;
        self::$port = $port;
    }

    /**
     * الحصول على اتصال قاعدة البيانات (Singleton)
     */
    private static function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new mysqli(
                self::$host,
                self::$username,
                self::$password,
                self::$database,
                self::$port
            );

            if (self::$connection->connect_error) {
                self::$error = self::$connection->connect_error;
                throw new Exception("فشل الاتصال بMySQL: " . self::$error);
            }

            self::$connection->set_charset("utf8mb4");
        }

        return self::$connection;
    }

    /**
     * تنفيذ استعلام SELECT
     */
    public static function select($query, $params = [])
    {
        $stmt = self::prepareStatement($query, $params);
        $stmt->execute();
        $result = $stmt->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $stmt->close();
        return $rows;
    }

    /**
     * تنفيذ استعلام INSERT
     */
    public static function insert($query, $params = [])
    {
        $stmt = self::prepareStatement($query, $params);
        $stmt->execute();
        $insertId = $stmt->insert_id;
        $stmt->close();

        return $insertId;
    }

    /**
     * تنفيذ استعلام UPDATE/DELETE
     */
    public static function execute($query, $params = [])
    {
        $stmt = self::prepareStatement($query, $params);
        $stmt->execute();
        $affectedRows = $stmt->affected_rows;
        $stmt->close();

        return $affectedRows;
    }

    /**
     * تحضير الاستعلام
     */
    private static function prepareStatement($query, $params = [])
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("خطأ في تحضير الاستعلام: " . $conn->error);
        }

        if (!empty($params)) {
            $types = '';
            $values = [];

            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } elseif (is_string($param)) {
                    $types .= 's';
                } else {
                    $types .= 'b';
                }

                $values[] = $param;
            }

            $stmt->bind_param($types, ...$values);
        }

        return $stmt;
    }

    /**
     * بدء معاملة (Transaction)
     */
    public static function beginTransaction()
    {
        self::getConnection()->begin_transaction();
    }

    /**
     * تأكيد المعاملة
     */
    public static function commit()
    {
        self::getConnection()->commit();
    }

    /**
     * تراجع عن المعاملة
     */
    public static function rollback()
    {
        self::getConnection()->rollback();
    }

    /**
     * إغلاق الاتصال
     */
    public static function close()
    {
        if (self::$connection) {
            self::$connection->close();
            self::$connection = null;
        }
    }

    /**
     * الحصول على آخر خطأ
     */
    public static function getError()
    {
        return self::$error ?: (self::$connection ? self::$connection->error : null);
    }
}

/*

$db->execute("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");


////////////////////////////////
// إضافة مستخدم واحد
$newUserId = $db->insert(
    "INSERT INTO users (name, email) VALUES (?, ?)",
    ['أحمد محمد', 'ahmed@example.com']
);

// إضافة عدة مستخدمين
$users = [
    ['سارة علي', 'sara@example.com'],
    ['محمد خالد', 'mohamed@example.com']
];

foreach ($users as $user) {
    $db->insert(
        "INSERT INTO users (name, email) VALUES (?, ?)",
        $user
    );
}

########
// جلب جميع المستخدمين
$allUsers = $db->select("SELECT * FROM users");

// جلب مستخدم معين
$user = $db->select(
    "SELECT * FROM users WHERE id = ?",
    [5]
);

// استعلام مع JOIN
$posts = $db->select(
    "SELECT p.title, p.content, u.name as author 
     FROM posts p 
     JOIN users u ON p.user_id = u.id
     WHERE p.published = ?",
    [1]
);


$affectedRows = $db->execute(
    "UPDATE users SET email = ? WHERE id = ?",
    ['new_email@example.com', 2]
);

echo "تم تحديث $affectedRows صفوف";


$deletedRows = $db->execute(
    "DELETE FROM users WHERE id = ?",
    [3]
);

echo "تم حذف $deletedRows صفوف";


try {
    $db->beginTransaction();
    
    // نقل رصيد بين حسابين
    $db->execute(
        "UPDATE accounts SET balance = balance - ? WHERE id = ?",
        [500, 1]
    );
    
    $db->execute(
        "UPDATE accounts SET balance = balance + ? WHERE id = ?",
        [500, 2]
    );
    
    $db->commit();
    echo "تم التحويل بنجاح";
} catch (Exception $e) {
    $db->rollback();
    echo "فشل التحويل: " . $e->getMessage();
}



$stats = $db->select(
    "SELECT 
        COUNT(*) as total_users,
        MAX(created_at) as newest_user,
        MIN(created_at) as oldest_user
     FROM users"
)[0];

*/