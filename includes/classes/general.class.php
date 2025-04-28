<?php
class General{
	private $_redirect_to="";
	private $_A_to_Z="";
	private $_A="65";
	private $_Z="91";
	
	public $seo_link ="";
	public $month ="";
	public $show ="";
	
	protected $display ="";
	
	//******************* Color code and height for admin section ******************//
	public $color1="#f5f7fa";
	public $color2="#dedede";
	
	public $deep_bg="#d8d8d8";
	public $lt_bg="#f4f4f4";
	
	
	
	
	public $abc="#f9f9f9";
	
	
	public $hgt="93%";
	//*****************************************************************************//
	public $user_color1="#e4eed8";
	public $user_color2="#cedabe";
	
	

	
	//*********************  Global variables *************************************//
	
	public $admin_email_id="";
	public $no_reply="";
	
	public $site_title=""; 
	public $site_url="";
	public $admin_url="";
	public $date_format=""; 
	public $time_format=""; 
	public $admin_recoed_per_page=""; 
	
	
	public $security_questions=array(); 
	
	public $physical_endurances=array(); 
	
	public function A_to_Z($page_name,$class_name="text_numbering"){
		$this->_A_to_Z = "<a class=\"" . $class_name . "\" href=\"" .$page_name. "?key=\">ALL</a> <font class=\"" . $class_name . "\">|</font>";
		
		for($i=$this->_A; $i < $this->_Z; $i++){
			if($i == $this->_Z - 1){
				$this->_A_to_Z .= " <a class=\"" . $class_name . "\" href=\"" .$page_name. "?key=" .chr($i + 32). "\">" . chr($i) ."</a>";
			}else{
				$this->_A_to_Z .= " <a class=\"" . $class_name . "\" href=\"" .$page_name. "?key=" .chr($i +32). "\">" . chr($i) ."</a> <font class=\"" . $class_name . "\"> |</font>";
			}	
		}
		
		return ($this->_A_to_Z);
	
	}
	
	
	
	
	public function phone_no_type($type){
		$this->show	="";
		if((int) $type ==1)
			$this->show	="Cell phone";
		else if((int) $type ==2)
			$this->show	="Sat phone";
		else if((int) $type ==3)
			$this->show	="Office phone";
		else	
			$this->show	="Home phone";	
		
		
		return ($this->show);
	}
	
	public function payment_method($pm){
		$cc_type="";
		if($pm=="1")
			$cc_type="MasterCard";
		else if($pm=="2")
			$cc_type="Visa";
	   else if($pm=="3")
			$cc_type="American Express";	
		else
			$cc_type="Discover";
		return ($cc_type);	
	}
	
