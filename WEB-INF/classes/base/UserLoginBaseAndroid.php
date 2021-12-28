<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class UserLoginBaseAndroid extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function UserLoginBaseAndroid()
	{
      $this->Entity(); 
    }
	
	function selectMatchUser($usr,$email){      
	  $str = "SELECT USER_LOGIN_ID FROM user_login WHERE USER_NAMA='".$usr."' OR EMAIL='".$email."'";
	  return $this->select($str);
    }
	function selectByIdPassword($id_usr,$passwd){
      /** YOU CAN INSERT/CHANGE CODES IN THIS SECTION **/
	  //$passwd = md5($passwd."REYZA");
      
	  $str = "SELECT USER_LOGIN_ID, A.USER_GROUP_ID, A.TEKNISI_ID, A.MIROR_ID, USER_NAMA, 
               USER_PASS, A.NAMA, ALAMAT, EMAIL, TELEPON, UNIT_UPJ, A.LOG_ONLINE
            FROM user_login A, user_group B WHERE A.USER_GROUP_ID = B.USER_GROUP_ID AND USER_NAMA='".$id_usr."' AND USER_PASS='".$passwd."'";
	  return $this->select($str);
	  echo $str;
	  
    }
  } 
?>