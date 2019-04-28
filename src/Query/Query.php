<?php

namespace Rabbi\Query;


use Rabbi\Db\Dbh;
use PDO;

class Query extends Dbh
{
    public function login_check($data){
        $sql = "select * from user where `username` = :username and `password` = :password";
        $query = $this->dbh->prepare($sql);
        $query->bindParam("username",$data['username']);
        $query->bindParam("password",$data['password']);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function userlist($data){
        $sql = "select * from user where `id` != :id";
        $query = $this->dbh->prepare($sql);
        $query->bindParam('id',$data);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update_last_activity($data,$time){
        $sql = "update `login_details` set `last_activity` = :times where `login_details`.`id` = :id";
        $query = $this->dbh->prepare($sql);
        $query->bindParam("id",$data);
        $query->bindParam("times",$time);
        return $query->execute();
    }
    public function activity_create($user_id,$time){
        $sql = "insert into `login_details` (`user_id`,`last_activity`)value (:user_id,:times )";
        $query = $this->dbh->prepare($sql);
        $query->bindParam('user_id',$user_id);
        $query->bindParam('times',$time);
        $query->execute();
        return $this->dbh->lastInsertId();
    }

    public function user_activity($user_id){
        $sql = "SELECT * FROM `login_details` WHERE `user_id` = :user_id ORDER BY last_activity DESC LIMIT 1";
        $query = $this->dbh->prepare($sql);
        $query->bindParam('user_id',$user_id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function insert_chat($data){
        $sql = "insert into chat_message (`from_user_id`,`to_user_id`,`message`,`status`,`created_at`)value(:from_user_id,:to_user_id,:message,:status,CURRENT_TIMESTAMP )";
        $query = $this->dbh->prepare($sql);
        $query->bindParam('from_user_id',$data['from_user_id']);
        $query->bindParam('to_user_id',$data['to_user_id']);
        $query->bindParam('message',$data['message']);
        $query->bindParam('status',$data['status']);
        return $query->execute();
    }

    public function fetch_user_chat_history($from_user_id,$to_user_id){
        $sql = "select * from chat_message where (`from_user_id` = :from_user_id and `to_user_id` = :to_user_id) or (`from_user_id` = :to_user_id and `to_user_id` = :from_user_id) order by created_at ASC";
        $query = $this->dbh->prepare($sql);
        $query->bindParam('from_user_id',$from_user_id);
        $query->bindParam('to_user_id',$to_user_id);
        $query->execute();
        //$this->remove_unseen_message($from_user_id,$to_user_id);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_user_name($user_id){
        $sql = "select `username` from `user` where `id` = $user_id";
        $query = $this->dbh->prepare($sql);
        $query->execute();
        $username =  $query->fetch(PDO::FETCH_ASSOC);
        echo $username['username'];
    }

    public function count_unseen_message($form_user_id,$to_user_id){
        $sql = "select * from `chat_message` where `from_user_id`= $to_user_id and `to_user_id` = $form_user_id and `status` = 1";
        $query = $this->dbh->prepare($sql);
        $query->execute();
        return $query->rowCount();
    }

    public function remove_unseen_message($from_user_id,$to_user_id){
        $sql = "update `chat_message` set `status` = '0' WHERE `from_user_id` = $to_user_id and `to_user_id` = $from_user_id and `status` = '1'";
        $query = $this->dbh->prepare($sql);
        return $query->execute();
    }

}