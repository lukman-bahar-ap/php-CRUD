<? 
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: Users.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Entity-base class for tabel Users implementation
***************************************************************************************************** */

  /***
  * Entity-class untuk mengimplementasikan tabel users.
  * 
  * @author M Reza Faisal
  * @generated by Entity Generator 5.8.3
  * @generated on 21-Apr-2005,06:36
  ***/
  include_once("../WEB-INF/classes/base/UsersBase.php");

  class Users extends UsersBase{ 
    var $query;

    /************************** <STANDARD METHODS> **************************************/
    /**
    * Class constructor.
    * @author M Reza Faisal
    **/
    function Users(){
      /** !!DO NOT REMOVE/CHANGE CODES IN THIS SECTION!! **/
      $this->UsersBase(); //execute Entity constructor
      /** YOU CAN INSERT/CHANGE CODES IN THIS SECTION **/				
			
	
    }

    /************************** </STANDARD METHODS> **********************************/

    /************************** <ADDITIONAL METHODS> *********************************/
	function selectById($id_usr){
      /** YOU CAN INSERT/CHANGE CODES IN THIS SECTION **/
	  //$passwd = md5($passwd."REYZA");
      
	  $str = "SELECT USER_LOGIN_ID, A.USER_GROUP_ID, USER_NAMA, 
               USER_PASS, A.NAMA, ALAMAT, EMAIL, TELEPON, UNIT_UPJ, A.LOG_ONLINE
            FROM user_login A, user_group B WHERE A.USER_GROUP_ID = B.USER_GROUP_ID AND USER_NAMA='".$id_usr."'";
	  return $this->select($str);
	 // echo $str;
	  
    }
	
	function selectByIdPassword($id_usr,$passwd){
      /** YOU CAN INSERT/CHANGE CODES IN THIS SECTION **/
	  //$passwd = md5($passwd."REYZA");
      
	  $str = "SELECT USER_LOGIN_ID, A.USER_GROUP_ID, USER_NAMA, 
               USER_PASS, A.NAMA, ALAMAT, EMAIL, TELEPON, UNIT_UPJ, A.LOG_ONLINE
            FROM user_login A, user_group B WHERE A.USER_GROUP_ID = B.USER_GROUP_ID AND USER_NAMA='".$id_usr."' AND USER_PASS='".$passwd."'";
	  return $this->select($str);
	 // echo $str;
	  
    }	
	
	function updatePassword(){
      if(!$this->canUpdate())
        showMessageDlg("Data Users tidak dapat diupdate",true);
      else{
        $this->setField("USER_PASS", md5($this->getField("USER_PASS")));
		$str = "UPDATE user_login 
                SET 
                  USER_PASS = '".$this->getField("USER_PASS")."'
                WHERE 
                  USER_NAMA = '".$this->getField("USER_NAMA")."'"; 
        return $this->execQuery($str);
      }
    }
	
	function updateStatusOnline($ol){
      if(!$this->canUpdate())
        showMessageDlg("Data Users tidak dapat diupdate",true);
      else{
		$str = "UPDATE user_login 
                SET 
                  LOG_ONLINE = '".$ol."'
                WHERE 
                  USER_NAMA = '".$this->getField("USER_NAMA")."'"; 
        return $this->execQuery($str);
      }
    }
	
	function selectUserGroup($paramsArray=array(),$limit=-1,$from=-1,$varStatement=""){
      $str = "SELECT u.USER_NAMA AS USER_NAMA,
	  				 u.NAMA AS NAMA,
					 u.EMAIL AS EMAIL,
					 ug.NAMA as USERGROUP
	  		  FROM user_login u, user_group ug
			  WHERE USER_LOGIN IS NOT NULL 
					AND ug.USER_GROUP_ID = u.USER_GROUP_ID "; 
      while(list($key,$val)=each($paramsArray)){
        $str .= " AND $key = '$val' ";
      }
      $str .= $varStatement." ORDER BY u.USER_LOGIN";
	  $this->query = $str;
      return $this->selectLimit($str,$limit,$from); 
    }
	
	function searchUserGroup($paramsArray=array(),$limit=-1,$from=-1,$varStatement=""){
      $str = "SELECT u.USER_NAMA AS USER_NAMA,
	  				 u.NAMA AS NAMA,
					 u.EMAIL AS EMAIL,
					 ug.NAMA as USERGROUP
			  FROM user_login u, user_group ug
			  WHERE USER_LOGIN IS NOT NULL 
					AND ug.USER_GROUP_ID = u.USER_GROUP_ID "; 
      while(list($key,$val)=each($paramsArray)){
        $str .= " AND $key LIKE '%$val%' ";
      }
      $str .= $varStatement." ORDER BY u.USER_LOGIN";
	  $this->query = $str;
      return $this->selectLimit($str,$limit,$from); 
    }
	
	function getSearchCountByParams($paramsArray=array(),$varStatement=""){
      $str = "SELECT COUNT(USER_NAMA) AS ROWCOUNT FROM user_login WHERE USER_LOGIN IS NOT NULL ".$varStatement; 
      while(list($key,$val)=each($paramsArray)){
        $str .= " AND $key LIKE '%$val%' ";
      }
      $this->select($str); 
      if($this->firstRow()) 
        return $this->getField("ROWCOUNT"); 
      else 
         return 0; 
    }

    /************************** </ADDITIONAL METHODS> *******************************/
  } //end of class Users
?>