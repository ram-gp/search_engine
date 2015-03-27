<?php

class metaModel {
	public $Connection = '';
	public $ModelName = 'meta_details';
    public $db = '';
	public function __Construct(){
			$this->Connection = mysql_connect('localhost','root', '') or die("Unable to connect to MySQL");;
            if (!$this->Connection) {
                echo "Unable to connect to DB: " . mysql_error();
                exit;
            }

            if (!mysql_select_db("search_engine")) {
                echo "Unable to select search_engine: " . mysql_error();
                exit;
            }
            
            
            
	}
	public function updateMetaDetails($data){
		$update_data = array();
		
        $condition ='';
		$action = 'INSERT';
        foreach($data as $field => $value)
		{	
			if ($field != 'id'){
				$update_data[] = $field .'= "'.$value .'"';
			}else{
				$condition = ' where id = '.$value;
                $action = 'UPDATE';    
            }    
		}
		
        $query = $action.' meta_details SET '.implode(',',$update_data) . $condition;
       
		$result = mysql_query($query);
        if (!$result) {
            echo "Could not successfully run query ($query) from DB: " . mysql_error();
            exit;
        }
        
		return $result;
	}
	public function findSite($siteUrl){
        $sql = 'Select id from meta_details where site_url = "'.$siteUrl.'"';

        $result = mysql_query($sql);

        if (!$result) {
            echo "Could not successfully run query ($sql) from DB: " . mysql_error();
            exit;
        }
            
        if (mysql_num_rows($result) == 0) {
            return false;
        }
        else{
            $data = mysql_fetch_assoc($result);
            return $data;
        }
	}
	public function searchEngine($keywords){
        $sql = "Select site_url,meta_keyword from meta_details ";

        $result = mysql_query($sql);

        if (!$result) {
            echo "Could not successfully run query ($sql) from DB: " . mysql_error();
            exit;
        }
            
        if (mysql_num_rows($result) == 0) {
            return false;
        }
        else{
            
            while ($data = mysql_fetch_assoc($result)){
                $meta_keyword = explode(',',strtolower($data['meta_keyword']));
                if (in_array($keywords,$meta_keyword)){
                    return $data;
                }
                
            }
            
            return false;
        }
	
	}
}