<?php
class SQLCommands
{

    public static function GetUserInfo()
    {
        $query = "SELECT 
            u.user_id,
            u.user_name,
            u.user_email,
            GROUP_CONCAT(DISTINCT p.permission_id ORDER BY p.permission_id SEPARATOR ', ') AS permission_ids,
            GROUP_CONCAT(DISTINCT p.permission_link ORDER BY p.permission_id SEPARATOR ', ') AS permission_links ,
            CONCAT(
                '[',
                GROUP_CONCAT(
                    DISTINCT
                    JSON_OBJECT(
                        'id', p.permission_id,
                        'link', p.permission_link,
                        'title', p.permission_title,
                        'author', p.permission_author,
                        'description', p.permission_description,
                        'image', p.permission_image,
                        'copyright', p.permission_copyright,
                        'keywords',p.permission_keywords,
                        'public',p.permission_public
                    )
                    SEPARATOR ','
                ),
                ']'
            ) AS permissions_json
        FROM 
            users u
        LEFT JOIN 
            user_permission up ON u.user_id = up.user_id
        LEFT JOIN 
            permissions p ON up.permission_id = p.permission_id  OR p.permission_public = 1
        WHERE 
            u.user_id = ? 
        GROUP BY 
            u.user_id";


        $params[] = System::SuperArrayGet('user_id');

        return [
            'query' => $query,
            'params' => $params
        ];
    }

    public static function LogInUserInfo()
    {
        $query = "SELECT 
            u.user_id,
            u.user_name,
            u.user_email,
            u.user_password,
            GROUP_CONCAT(DISTINCT p.permission_id ORDER BY p.permission_id SEPARATOR ', ') AS permission_ids,
            GROUP_CONCAT(DISTINCT p.permission_link ORDER BY p.permission_id SEPARATOR ', ') AS permission_links ,
            CONCAT(
                '[',
                GROUP_CONCAT(
                    DISTINCT
                    JSON_OBJECT(
                        'id', p.permission_id,
                        'link', p.permission_link,
                        'title', p.permission_title,
                        'author', p.permission_author,
                        'description', p.permission_description,
                        'image', p.permission_image,
                        'copyright', p.permission_copyright,
                        'keywords',p.permission_keywords,
                        'public',p.permission_public
                    )
                    SEPARATOR ','
                ),
                ']'
            ) AS permissions_json
        FROM 
            users u
        LEFT JOIN 
            user_permission up ON u.user_id = up.user_id
        LEFT JOIN 
            permissions p ON up.permission_id = p.permission_id  OR p.permission_public = 1
        WHERE 
            u.user_email = ? 
        GROUP BY 
            u.user_id";


        $params[] = System::SuperArrayGet('user_email');


        return [
            'query' => $query,
            'params' => $params
        ];
    }


    public static function RegNewUser()
    {
        $query = "SELECT 
            u.user_id,
            u.user_name,
            u.user_email,
            u.user_password,
            GROUP_CONCAT(DISTINCT p.permission_id ORDER BY p.permission_id SEPARATOR ', ') AS permission_ids,
            GROUP_CONCAT(DISTINCT p.permission_link ORDER BY p.permission_id SEPARATOR ', ') AS permission_links ,
            CONCAT(
                '[',
                GROUP_CONCAT(
                    DISTINCT
                    JSON_OBJECT(
                        'id', p.permission_id,
                        'link', p.permission_link,
                        'title', p.permission_title,
                        'author', p.permission_author,
                        'description', p.permission_description,
                        'image', p.permission_image,
                        'copyright', p.permission_copyright,
                        'keywords',p.permission_keywords,
                        'public',p.permission_public
                    )
                    SEPARATOR ','
                ),
                ']'
            ) AS permissions_json
        FROM 
            users u
        LEFT JOIN 
            user_permission up ON u.user_id = up.user_id
        LEFT JOIN 
            permissions p ON up.permission_id = p.permission_id  OR p.permission_public = 1
        WHERE 
            u.user_email = ? 
        GROUP BY 
            u.user_id";


        $params[] = System::SuperArrayGet('user_email');


        return [
            'query' => $query,
            'params' => $params
        ];
    }
}
