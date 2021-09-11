<?php

class CommentManager
{
    public static function getCommentsByPost($post)
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT c.*, u.login AS user
                FROM comments c
                LEFT JOIN users u ON u.id = c.user
                WHERE post = :post
                ');
        $query->execute(array(
            'post' => $post
        ));

       return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Comment');
    }

    public static function create($args)
    {
        $comment = $args['comment'];
        $post = $args['post'];

        $errors = self::checkData($comment);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        $query = MyPDO::getInstance()->prepare('
                INSERT INTO comments(comment, date, post, user)
                VALUES (:comment, :date, :post, :user)
                ');
        $query->execute([
            'comment' => $comment,
            'date' => date('Y-m-d H:i:s'),
            'post' => $post,
            'user' => $_SESSION['user']->getId()
        ]);

        return 'Comment successfully sent';
    }

    public static function delete($id)
    {
        try {
            $query = MyPDO::getInstance()->prepare('
                DELETE
                FROM comments
                WHERE id = :id
                ');
            $query->execute(['id' => $id]);
        } catch (Exception $exception) {
            throw new Exception('Error when deleting this comment');
        }

        return 'Comment successfully deleted';
    }

    public static function checkData($comment)
    {
        if (empty($comment)) {
            return 'You must fill a comment';
        }

        return null;
    }
}
