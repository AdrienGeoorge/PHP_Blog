<?php

class PostManager
{
    public static function getPost($id)
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT p.id, p.title, p.content, p.date, u.login AS user, group_concat(i.id, "__", i.image SEPARATOR ";") as image, c.name AS category
                FROM posts p
                LEFT JOIN users u ON u.id = p.user
                LEFT JOIN images i ON i.post_id = p.id
                LEFT JOIN categories c ON c.id = p.category
                WHERE p.id = :id
                GROUP BY p.id
                ');
        $query->execute(array(
            'id' => $id
        ));

        $result = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');

        if ($result[0] !== null) {
            return $result[0];
        }

        return null;
    }

    public static function getLastPosts()
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT p.id, p.title, u.id AS user, group_concat(i.id, "__", i.image SEPARATOR ";") as image, c.name AS category
                FROM posts p
                LEFT JOIN images i ON i.post_id = p.id
                LEFT JOIN users u ON u.id = p.user
                LEFT JOIN categories c ON c.id = p.category
                GROUP BY p.id
                ORDER BY p.id DESC
                ');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');
    }

    public static function getPostByUser()
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT p.id, p.title, group_concat(i.id, "__", i.image SEPARATOR ";") as image, c.name AS category
                FROM posts p
                LEFT JOIN images i ON i.post_id = p.id
                LEFT JOIN categories c ON c.id = p.category
                WHERE p.user = :id
                GROUP BY p.id
                ORDER BY p.id DESC
                ');
        $query->execute(['id' => $_SESSION['user']->getId()]);

        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');
    }

    public static function create($args)
    {
        $title = $args['title'];
        $content = $args['content'];
        $category = $args['category'];

        $errors = self::checkData($title, $content, $category);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        $image = $_FILES['post_img'];

        if ($image['error'] == UPLOAD_ERR_OK && empty($image['name']) === false) {
            $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];

            $uploadDir = 'public/posts/';
            $imageFileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            $uploadFile = $uploadDir . uniqid() . uniqid() . '.' . $imageFileType;

            if (!in_array($imageFileType, $fileExtensionsAllowed)) {
                throw new Exception('This ' . $image . ' image is not allowed: please upload a JPEG or PNG file');
            }

            if (move_uploaded_file($image['tmp_name'], $uploadFile) === false) {
                throw new Exception('Error while uploading an image');
            }

            $image = $uploadFile;
        }

        $query = MyPDO::getInstance()->prepare('
                INSERT INTO posts(title, content, category, date, user)
                VALUES (:title, :content, :category, :date, :user)
                ');
        $query->execute([
            'title' => $title,
            'content' => $content,
            'category' => $category,
            'date' => date('Y-m-d H:i:s'),
            'user' => $_SESSION['user']->getId()
        ]);

        $postId = MyPDO::getInstance()->lastInsertId();

        $query = MyPDO::getInstance()->prepare('
                INSERT INTO images(post_id, image)
                VALUES (:post_id, :image)
                ');
        $query->execute([
            'post_id' => $postId,
            'image' => $image,
        ]);

        return 'Post successfully posted';
    }

    public static function update($args, $post)
    {
        $title = $args['title'];
        $content = $args['content'];
        $category = $args['category'];

        $errors = self::checkData($title, $content, $category);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        if (empty($_FILES['post_img']['name']) === false) {
            $uploadDir = 'public/posts/';
            $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];

            $image = $_FILES['post_img'];

            if (empty($image['name'] === false)) {
                $imageFileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                $uploadFile = $uploadDir . uniqid() . uniqid() . '.' . $imageFileType;

                if (!in_array($imageFileType, $fileExtensionsAllowed)) {
                    throw new Exception('An image is not allowed: please upload a JPEG or PNG file');
                }

                if (move_uploaded_file($image['tmp_name'], $uploadFile) === false) {
                    throw new Exception('Error while uploading an image');
                }

                $image = $uploadFile;
            }

            if (empty($post->getImage()[0]) === false) {
                $query = MyPDO::getInstance()->prepare('
                UPDATE images
                SET image = :image
                WHERE id = :id
                ');
                $query->execute([
                    'image' => $image,
                    'id' => $post->getImage()[0],
                ]);
            } else {
                $query = MyPDO::getInstance()->prepare('
                INSERT INTO images(post_id, image)
                VALUES (:post_id, :image)
                ');
                $query->execute([
                    'post_id' => $post->getId(),
                    'image' => $image,
                ]);
            }
        }

        $query = MyPDO::getInstance()->prepare('
                UPDATE posts
                SET title = :title, content = :content, category = :category
                WHERE id = :id
                ');
        $query->execute([
            'title' => $title,
            'content' => $content,
            'category' => $category,
            'id' => $post->getId()
        ]);

        return 'Post successfully updated';
    }

    public static function delete($id)
    {
        try {
            $query = MyPDO::getInstance()->prepare('
                DELETE
                FROM posts
                WHERE id = :id
                ');
            $query->execute(['id' => $id]);
        } catch (Exception $exception) {
            throw new Exception('Error when deleting the post');
        }

        return 'Post successfully deleted';
    }

    public static function checkData($title, $content, $category)
    {
        if (empty($title) || empty($content) || empty($category)) {
            return 'You must fill all the fields';
        }

        return null;
    }
}
