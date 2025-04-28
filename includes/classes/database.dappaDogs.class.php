<?php
class dappaDogs extends Database{
	
	public $href=""; 
	public $dynamic_content=array(); 
	public $query_data=array(); 
	public $query_data_value=array(); 
	
		
	
	public function show_size($size){		
		if(intval($size) == 0)
		 	return ("&nbsp;");
		else{
			if($size == 1)
				return "Small";
			else if($size == 2)
				return "Medium";	
			else if($size == 3)	
				return "Large";
			else 
				return "XLarge";	
			
		}		
	}
	
	public function show_core($parent){		
		if(intval($parent) == 0)
		 	return ("&nbsp;");
		else{
			$sql="select service_name from service where id=$parent limit 1";	
			$result=$this->fetch_all_array($sql);
			return ($result[0]['service_name']);		
		}		
	}
	
	public function salon_name($id){		
		if(intval($id) == 0)
		 	return ("&nbsp;");
		else{
			$sql="select salon_name from salons where id=$id limit 1";	
			$result=$this->fetch_all_array($sql);
			return ($result[0]['salon_name']);		
		}		
	}
	
	public function service_name($service){		
		if(intval($service) == 0)
		 	return ("&nbsp;");
		else{
			$sql="select service_name from service where id=$service limit 1";	
			$result=$this->fetch_all_array($sql);
			return ($result[0]['service_name']);		
		}		
	}
	
	public function spa_treatments($spa_ids){		
		if(trim($spa_ids) == NULL)
		 	return ("&nbsp;");
		else{
			$sql="select spa_service_name from spa_service where id IN($spa_ids)";	
			$result=$this->fetch_all_array($sql);
			$spa_treatment_names="";
			
			for($service=0; $service < count($result); $service++ ){
				$spa_treatment_names .=$result[$service]['spa_service_name']. ", ";					
			}			
			return (substr($spa_treatment_names,0,-2));		
		}		
	}
		
	
	
	
	public function staff_name($id){		
		if(intval($id) == 0)
		 	return ("&nbsp;");
		else{
			$sql="select staff_name from staffs where id=$id limit 1";	
			$result=$this->fetch_all_array($sql);
			return ($result[0]['staff_name']);		
		}		
	}
	
	public function show_grooming_type($id){		
		if(intval($id) == 0)
		 	return ("&nbsp;");
		else{
			$sql="select name from grooming where id=$id limit 1";	
			$result=$this->fetch_all_array($sql);
			return ($result[0]['name']);		
		}		
	}
	
	public function his_own_salon($user_id,$trying_to_access_salon){		
		if(intval($user_id) == intval($trying_to_access_salon))
		 	return 1;
		else
			return 0;	
	}
	
	public function his_own_salon_staff($salon_id,$staff_id){
					
		$sql="select staff_id from staff_salon where salon_id=$salon_id limit 1";		
		$result=$this->fetch_all_array($sql);
					
		if(count($result) == 1)
		 	return 1;
		else
			return 0;	
	}
	
	
	
	
	
	public function already_exist_mobile($tbl_name="",$field1="",$data1="",$field2="",$data2="",$field3="",$data3="",$field4="",$data4=""){
		$sql="select $field1 from $tbl_name where 1";
		
		if(trim($field1) != NULL)
			$sql .=" and $field1='". $this->escape($data1) ."'";
		
		if(trim($field2) != NULL)
			$sql .=" and $field2='". $this->escape($data2) ."'";
			
		
		if(trim($field3) != NULL)
			$sql .=" and $field3='". $this->escape($data3) ."'";	
			
			
		if(trim($field4) != NULL)
			$sql .=" and $field4='". $this->escape($data4)."'";	
			
					
			
		 $result=$this->fetch_all_array($sql);
		 
		 return (count($result));
	}
	
	
	public function already_exist_mobile_update($tbl_name="",$primary_key,$primary_key_value,$field1="",$data1="",$field2="",$data2="",$field3="",$data3="",$field4="",$data4=""){
		$sql="select $field1 from $tbl_name where 1";
		
		if(trim($field1) != NULL)
			$sql .=" and $field1='". $this->escape($data1) ."'";
		
		if(trim($field2) != NULL)
			$sql .=" and $field2='". $this->escape($data2) ."'";
			
		
		if(trim($field3) != NULL)
			$sql .=" and $field3='". $this->escape($data3) ."'";	
			
			
		if(trim($field4) != NULL)
			$sql .=" and $field4='". $this->escape($data4) ."'";	
			
		$sql .=" and $primary_key !='". $this->escape($primary_key_value) ."'";					
			
		 $result=$this->fetch_all_array($sql);
		 
		 return (count($result));
	}
	
	public function static_page_content($page_name,$query_string){
		
		$sql="select link_name,title,description,keyword,file_data,page_heading from static_pages where page_name='" . $this->escape($page_name) . "'";
		
		$result=$this->fetch_all_array($sql);
		
		if(count($result) > 0){
			$this->dynamic_content['page_title']=$result[0]['title'];
			$this->dynamic_content['page_keywords']=$result[0]['keyword'];
			$this->dynamic_content['page_description']=$result[0]['description'];
			$this->dynamic_content['link_name']=$result[0]['link_name'];			
			$this->dynamic_content['page_heading']=$result[0]['page_heading'];
			$this->dynamic_content['file_data']=$result[0]['file_data'];
			
		}else if($page_name=="custom-page.php"){
			
	
			$sql_global="select * from customer_static_pages  where seo_link='" . $this->escape($query_string) . "' limit 1";
			
			$result_global=$this->fetch_all_array($sql_global);
			
			
			$this->dynamic_content['page_title']=$result_global[0]['title'];
			$this->dynamic_content['page_keywords']=$result_global[0]['keyword'];
			$this->dynamic_content['page_description']=$result_global[0]['description'];
			$this->dynamic_content['file_data']=$result_global[0]['page_content_data'];
			
			
		}else{
			$sql_global="select option_name,option_value from tbl_options where admin_id=1 and (option_name='global_meta_title' or option_name='global_meta_keywords'  or option_name='global_meta_description')";
			 
			$result_global=$this->fetch_all_array($sql_global);
			
			
			if(count($result_global) > 0){
				for($i=0; $i <count($result_global); $i++){
					$$result_global[$i]['option_name']=trim($result_global[$i]['option_value']);
				}
			}
			
			$this->dynamic_content['page_title']=$global_meta_title;
			$this->dynamic_content['page_keywords']=$global_meta_keywords;
			$this->dynamic_content['page_description']=$global_meta_description;
		}	
	
		return ($this->dynamic_content);
	}
	
	
}
?>