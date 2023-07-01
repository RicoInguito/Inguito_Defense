<?php
include "../classes/interface.php";
include "../database/database.php";

class Students extends Movie implements DbConnection
{
    public $TableName = "name_of_movie";

    public function createTable()
    {
        $this->connection();    

        $createtable = "CREATE TABLE IF NOT EXISTS $this->TableName
        (
        id int auto_increment primary key,
        movie_name varchar(255) not null,
        author varchar(255) not null,
        genre varchar(255) not null,
        login varchar(10) not null default 0
        )";

        $this->conn->query($createtable);
        
    }
    public function search($params)
    {
        if($_SERVER['REQUEST_METHOD'] != 'GET')
        {
            return json_encode(
                [
                    "code" => 404,
                    "message" => "GET method is only allowed!"
                ]
                );
        }
        $movieName = $params['movie_name'] ?? '';
        $author = $params['author'] ?? '';
        // $email = $params['email'] ?? '';
        // $course = $params['course'] ?? '';

        $search = "SELECT * FROM $this->TableName where movie_name like '%$animeTitle%'";

         $issearch = $this->conn->query($search); 

        if(empty($this->db_error()))
        {
            return json_encode($issearch->fetch_all(MYSQLI_ASSOC));
        }else{
            return json_encode(
                [
                    "code" => 101,
                    "message" => $this->db_error(),
                ]
                ); 
        }

    }
    public function getAll()
    {
        $movie = $this->conn->query("SELECT * FROM $this->TableName");

        
        $movieList = [];
        
        return json_encode($movie->fetch_all(MYSQLI_ASSOC));
    }
    public function create($params)
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            return json_encode(
                [
                    "code" => 404,
                    "message" => "POST method is only allowed!"
                ]
                );
        }
        if(!isset($params['movie_name']) || empty($params['movie_name']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Movie name is Required!"
                ]
                );
        }
        if(!isset($params['author']) || empty($params['author']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Author is Required!"
                ]
                );
        }
        if(!isset($params['genre']) || empty($params['genre']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Genre is Required!"
                ]
                );
        }

        $movie_name = $params['movie_name'];
        $author = $params['author'];
        $genre = $params['genre'];

        $insert = "INSERT INTO $this->TableName(movie_name, author, genre)
        VALUES('$movie_name','$author','$genre')";

        $isadded = $this->conn->query($insert);

        if($isadded)
        {
            return json_encode(
                [
                    "code" => 101,
                    "message" => "Added Successfully!"
                ]
                );
        }else{
            return json_encode(
                [
                    "code" => 101,
                    "message" => $this->db_error(),
                ]
                ); 
        }

      
    }
    public function getid($getid)
    {
        if(!isset($getid['id']) || empty($getid['id']))
        {
            $response = [
                'code' => 102,
                'message' => 'id is required'
            ];

            return json_encode($response);
        }
        $id = $getid['id'];

        $data = $this->conn->query("SELECT * FROM $this->TableName WHERE id='$id'");

        if($data->num_rows == 0)
        {
            $response = [
                "code" => 404,
                "message" => "Movie Not Found!"
            ];
            return json_encode($response);
        }
        return json_encode($data->fetch_assoc());
    }
    public function update($params)
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            return json_encode(
                [
                    "code" => 404,
                    "message" => "POST method is only allowed!"
                ]
                );
        }
        if(!isset($params['movie_name']) || empty($params['movie_name']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Movie title is Required!"
                ]
                );
        }
        if(!isset($params['author']) || empty($params['author']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Movie author is Required!"
                ]
                );
        }
        if(!isset($params['genre']) || empty($params['genre']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Genre is Required!"
                ]
                );
        }
        if(!isset($params['id']) || empty($params['id']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Id  is Required!"
                ]
                );
        }
        $id = $params['id'];
        $anime_title = $params['movie_name'];
        $manga_authors = $params['author'];
        $genre = $params['genre'];

        $update = "UPDATE $this->TableName 
        SET movie_name = '$movie_name', author = '$author', email = '$genre' 
        where id='$id'";

         $isupdated = $this->conn->query($update);

        if($isupdated)
        {
            return json_encode(
                [
                    "code" => 101,
                    "message" => "Movie_name Successfully Updated!"
                ]
                );
        }else{
            return json_encode(
                [
                    "code" => 101,
                    "message" => $this->db_error(),
                ]
                ); 
        }
    }
    public function delete($params)
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            return json_encode(
                [
                    "code" => 404,
                    "message" => "POST method is only allowed!"
                ]
                );
        }
     
        if(!isset($params['id']) || empty($params['id']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Id  is Required!"
                ]
                );
        }
        $id = $params['id'];

        $delete = "DELETE FROM $this->TableName 
        where id='$id'";

         $isdeleted = $this->conn->query($delete);

        if($isdeleted)
        {
            return json_encode(
                [
                    "code" => 101,
                    "message" => "Movie_name Successfully Deleted!"
                ]
                );
        }else{
            return json_encode(
                [
                    "code" => 101,
                    "message" => $this->db_error(),
                ]
                ); 
        }
    }
    }
   


?>