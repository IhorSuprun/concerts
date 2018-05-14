<?php

class Model_Concerts extends Model {

    protected $concerts_table = 'concerts';
    protected $orders_table = 'orders';
    
    public function __construct() {
        parent::__construct();
        //require_once 'app/config/db.php';
        $this->dbConnection = mysqli_connect("localhost", 'root', 'root', 'bst_concerts');
        //$this->db = new PDO('mysql:host='.$host.';dbname='.$db, $user, $password);
    }
    
    public function get_all_concerts() {
	$query = 'select * from '.$this->concerts_table.";";
        $queryResult = $this->dbConnection->query($query);
	if ($queryResult) {
	    $allConcerts = $queryResult->fetch_all(MYSQLI_ASSOC);
	    return $allConcerts;
	}
	return false;
    }

    public function get_one_concert($id) {
        $query = 'select * from '.$this->concerts_table.' where id='.$id.";";
        $queryResult = $this->dbConnection->query($query);
	if ($queryResult) {
	    $oneConcert = $queryResult->fetch_array(MYSQLI_ASSOC);
	    return $oneConcert;
	}
	return false;
    }
    
    public function get_all_orders() {
	
    }

    public function insert_concert($image, $date_time, $price, $description) {
	$query = 'insert into '.$this->concerts_table.' (image, date, price, description) values(:image, :date,:price,:desc)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':date', $date_time);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':desc', $description);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete_concert($id) {
	$query = 'delete from '.$this->concerts_table.' where id='.$id;
        $stmt = $this->db->prepare($query);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update_concert($id, $date_time, $price, $description) {
	$query = 'update '.$this->concerts_table.' set date=:date, price=:price, description=:desc where id=:id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':date', $date_time);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':desc', $description);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function insert_order($name, $phone, $concert_id, $count_of_tickets) {
	$query = "insert into ".$this->orders_table." (name, phone, concert_id, count_of_tickets)"
                . " values('".$name."', '".$phone."', '".$concert_id."','".$count_of_tickets."');";
        //var_dump($query);
        $queryResult = $this->dbConnection->query($query);
        var_dump($query);
	if ($queryResult) {
	    return true;
	}
	return false;
    }

    public function change_order_status($id) {
	
    }

}