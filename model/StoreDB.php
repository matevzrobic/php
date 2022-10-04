<?php

require_once 'model/AbstractDB.php';

class StoreDB extends AbstractDB {

    public static function get(array $id)
    {
        $books = parent::query("SELECT books.id, books.title, books.author, books.description, books.price, books.img, imgs.imgblob, imgs.id AS imgid"
//            . " group_concat(imgs.imgblob) as images // concats data with ','
            . " FROM books"
            . " LEFT JOIN imgs"
            . "     ON books.id = imgs.bookId AND imgs.isDeleted=0"
            . " WHERE books.id = :id ",$id);
//        . " GROUP BY books.id"
        $images = array();
        foreach($books as $book)
            if($book["imgblob"] != null && strlen($book["imgblob"]) > 1 ){
                $image = array();
                $image["imgblob"] = $book["imgblob"];
                $image["id"] = $book["imgid"];
                $images[]=$image;
            }

        if (count($books) >= 1) {
//          $img_array = explode(",", $books[0]["images"]);
            $books[0]["images"] = $images;
            return $books[0];
        } else
            throw new InvalidArgumentException("No such book");

    }

    public static function deleteImage(array $params){
        return parent::modify("UPDATE imgs SET isDeleted = 1"
            . " WHERE id = :id", $params);
    }

    public static function getAllBooks()
    {
        return parent::query("SELECT id, title, author, description, price, img, isDeleted"
            . " FROM books"
            . " ORDER BY id ASC");

    }

    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO books (title, author, description, price, img) "
            . " VALUES (:title, :author, :description, :price, :img)", $params);
    }

    public static function update(array $params)
    {
        return parent::modify("UPDATE books SET author = :author, title = :title, "
            . "description = :description, price = :price, img = :img"
            . " WHERE id = :id", $params);
    }

    public static function delete(array $id)
    {
        // TODO: Implement delete() method.
    }

