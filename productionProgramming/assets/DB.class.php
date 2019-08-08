<?php

//this file contains constants for database connections
//see the incoming parameters for dbConnect for example
require_once("const.php");

class DB {

  //Normally don't touch these.
  //Instead, change them in const.php (required above)        
  private $_dbConn = null;
  private $_server = "localhost";
  private $_user = "USER";
  private $_pass = "PASSWORD";
  private $_db = "DATABASE";

  public function __construct($server = MSERVER,
                            $user = MUSER,
                            $pass = MPASS,
                            $db = MDB) {

    $this->dbConnect($server,$user,$pass,$db);

  } //end constructor

  public function getConnStatus() {
    $status = false;
    if ($this->_dbConn) {
      $status = true;
    }
    return $status;
  } //end function getConnStatus

  public function logError($errorMesg = "Error",$errorDetails = null) {
    error_log($errorMesg);
    if (!is_null($errorDetails)) {  
      if (is_array($errorDetails)) {
        foreach ($errorDetails as $error) {
          error_log($error);
        }
      }
      else {
        error_log($errorDetails);
      }
    } //end if !is_null
 }

  public function dbEsc($term) {
    if (!$this->getConnStatus()) {
      $this->dbConnect();
    }
    if (is_array($term)) {
      $tempArray = array();
      foreach ($term as $key => $value) {
        $tempArray[$key] = $this->_dbConn->real_escape_string($value);
      }
      return $tempArray;
    } else { //it's not an array so just send it back
        return $this->_dbConn->real_escape_string($term);
    }

  } //end function dbEsc

  public function dbConnect($server = MSERVER,
                            $user = MUSER,
                            $pass = MPASS,
                            $db = MDB) {

    $this->_server = $server;
    $this->_pass = $pass;
    $this->_user = $user;
    $this->_db = $db;

    $link = new mysqli($this->_server,$this->_user,$this->_pass);
    if ($link->connect_errno) {
        $this->logError("Cannot connect to db at this time. ",$link->connect_error);
        return false;
        exit;
    }
    $dbSel = $link->select_db($this->_db);
    if (!$dbSel) {
        $this->logError("Cannot select db: ",$link->error);
        return false;
        exit;
    }
    $this->_dbConn = $link;
  } //end function DBConnect()

  public function returnDB($server = MSERVER,
                            $user = MUSER,
                            $pass = MPASS,
                            $db = MDB) {

    $this->_server = $server;
    $this->_pass = $pass;
    $this->_user = $user;
    $this->_db = $db;

    $link = new mysqli($this->_server,$this->_user,$this->_pass);
    if ($link->connect_errno) {
        $this->logError("Cannot connect to db at this time. ",$link->connect_error);
        return false;
        exit;
    }
    $dbSel = $link->select_db($this->_db);
    if (!$dbSel) {
        $this->logError("Cannot select db: ",$link->error);
        return false;
        exit;
    }
    return $link;
  } //end function returnDB

  public function getCaller() {
    $backtrace = debug_backtrace();
    return $backtrace[1]['function'];
  } //end function getCaller

  public function dbCall($sql,$resultType = null) {
    if (!$this->getConnStatus()) {
      $this->dbConnect();
    }

    $result = $this->_dbConn->query($sql);
    if (!$result) {
      $caller = $this->getCaller();
      $details = array('caller' => $caller,'error' => $this->_dbConn->error);
      $this->logError("Error with database call",$details);
      return false;
    } //end if not result

    if (preg_match('/^INSERT/i',$sql)) {
      return $this->_dbConn->insert_id;
    } else if (preg_match('/^UPDATE/i',$sql)) {
      return $this->_dbConn->affected_rows;
    } else if (preg_match('/^DELETE/i',$sql)) {
      return $this->_dbConn->affected_rows;
    } else {
      $returnArray = array();
      switch ($resultType) {
        default:
        case "assoc":
          while ($resultArray = $result->fetch_assoc()) {
            $returnArray[] = $resultArray;
          }
          return $returnArray;
          break;
      } //end switch for result type
    }
  } //end function dbCall()

} //end class DB
?>
