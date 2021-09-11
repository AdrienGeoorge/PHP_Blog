<?php

class CategoryManager
{
    public static function getCategory($id)
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT *
                FROM categories
                WHERE id = :id
                ');
        $query->execute(array(
            'id' => $id
        ));

        $result = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');

        if ($result[0] !== null) {
            return $result[0];
        }

        return null;
    }

    public static function getCategories()
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT *
                FROM categories
                ORDER BY id DESC
                ');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
    }

    public static function create($args)
    {
        $name = $args['name'];

        $errors = self::checkData($name);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        $query = MyPDO::getInstance()->prepare('
                INSERT INTO categories(name)
                VALUES (:name)
                ');
        $query->execute([
            'name' => $name,
        ]);

        return 'Category successfully created';
    }

    public static function update($args, $category)
    {
        $name = $args['name'];

        $errors = self::checkData($name);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        $query = MyPDO::getInstance()->prepare('
                UPDATE categories
                SET name = :name
                WHERE id = :id
                ');
        $query->execute([
            'name' => $name,
            'id' => $category->getId()
        ]);

        return 'Category successfully updated';
    }

    public static function delete($id)
    {
        try {
            $query = MyPDO::getInstance()->prepare('
                DELETE
                FROM categories
                WHERE id = :id
                ');
            $query->execute(['id' => $id]);
        } catch (Exception $exception) {
            throw new Exception('Impossible to delete this category because articles are attached to it');
        }

        return 'Category successfully deleted';
    }

    public static function checkData($name)
    {
        if (empty($name)) {
            return 'You must fill a name';
        }

        return null;
    }
}