// CE KOMU USPE USPOSOBT TA SQL CESTITKE
//    public static function getSpecificBooks(array $id)
//    {
//        return parent::query("SELECT id, title, author, description, price, img"
//            . " FROM books"
//            . " WHERE id IN :id)"
//            . " ORDER BY id ASC",$id );
//    }

    public static function getSpecificBooks(array $params) {
        $res = parent::query(" SELECT * FROM books " .
            " WHERE MATCH (title, author, description) " .
            " AGAINST (:searchString IN BOOLEAN MODE )", $params);
        return $res;
    }

    public static function getUser(array $params)
    {
        $users =  parent::query("SELECT users.id, users.firstname, users.lastname, users.email, users.password, users.permission, users.isConfirmed, users.isDeleted, users.dateCreated, users.dateDeleted,users.adress, adress.street, adress.house_number, adress.post, adress.post_number
        FROM users          
        LEFT JOIN adress
            ON users.adress=adress.id
        WHERE users.id= :id     
        ", $params);

        if (count($users) == 1) {
            return $users[0];
        } else {
            # var_dump($users);
            throw new InvalidArgumentException("No such user");
        }
    }

    public static function getUsers()
    {
        return parent::query("SELECT users.id, users.firstname, users.lastname, users.email, users.password, users.permission, users.isConfirmed, users.isDeleted, users.dateCreated, users.dateDeleted, users.certCN, users.adress, adress.street, adress.house_number, adress.post, adress.post_number
        FROM users
        LEFT JOIN adress
        ON users.adress=adress.id 
        ORDER BY id ASC");
    }

    public static function getCustomers()
    {
        return parent::query("SELECT users.id, users.firstname, users.lastname, users.email, users.password, users.permission, users.isConfirmed, users.isDeleted, users.dateCreated, users.dateDeleted, users.certCN, users.adress, adress.street, adress.house_number, adress.post, adress.post_number
        FROM users
        LEFT JOIN adress
        ON users.adress=adress.id 
        WHERE permission = 2
        ORDER BY id ASC");
    }

    public static function addUser(array $params)
    {
        return parent::modify("INSERT INTO users (firstname, lastname, email, password, dateCreated, permission, isConfirmed, isDeleted, adress ) "
            . " VALUES (:firstname, :lastname, :email, :password, :dateCreated, :permission, :isConfirmed, :isDeleted, :adress)", $params);

    }

    public static function updateUser(array $params)
    {
        #var_dump($params);
        return parent::modify("UPDATE users SET firstname = :firstname, lastname = :lastname, isConfirmed = :isConfirmed,"
            . "email = :email, password = :password"
            . " WHERE id = :id", $params);
    }

    public static function updateUserNoPass(array $params)
    {
        #var_dump($params);
        return parent::modify("UPDATE users SET firstname = :firstname, lastname = :lastname, isConfirmed = :isConfirmed,"
            . "email = :email"
            . " WHERE id = :id", $params);
    }

    public static function createOrder(array $params)
    {
        return parent::modify("INSERT INTO bookorder (userid, date, status) "
            . " VALUES (:userid, :date, :status)", $params);
    }

    public static function createOrderItem(array $params)
    {
        return parent::modify("INSERT INTO orderitem (orderid , bookid , quantity) "
            . " VALUES (:orderid, :bookid, :quantity)", $params);
    }

    public static function getSellers()
    {
        return parent::query("SELECT id, firstname, lastname, email, password, permission, isDeleted"
            . " FROM users"
            . " WHERE permission=1"
            . " ORDER BY isDeleted ASC, id ASC");
    }

    public static function getSeller(array $id)
    {
        $sellers = parent::query("SELECT id, firstname, lastname, email, password, permission, isDeleted, certCN"
            . " FROM users "
            . " WHERE id = :id ", $id);

        if (count($sellers) == 1) {
            return $sellers[0];
        } else {
            throw new InvalidArgumentException("No such seller");
        }
    }

    public static function addSeller(array $params)
    {
        return parent::modify("INSERT INTO users (firstname, lastname, email, password, permission, isDeleted, certCN) "
            . " VALUES (:firstname, :lastname, :email, :password, :permission, :isDeleted, :certCN)", $params);

    }

    public static function updateSeller(array $params)
    {
        return parent::modify("UPDATE users SET firstname = :firstname, lastname = :lastname, "
            . "email = :email, password = :password, "
            . "permission = :permission, isDeleted = :isDeleted, "
            . "certCN = :certCN"
            . " WHERE id = :id", $params);

    }
    public static function updateSellerNoPass(array $params)
    {
        return parent::modify("UPDATE users SET firstname = :firstname, lastname = :lastname, "
            . "email = :email,"
            . "permission = :permission, isDeleted = :isDeleted, "
            . "certCN = :certCN"
            . " WHERE id = :id", $params);

    }

    public static function createAdress(array $params)
    {
        return parent::modify("INSERT INTO adress (street, house_number, post, post_number) "
            . " VALUES (:street, :house_number, :post, :post_number)", $params);
    }

    public static function updateAdress(array $params)
    {
        return parent::modify("UPDATE adress SET street = :street, house_number = :house_number, "
            . "post = :post, post_number = :post_number"
            . " WHERE id = :id", $params);
    }

    public static function getAdress(array $params)
    {
        // TODO: Implement getAdress() method.
    }

    public static function getOrders()
    {
        return parent::query("SELECT * FROM bookorder");
    }

    public static function getOwnOrders()
    {
        $orders =  parent::query("SELECT * FROM bookorder WHERE userid = :id", $_SESSION["user"] );
        return $orders;
    }

    public static function getOrdersById(array $params) {
        return parent::query("SELECT * FROM bookorder WHERE userid = :id", $params);
    }

    public static function modifyOrders(array $params)
    {
        return parent::modify("UPDATE bookorder SET status = :status"
            . " WHERE id = :id", $params);
    }

    public static function getOrderDetails(array $params)
    {
        return parent::query("
            SELECT * 
            FROM bookorder
            JOIN orderitem 
              ON orderitem.orderid = bookorder.id 
              JOIN books 
                ON orderitem.bookid = books.id 
            WHERE bookorder.id = :id", $params);
    }

    public static function deleteBook(array $params)
    {
        return parent::modify("UPDATE books SET isDeleted = :isDeleted"
            . " WHERE id = :id", $params);
    }

    public static function deleteCostumer(array $params){
        return parent::modify("UPDATE users SET isDeleted = :status"
            . " WHERE id = :id", $params);
    }

    public static function isUserCertified(array $params){
        $users = parent::query("SELECT id, firstname, lastname, email, password, permission, isDeleted"
            . " FROM users "
            . " WHERE email = :email, certCA = :certCA ", $params);

        if (count($users) == 1) {
            return $users[0];
        } else {
            throw new InvalidArgumentException("No such certified user");
        }
    }

    public static function insertImage( array $params){

        # $params["imgBlob"] = file_get_contents($params["img"]);

        return parent::modify("INSERT INTO imgs (imgblob, bookId) "
            . " VALUES (:imgblob, :bookId)", $params);
    }

    public static function getAvgRating(array $params) {
        $avgRating = parent::query(" SELECT AVG(rating) AS rating "
        . " FROM rating "
        . " WHERE bookid = :id ", $params);

        return $avgRating[0];
    }

    public static function insertRating(array $params) {
        return parent::modify(" INSERT INTO rating (bookid, userid, rating) "
        . " VALUES (:bookid, :userid, :rating)", $params);
    }

    public static function updateRating(array $params) {
        return parent::modify("UPDATE rating SET bookid = :bookid, userid = :userid, rating = :rating", $params);
    }

    public static function getRating(array $params) {
        $ratings = parent::query(" SELECT id FROM rating WHERE userid = :userid AND bookid = :bookid", $params );

        return $ratings[0];
    }

    public static function getCart(array $params){
        return parent::query("SELECT cart FROM users WHERE id = :id ", $params);
    }

    public static function deleteCart(array $params){
        return parent::query("UPDATE users SET cart=null WHERE id = :id ", $params);
    }

    public static function setCart(array $params){
        return parent::query("UPDATE users SET cart= :cart WHERE id = :id ", $params);
    }

    
}