	public function order_status($status){
		$show="";
		if($status=="1")
			$show="Shipped";
		else if($status=="2")
			$show="Cancelled";
		else
			$show="Processing";
		return ($show);	
	}
	
	
	public function display_date($date,$date_format){
		$this->show	="";
		/*  date_format
		1 - May 26, 2011
		2 - 2011/05/26 
		3 - 05/26/2011 
		4 -  26/05/2011 */
		
		
		if(trim($date) == NULL || trim($date)=="0000-00-00 00:00:00")
			return ($this->show);
		
		if(trim($date_format) != NULL )
			$this->date_format = $date_format;
			
		
		if(trim($this->date_format) != NULL){
			if((int) $this->date_format ==1)
				$this->show	=date("M d, Y",strtotime($date));
				
			else if((int) $this->date_format ==2)
				$this->show	=date("Y/m/d",strtotime($date));

			else if((int) $this->date_format ==3){//******* used
				$date_disp=array();
				$date_disp=@explode("-",$date);
				$this->show	=$date_disp[1]."-".$date_disp[2]."-".$date_disp[0];				
			}

			else if((int) $this->date_format ==4)
				$this->show	=date("m/d/Y",strtotime($date));
			else if((int)$this->date_format ==6)
				$this->show	=date("Y-m-d",strtotime($date));	
			else if((int) $this->date_format ==7){//**** used to display from database
				$date_disp=array();
				$date_disp=@explode("-",$date);
				$this->show	=$date_disp[1]."-".$date_disp[2]."-".$date_disp[0];
			}
				
			else if((int) $this->date_format ==8)//******* used
				$this->show	=date("m-d-Y H:i:s",strtotime($date));
			else if((int) $this->date_format ==9)//******* used
				$this->show	=date("l",strtotime($date));	
			else if((int) $this->date_format ==10)//******* used
				$this->show	=date("jS M Y",strtotime($date));	
			else if((int) $this->date_format ==11){//**** used to store into database
				$date_disp=array();
				$date_disp=@explode("-",$date);
				$this->show	=$date_disp[2]."-".$date_disp[0]."-".$date_disp[1];
			}								
			else 	
				$this->show	=$date;
		}
		return ($this->show);
	}
	
	
	public function display_time($date,$time_format){
		/*  time_format
		1 - 6:04 am
		2 - 06:04 am
		3 - 6:15 AM 
		4 -  06:15 AM  
		5 - 23:15  */
		$this->show	="";
		
		if(trim($date) != NULL){
			if((int) $date_format ==1)
				$this->show	=date("g:i a",strtotime($date));
				
			else if((int) $date_format ==2)
				$this->show	=date("h:i a",strtotime($date));

			else if((int) $date_format ==3)
				$this->show	=date("g:i A",strtotime($date));

			else if((int) $date_format ==4)
				$this->show	=date("h:i A",strtotime($date));
			else if((int) $date_format ==5)
				$this->show	=date("H:i",strtotime($date));	
			else 	
				$this->show	="";
		}
		return ($this->show);
	}

	
	
	
	public function show_gender($gender){
		$this->display="";
		
		if($gender =='c')
			$this->display="Couple";
		else if($gender == 'm')
			$this->display="Man";	
		else
			$this->display="Woman";
		
		return ($this->display);
	}
	
	public function show_status($status){
		$this->display="";
		
		if($status ==1)
			$this->display="Active";
		else
			$this->display="Inactive";
		
		return ($this->display);
	}
	
	
	public function date_convert($date,$flag=0){
		$this->display="";
		
		
		if($flag ==1){//***  mm/dd/yyyy to yyyy-mm-dd
			list($mm,$dd,$yy)=@explode("-",$date);
			$this->display=$yy . "-". $mm . "-". $dd;
		}else if($flag ==2){//***   yyyy-mm-dd to mm/dd/yyyy
			
			list($yy,$mm,$dd)=@explode("-",trim($date));
			$this->display=$mm . "/". $dd . "/". $yy;
			
		}else{
			$this->display="";
		}
		
		return ($this->display);
	}
	


	public function makeclickablelinks($text,$show_text="Click here"){
		$this->show = html_entity_decode($text);
		$this->show = " ".$this->show;
		$this->show = @eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
				'<a href="\\1" class=htext style=font-weight:normal  target=_blank>' . $show_text.' </a>', $this->show);
		$this->show = @eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
				'<a href="\\1" class=htext style=font-weight:normal target=_blank>' . $show_text.'</a>', $this->show);
		$this->show = @eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
				'\\1<a href="http://\\2" class=htext style=font-weight:normal  target=_blank>' . $show_text.'</a>', $this->show);
		$this->show = @eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',
									'<a href="mailto:\\1" class=htext style=font-weight:normal  target=_blank>' . $show_text.'</a>', $this->show);
		return $this->show;
	}
	
	
	public function month_long_name($mon){
		$month="";
		switch($mon){
			case 1:
			case 01:
			  $month="January";
			  break;
			case 2:
			case 02:
			  $month="February";
			  break;
			case 3:
			case 03:
			  $month="March";
			  break;
			case 4:
			case 04:
			  $month="April";
			  break;
			case 5:
			case 05:
			  $month="May";
			  break;
			case 6:
			case 06:
			  $month="June";
			  break;
			case 7:
			case 07:
			  $month="July";
			  break;
			case 8:
			case 08:
			  $month="August";
			  break;
			case 9:
			case 09:
			  $month="September";
			  break;
			case 10:
			  $month="October";
			  break;
			case 11:
			 $month="November";
			 break;
			case 12:
			 $month="December";
			 break;
		}
  	return($month);
	}
	
	public function user_name($user_display_name,$user_first_name,$user_last_name){
		
		if(trim($user_display_name) != NULL)
			return($user_display_name);	
		else
			return($user_first_name ." ". $user_last_name);	
	
	}
	
	public function random_num($n=5){
		return rand(0, pow(10, $n));
	}
	
	public function document_rating($document_id){
		$this->show ="";
		$result=mysql_query("select SUM(rate) as rate,count(*) as total from document_rating where document_id='" . $document_id. "'");
		
		if(mysql_num_rows($result) > 0){
			$row=mysql_fetch_object($result);
			$total_rate=ceil($row->rate / $row->total);
			
			if($total_rate == 0)
				$this->show ="Not Yet Rated";
			else{
				for($i=1; $i<=$total_rate; $i++){
					$this->show .='<img src="images/full_rating.gif" alt="" />';	
				}
				for($i=$total_rate +1; $i<=5; $i++){
					$this->show .='<img src="images/no_rating.gif" alt="" />';	
				}
			
			}	
		
		}else{
			$this->show ="Not Yet Rated";
		
		}
		
		return ($this->show);
	}
	
	
	public function country_name($id){
		$this->show ="";
		$this->show=mysql_result(mysql_query("select name from countries where id='" . $id . "'"),0,0);
		return ($this->show);
	}

	
	
	public function create_seo_link($text){
		$text=trim($text);	
		$letters = array('�', '�', '"', '�', '�', '\'', '�', '�', '�', '�', '&', '�', '>', '<', '$', '/');
		$text=str_replace($letters," ",$text);
		$text=str_replace("&","and",$text);
		$text=strtolower(str_replace(" ","-",$text));
		return ($text);
	}
	
	public function remove_space_by_hypen($text){
		$letters = array('�', '�', '"', '�', '�', '\'', '�', '�', '�', '�', '&', '�', '>', '<', '$', '/');
		$text=str_replace($letters," ",$text);
		$text=str_replace("&","and",$text);
		$text=strtolower(str_replace(" ","-",$text));
		return ($text);
	}
	
	
	
	public function genTicketString(){
    	$length = 7;
   		$characters = "123456123456789ABCDEFGHIJKLMNPQ45612RSTUVWXYZ789ABCDEFGHIJKLMNPQRSTUVWXYZ";
    	$string="";
		
		for ($p = 0; $p < $length; $p++) {
        	$string .= $characters[mt_rand(0, strlen($characters)-1)];
    	}
    	return $string;
	}
	
	
		public function A_to_Z_T($page_name,$fid){
		$class_name="text_numbering";
		$this->_A_to_Z = "<a class=\"" . $class_name . "\" href=\"" .$page_name. "?forum_id=".$fid."&key=\">ALL</a> <font class=\"" . $class_name . "\">|</font>";
		
		for($i=$this->_A; $i < $this->_Z; $i++){
			if($i == $this->_Z - 1){
				$this->_A_to_Z .= " <a class=\"" . $class_name . "\" href=\"" .$page_name. "?forum_id=".$fid."&key=" .chr($i + 32). "\">" . chr($i) ."</a>";
			}else{
				$this->_A_to_Z .= " <a class=\"" . $class_name . "\" href=\"" .$page_name. "?forum_id=".$fid."&key=" .chr($i +32). "\">" . chr($i) ."</a> <font class=\"" . $class_name . "\"> |</font>";
			}	
		}
		
		return ($this->_A_to_Z);
	
	}
	public function A_to_Z_Tp($page_name,$tid){
		$class_name="text_numbering";
		$this->_A_to_Z = "<a class=\"" . $class_name . "\" href=\"" .$page_name. "?topic_id=".$tid."&key=\">ALL</a> <font class=\"" . $class_name . "\">|</font>";
		
		for($i=$this->_A; $i < $this->_Z; $i++){
			if($i == $this->_Z - 1){
				$this->_A_to_Z .= " <a class=\"" . $class_name . "\" href=\"" .$page_name. "?topic_id=".$tid."&key=" .chr($i + 32). "\">" . chr($i) ."</a>";
			}else{
				$this->_A_to_Z .= " <a class=\"" . $class_name . "\" href=\"" .$page_name. "?topic_id=".$tid."&key=" .chr($i +32). "\">" . chr($i) ."</a> <font class=\"" . $class_name . "\"> |</font>";
			}	
		}
		
		return ($this->_A_to_Z);
	
	}
	
	public function A_to_Z_fp($page_name,$tid){
		$class_name="text_numbering";
		$this->_A_to_Z = "<a class=\"" . $class_name . "\" href=\"" .$page_name. "?forum_id=".$tid."&key=\">ALL</a> <font class=\"" . $class_name . "\">|</font>";
		
		for($i=$this->_A; $i < $this->_Z; $i++){
			if($i == $this->_Z - 1){
				$this->_A_to_Z .= " <a class=\"" . $class_name . "\" href=\"" .$page_name. "?forum_id=".$tid."&key=" .chr($i + 32). "\">" . chr($i) ."</a>";
			}else{
				$this->_A_to_Z .= " <a class=\"" . $class_name . "\" href=\"" .$page_name. "?forum_id=".$tid."&key=" .chr($i +32). "\">" . chr($i) ."</a> <font class=\"" . $class_name . "\"> |</font>";
			}	
		}
		
		return ($this->_A_to_Z);
	
	}

	
	public function header_redirect($location){
		$this->_redirect_to=$location;
		header("location:".$this->_redirect_to);
		exit();
	}
	
		 public function how_many_days_ago($date2,$date1) {
	  	$diff = abs(strtotime($date2) - strtotime($date1)); 

			$years   = floor($diff / (365*60*60*24)); 
			$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
			$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

			$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
			$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
			$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 
			
			
#printf("%d years, %d months, %d days, %d hours, %d minuts\n, %d seconds\n", $years, $months, $days, $hours, $minuts, $seconds); 
		
		if($years) {
		
			  echo "&nbsp;".$years." year";
			 if($years > 1) {
				 echo "s";
				 $months=0;$days=0;$hours=0;$minuts=0;$seconds=0;	 
			 }
			  $months=0;$days=0;$hours=0;$minuts=0;$seconds=0;
			}
			
			if($months) {

			echo "&nbsp;".$months." month";
			 if($months > 1) {
				 echo "s";
			 }
			$days=0;$hours=0;$minuts=0;$seconds=0;
			}
			
			 if($days) {
			
			 		 
			 echo "&nbsp;".$days." day" ;
			 if($days > 1) {
				 echo "s";
			 }
			 $hours=0;$minuts=0;$seconds=0;
			 }
			 
			 if($hours) {
			
			 	 
				echo "&nbsp;".$hours." hour";
			 if($hours > 1) {
				 echo "s";
			 }
			 $minuts=0;$seconds=0;
			 }
			 
			 if($minuts) {
			
				echo "&nbsp;".$minuts." minut";
			 if($minuts > 1) {
				 echo "s";
			 }
			 $seconds=0;
			 }
			 
			 if($seconds) {
			  
				echo "&nbsp;".$seconds." second";
			 if($seconds > 1) {
				 echo "s";
			 }	
			  }
			echo "&nbsp;ago"; 
  }
	
	
	
} 
?>