<?php
  $months = ['Janvier', 'Février', 'Mars', 'Avril',' Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
  $days = ['Lundi', 'Mardi', 'Mercredi','Jeudi','Vendredi', 'Samedi', 'Dimanche'];

  function getmontante($mois,$annee)
  {
      global $BD;
      
      $requete = $BD->prepare('SELECT COALESCE(SUM(recette),0) as somme FROM mouvement WHERE operation IN (0,2)');
      $requete->execute(array());
      $elt = $requete->fetch();
      return $elt['somme'];
  }

  function getmontantd($mois,$annee)
  {
      global $BD;
      
      $requete = $BD->prepare('SELECT COALESCE(SUM(depense),0) as somme FROM mouvement WHERE operation IN (1,2) AND idannee=? AND MONTH(date)=? AND YEAR(date)=? 
      and idcaisse in (select id from caisse where idecole=?)');
      $requete->execute(array($_SESSION['annee'],$mois,$annee,$_SESSION["ecole"]));
      $elt = $requete->fetch();
      return $elt['somme'];
  }

  function getemprunts($mois,$annee)
  {
      global $BD;
      
      $requete = $BD->prepare('SELECT COUNT(*) as somme FROM empreint WHERE MONTH(datedebut)=? AND YEAR(datedebut)=? AND idlivre IN (select idlivre from livre_anne where idannee=?)
      and idlivre in (select id from livre where idcategorie in (select id from categorie where idecole=?) )');
      $requete->execute(array($mois,$annee,$_SESSION['annee'],$_SESSION["ecole"]));
      $elt = $requete->fetch();
      return $elt['somme'];
  }

  function getmalades($mois,$annee)
  {
      global $BD;
      
      $requete = $BD->prepare('SELECT COUNT(DISTINCT(idetudiant)) as somme FROM malades WHERE issupprimer=0 and MONTH(dateajout)=? AND YEAR(dateajout)=? 
      and idmedicament in (select id from medicament where idcategorie in (select id from categorie where idecole=?) )');
      $requete->execute(array($mois,$annee,$_SESSION["ecole"]));
      $elt = $requete->fetch();
      return $elt['somme'];
  }

  function _mime_content_type($filename) {
      $result = new finfo();

      return $result->file($filename, FILEINFO_MIME_TYPE);
  }
  function cmp($a, $b) {
      if ($a == $b) {
          return 0;
      }
      return ($a < $b) ? -1 : 1;
  }

  function  getAllSundays($startDate, $endDate){
    $sundays = array();
    while ($startDate <= $endDate) {
        if ($startDate->format('w') == 0) {
            $sundays[] = $startDate->format('Y-m-d');
        }
        $startDate->modify('+1 day');
    }
    return $sundays;
  }

  function checkPrivilege($page){
    global $BD;
      if($_SESSION['idpiscine']==0){
        return true;
      }
      $sql = $BD->prepare("SELECT * FROM privilege_role,utilisateur,privilege WHERE privilege_role.idprivilege = privilege.id AND privilege_role.idrole=utilisateur.idrole AND utilisateur.id= ? AND privilege.name=?");
      $sql->execute(array($_SESSION['idpiscine'], $page));
      $etat = $sql->fetch();
      if($sql->rowCount()>0)
        return true;
      else
        return false;
        //return true;
  }
  function checkPrivilegeModule($idmodule){
    global $BD;
      if($_SESSION['idpiscine']==0){
        return true;
      }
      $sql = $BD->prepare("SELECT * FROM privilege_role,utilisateur,privilege WHERE privilege_role.idprivilege = privilege.id AND privilege_role.idrole=utilisateur.idrole AND utilisateur.id= ? AND privilege.idmodule=?");
      $sql->execute(array($_SESSION['idpiscine'],$idmodule));
    //   echo("SELECT * FROM privilege_role,role_utilisateur,privilege WHERE privilege_role.idprivilege = privilege.id AND privilege_role.idrole=role_utilisateur.idrole AND role_utilisateur.idutilisateur='".$_SESSION['idpiscine']."' AND privilege.idmodule='".$idmodule."' ");
    // echo '<br>';
        $etat = $sql->fetch();
      if($sql->rowCount()>0)
        return true;
      else
        return false;
        //return true;
  }
  function cmppers($a, $b) {
    if ($a->ORDRE == $b->ORDRE) {
        return 0;
    }
    return ($a->ORDRE < $b->ORDRE) ? -1 : 1;
  }
  function getToken($length){
     $token = "";
     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
     $codeAlphabet .= "0123456789";
     $codeAlphabet .= "_";
     $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[rand(0, $max-1)];
    }

    return $token;
}
function pickerDateTimeToMysql($str){
    return date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $str)));
  }
  function pickerDateToMysql($str){
    return date('Y-m-d', strtotime(str_replace("/", "-", $str)));
  }
function has_prefix($string, $prefix) {
   return ((substr($string, 0, strlen($prefix)) == $prefix) ? true : false);
}
function getInbetweenStrings($start, $end, $str){
    $matches = array();
    $regex = "/$start([a-zA-Z0-9_]*)$end/";
    preg_match_all($regex, $str, $matches);
    return $matches[1];
}
function send_notification($msg, $registrationIds){
    define( 'API_ACCESS_KEY', 'AIzaSyB9e-i5X7kKzmMp1Y0sxVET16sLavN6KxY');

    $fields = array(
    'registration_ids'  => $registrationIds,
    'data'      => $msg
    );

    $headers = array(
    'Authorization: key=' . API_ACCESS_KEY,
    'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );
  return $result;
  }
function getTokenLight($length){
     $token = "";
     $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
     $codeAlphabet .= "0123456789";
     $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[rand(0, $max-1)];
    }

    return $token;
}
function getYoutubeIdFromUrl($url) {
    $parts = parse_url($url);
    if(isset($parts['query'])){
        parse_str($parts['query'], $qs);
        if(isset($qs['v'])){
            return $qs['v'];
        }else if(isset($qs['vi'])){
            return $qs['vi'];
        }
    }
    if(isset($parts['path'])){
        $path = explode('/', trim($parts['path'], '/'));
        return $path[count($path)-1];
    }
    return false;
}
  function getYouTubeVideoDuration($videoID){
     $apikey = "AIzaSyBY2sC1MQDEVAKrGzaKB41x7BsAmuY_hV4"; // Like this AIcvSyBsLA8znZn-i-aPLWFrsPOlWMkEyVaXAcv
     $dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$videoID&key=$apikey");
     $VidDuration =json_decode($dur, true);
     foreach ($VidDuration['items'] as $vidTime)
     {
         $VidDuration= $vidTime['contentDetails']['duration'];
     }
     preg_match_all('/(\d+)/',$VidDuration,$parts);
     if(count($parts[0])==1)
      return $parts[0][0];
     else if(count($parts[0])==2)
      return $parts[0][0].":".$parts[0][1];
     else
      return $parts[0][0].":".$parts[0][1].":".$parts[0][2]; // Return 1:11:46 (i.e) HH:MM:SS
  }
  function getDayOfWeek($date){
      $days = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi','Jeudi','Vendredi', 'Samedi');
      echo $days[date('w', strtotime($date))];
  }
  function getrealip(){
     if (isset($_SERVER)){
    if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    if(strpos($ip,",")){
    $exp_ip = explode(",",$ip);
    $ip = $exp_ip[0];
    }
    }else if(isset($_SERVER["HTTP_CLIENT_IP"])){
    $ip = $_SERVER["HTTP_CLIENT_IP"];
    }else{
    $ip = $_SERVER["REMOTE_ADDR"];
    }
    }else{
    if(getenv('HTTP_X_FORWARDED_FOR')){
    $ip = getenv('HTTP_X_FORWARDED_FOR');
    if(strpos($ip,",")){
    $exp_ip=explode(",",$ip);
    $ip = $exp_ip[0];
    }
    }else if(getenv('HTTP_CLIENT_IP')){
    $ip = getenv('HTTP_CLIENT_IP');
    }else {
    $ip = getenv('REMOTE_ADDR');
    }
    }
    return $ip; 
  }


	function MakeUrls($str){
    $find=array('`((?:https?|ftp)://\S+[[:alnum:]]/?)`si','`((?<!//)(www\.\S+[[:alnum:]]/?))`si');

    $replace=array('<a href="$1" target="_blank">$1</a>', '<a href="http://$1" target="_blank">$1</a>');

    return preg_replace($find,$replace,$str);
  }

	function size($taille,$dim){if(str_word_count($taille)>$dim){$ref='...';}else{$ref='';}return $ref;}
	function pp($char,$size){return substr($char,0,$size).size($char,$size);}
	function s($tr){return str_replace("\'","'",htmlspecialchars($tr));}
	function sa($tr){return str_replace("'","\'",htmlspecialchars($tr));}
	function a($mot){return Addslashes($mot);}
	function i($chiff){return intval($chiff);}
	function r($a,$b,$char){return s(str_replace($a,$b,$char));}
  

  function removehtmlTags($string){
    return s($string);
  }
  
  function format_date($date){
    $utc = new DateTime($date, new DateTimeZone('UTC'));
    // $utc->setTimezone(new DateTimeZone('Africa/Douala'));
    return $utc->format('d-m-Y à H:i:s');}
  function format_dateToTime($date){
    $utc = new DateTime($date, new DateTimeZone('UTC'));
    $utc->setTimezone(new DateTimeZone('Africa/Douala'));
    return $utc->format('H:i');}
  function customformat_date($date){
    $utc = new DateTime($date, new DateTimeZone('UTC'));
    $utc->setTimezone(new DateTimeZone('Africa/Douala'));
    return $utc->format('d-F-Y à H:i:s');}
  function format_dateDate($date){
    $utc = new DateTime($date, new DateTimeZone('UTC'));
    $utc->setTimezone(new DateTimeZone('Africa/Douala'));
    return $utc->format('d/m/Y');}
function format_dateDate_english($date){
    $utc = new DateTime($date, new DateTimeZone('UTC'));
    $utc->setTimezone(new DateTimeZone('Africa/Douala'));
    return $utc->format('m/d/Y');}
	function getConvertFileSize($path){
    $bytes = sprintf('%u', filesize($path));

    if ($bytes > 0)
    {
        $unit = intval(log($bytes, 1024));
        $units = array('B', 'KB', 'MB', 'GB');

        if (array_key_exists($unit, $units) === true)
        {
            return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
        }
    }

    return $bytes;
}
function getTagExpression( $str) {
    preg_match('/#(.*?)Z/', $str, $matches);
    return $matches;
}
function getTagValues($tag, $str) {
    $re = sprintf("/\{(%s)\}(.+?)\{\/\\1\}/", preg_quote($tag));
    preg_match_all($re, $str, $matches);
    return $matches[2];
}
function getRelativeTime($date) { //Mon incroyable Fonction de Date
   // Déduction de la date donnée à la date actuelle

  $utc = new DateTime($date, new DateTimeZone('Africa/Douala'));
  $utc->setTimezone(new DateTimeZone('Africa/Douala'));
  $date = $utc->format('Y-m-d H:i:s');
  
  $diff = time() - strtotime($date);
  if($diff == 0) {
      return 'maintenant';
  } elseif($diff > 0) {
      $day_diff = floor($diff / 86400);
      if($day_diff == 0) {
          if($diff < 60) return 'il y\'a un instant';
          if($diff < 120) return 'il y\'a une minute';
          if($diff < 3600) return 'il y\'a '.floor($diff / 60) . ' minutes';
          if($diff < 7200) return 'il y\'a une heure';
          if($diff < 86400) return 'il y\'a '.floor($diff / 3600) . ' heures';
      }
      if($day_diff == 1) { return 'Hier'; }
      if($day_diff < 7) { return 'il y\'a '.$day_diff . ' jours'; }
      if($day_diff < 31) { return 'il y\'a '.ceil($day_diff / 7) . ' semaines'; }
      if($day_diff < 60) { return 'le mois passé'; }
      return date('F Y', $ts);
  } else {
      $diff = abs($diff);
      $day_diff = floor($diff / 86400);
      if($day_diff == 0) {
          if($diff < 120) { return 'dans une minute'; }
          if($diff < 3600) { return 'dans ' . floor($diff / 60) . ' minutes'; }
          if($diff < 7200) { return 'dans une heure'; }
          if($diff < 86400) { return 'dans ' . floor($diff / 3600) . ' heures'; }
      }
      if($day_diff == 1) { return 'Demain'; }
      if($day_diff < 4) { return date('l', $ts); }
      if($day_diff < 7 + (7 - date('w'))) { return 'La semaine prochaine'; }
      if(ceil($day_diff / 7) < 4) { return 'dans ' . ceil($day_diff / 7) . ' semaines'; }
      if(date('n', $ts) == date('n') + 1) { return 'le mois prochain'; }
      return date('F Y', $ts);
  }

}

function formatDateAgo($value){
    $time = strtotime($value);
    $d = new \DateTime($value);

    $weekDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    $months = ['Janvier', 'Février', 'Mars', 'Avril',' Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    if ($time > strtotime('-2 minutes'))
    {
        return 'Il y a quelques secondes';
    }
    elseif ($time > strtotime('-30 minutes'))
    {
        return 'Il y a ' . floor((strtotime('now') - $time)/60) . ' min';
    }
    elseif ($time > strtotime('today'))
    {
        return $d->format('G:i');
    }
    elseif ($time > strtotime('yesterday'))
    {
        return 'Hier, ' . $d->format('G:i');
    }
    elseif ($time > strtotime('this week'))
    {
        return $weekDays[$d->format('N') - 1] . ', ' . $d->format('G:i');
    }
    else
    {
        return $d->format('j') . ' ' . $months[$d->format('n') - 1] . ', ' . $d->format('G:i');
    }
}


function getRelativeDayes($date) { //Mon incroyable Fonction de Date
   // Déduction de la date donnée à la date actuelle

  $utc = new DateTime($date, new DateTimeZone('Africa/Douala'));
  $utc->setTimezone(new DateTimeZone('Africa/Douala'));
  $date = $utc->format('Y-m-d H:i:s');
  
  $diff = time() - strtotime($date);
  if($diff == 0) {
      return 'maintenant';
  } elseif($diff > 0) {
      $day_diff = floor($diff / 86400);
      if($day_diff == 0) {
          if($diff < 60) return 'il y\'a un instant';
          if($diff < 120) return 'il y\'a une minute';
          if($diff < 3600) return 'il y\'a '.floor($diff / 60) . ' minutes';
          if($diff < 7200) return 'il y\'a une heure';
          if($diff < 86400) return 'il y\'a '.floor($diff / 3600) . ' heures';
      }
      if($day_diff == 1) { return 'Hier'; }
      if($day_diff < 7) { return 'il y\'a '.$day_diff . ' jours'; }
      if($day_diff < 31) { return 'il y\'a '.ceil($day_diff / 7) . ' semaines'; }
      if($day_diff < 60) { return 'le mois passé'; }
      return date('F Y', strtotime($date));
  } else {
      $diff = abs($diff);
      $day_diff = floor($diff / 86400);
      if($day_diff == 0) {
          if($diff < 120) { return 'dans une minute'; }
          if($diff < 3600) { return 'dans ' . floor($diff / 60) . ' minutes'; }
          if($diff < 7200) { return 'dans une heure'; }
          if($diff < 86400) { return 'dans ' . floor($diff / 3600) . ' heures'; }
      }
      if($day_diff == 1) { return 'Demain'; }
      if($day_diff < 4) { return date('l', $ts); }
      if($day_diff < 7 + (7 - date('w'))) { return 'La semaine prochaine'; }
      if(ceil($day_diff / 7) < 4) { return 'dans ' . ceil($day_diff / 7) . ' semaines'; }
      if(date('n', $ts) == date('n') + 1) { return 'le mois prochain'; }
      return date('F Y', strtotime($date));
  }

}

  function format_date3($date){

    $date=explode('-',(explode(' ', $date)[0]));
    $annee=$date[0]; $jour=$date[2]; $mois=$date[1];
    $listemois= array('','Jan','Fev','Mars','Avr','Mai','Juin','Juil','Août','Sept','Oct','Nov','Dec');
    $newmois=$listemois[($mois+0)];
    return $jour." ".$newmois." ".$annee;

  }

  function format_dateHour($date1){

    $date=explode('-',(explode(' ', $date1)[0]));
    $heure=explode(' ', $date1)[1];
    $annee=$date[0]; $jour=$date[2]; $mois=$date[1];
    $listemois= array('','Jan','Fev','Mars','Avr','Mai','Juin','Juil','Août','Sept','Oct','Nov','Dec');
    $newmois=$listemois[($mois+0)];
    return $jour." ".$newmois." ".$annee." à ".$heure;

  }
  
	function getJourSemaine($i){
		switch ($i) {
			case '1':
				return 'Lundi';
				break;
			case '2':
				return 'Mardi';
				break;
			case '3':
				return 'Mercredi';
				break;
			case '4':
				return 'Jeudi';
				break;
			case '5':
				return 'Vendredi';
				break;
			case '6':
				return 'Samedi';
				break;
			case '7':
				return 'Dimanche';
				break;
			
			default:
				return '';
				break;
		}
	}

	function getBaseUrl(){
		$base_dir = __DIR__;

		// server protocol
		$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';

		// domain name
		$domain = $_SERVER['SERVER_NAME'];

		// server port
		$port = $_SERVER['SERVER_PORT'];
		$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";

		// put em all together to get the complete base URL
		$url = "${protocol}://${domain}${disp_port}".BASEURL;

		return $url;
	}

	function minimumQuatreChiffre($number){
		if(strlen($number)==1){
			return "000".$number;
		}
		else if(strlen($number)==2){
			return "00".$number;
		}
		else if(strlen($number)==3){
			return "0".$number;
		}
		else if(strlen($number)>3){
			return "".$number;
		}
		else {
			return "".$number;
		}
	}
  function slugify($text){
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
  }

	function format_money($number){
		$n = $number;
		/*if($_SESSION['lang']=='fr')
			$n = number_format($number, 0, ',', ' ');
		else
			$n = number_format($number);*/
	 	$n = number_format($number, 0);
         //return str_replace(",", " ", $n)." Fcfa";
         return str_replace(",", " ", $n);
	}
	class Template {
	    protected $file;
	    protected $values = array();
	  
	    public function __construct($file) {
	        $this->file = $file;
	    }
	    public function set($key, $value) {
		    $this->values[$key] = $value;
		}
		  
		public function output() {
		    if (!file_exists($this->file)) {
		        return "Error loading template file ($this->file).";
		    }
		    $output = file_get_contents($this->file);
		  
		    foreach ($this->values as $key => $value) {
		        $tagToReplace = "[@$key]";
		        $output = str_replace($tagToReplace, $value, $output);
		    }
		  
		    return $output;
		}
  }
  
  function objectExist($table, $id,$type){
      foreach($table::q()->execute() as $obj){
          if($obj->id==$id and $obj->type==$type){
            return true;
          }
      }
      return false;
  }
  function objectExists($table, $id){
    foreach($table::q()->execute() as $obj){
        if($obj->id==$id){
          return true;
        }
    }
    return false;
}

//difference entre les dates
  function diffDate($date1, $date2){

      $datetime1 = new DateTime($date1);
      $datetime2 = new DateTime($date2);
      $interval = $datetime1->diff($datetime2);
      return $interval->format('%R%a');

  }

//verification de la coherence entre la frequence de visite et le rappel
function verifFreqEnt($valFreq,$unitFreq,$valRap,$unitRap){
         if($valFreq<$valRap){
             if($unitFreq==1){
                return 0; 
             }
             if($unitFreq==2){
                 if($unitRap==1 & ($valFreq*7)<$valRap){
                    return 0; 
                 }
                 if($unitRap==2){
                    return 0; 
                 }
             }
             if($unitFreq==3){
                 if($unitRap==1 & ($valFreq*28)<$valRap){
                     return 0;
                 }
                 if($unitRap==2 & ($valFreq*4)<$valRap){
                     return 0;
                 }
                 if($unitRap==3){
                    return 0; 
                 }
             }
         }
         return 1;
     }
        
     function getWeeks($date, $rollover)
     {
         $cut = substr($date, 0, 8);
         $daylen = 86400;
     
         $timestamp = strtotime($date);
         $first = strtotime($cut . "00");
         $elapsed = ($timestamp - $first) / $daylen;
     
         $weeks = 1;
     
         for ($i = 1; $i <= $elapsed; $i++)
         {
             $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
             $daytimestamp = strtotime($dayfind);
     
             $day = strtolower(date("l", $daytimestamp));
     
             if($day == strtolower($rollover))  $weeks ++;
         }
     
         return $weeks;
     }

     function firstDayOfWeek($date)
    {
        $custom_date = strtotime( date('d-m-Y', strtotime($date)) ); 
        $week_start = date('d-m-Y', strtotime('this week last monday', $custom_date));
        return $week_start;
    }
    function MondayOfWeek($annee,$number)
    {
        $lundi = new DateTime();
        $lundi->setISOdate($annee, $number);
        return $lundi->format('d');
    }
    function endMonth($date, $nbre){//fonction qui ajoute des mois a une date
        $date = format_dateDate($date); 
        

        $day = explode('/',$date)[0];
        $month=explode('/',$date)[1];
        $year=explode('/',$date)[2];
        for ($i=1; $i <=$nbre ; $i++) { 
            $month++;
            if($month==13){
                $month=1;
                $year++;            
            }
        }
        $datefin= date('Y-m-d', strtotime(''.$day.'-'.$month.'-'.$year.''));

        return $datefin;
    }
    function nextmonth($date){
        
        $date = format_dateDate($date); 
        $month=explode('/',$date)[1];
        
        $month;
        $nextmonths= array();
        for ($i=0; $i <12 ; $i++) { 
            if($month==13){
                $month=1;
            }
            switch ($month) {
                case '1':
                $nextmonths[$i]="1";
                $month++;
                    break;
                case '2':
                $nextmonths[$i]="2";
                $month++;
                    break;
                case '3':
                $nextmonths[$i]="3";
                $month++;
                    break;
                case '4':
                $nextmonths[$i]="4";
                $month++;
                    break;
                case '5':
                $nextmonths[$i]="5";
                $month++;
                    break;
                case '6':
                $nextmonths[$i]="6";
                $month++;
                    break;
                case '7':
                $nextmonths[$i]="7";
                $month++;
                    break;
                case '8':
                $nextmonths[$i]="8";
                $month++;
                    break;
                case '9':
                $nextmonths[$i]="9";
                $month++;
                    break;
                case '10':
                $nextmonths[$i]="10";
                $month++;
                    break;
                case '11':
                $nextmonths[$i]="11";
                $month++;
                    break;
                case '12':
                $nextmonths[$i]="12";
                $month++;
                    break;
                default:
                    break;
            }
        }
        return $nextmonths;
    }
    function week_number($date) 
    { 
        $good_format=strtotime ($date);
        return date('W',$good_format);
    }  

    function getAllDaysInAMonth($date,  $daysError = 3) {

        $day = 'Monday';
        $date = format_dateDate($date); 

        $month=explode('/',$date);

        $dateString = 'first '.$day.' of '.$month[2].'-'.$month[1];
    
        if (!strtotime($dateString)) {
            throw new \Exception('"'.$dateString.'" is not a valid strtotime');
        }
    
        $startDay = new \DateTime($dateString);
    
        if ($startDay->format('j') > $daysError) {
            $startDay->modify('- 7 days');
        }
    
        $days = array();
    
        while ($startDay->format('Y-m') <= $month[2].'-'.str_pad($month[1], 2, 0, STR_PAD_LEFT)) {
            if($startDay->format('m')==$month[1]){
                $days[] = clone($startDay);
            }
            $startDay->modify('+ 7 days');
        }
    
        return $days;
    }

    function week_to_day($numSemaine, $annee){
        //-- les paramètres ------------
        //$numSemaine = 47;
        // $annee = 2009;
        $timeStampPremierJanvier = strtotime($annee . '-01-01');
        $jourPremierJanvier = date('w', $timeStampPremierJanvier);
        
        //-- recherche du N° de semaine du 1er janvier -------------------
        $numSemainePremierJanvier = date('W', $timeStampPremierJanvier);
        
        //-- nombre à ajouter en fonction du numéro précédent ------------
        $decallage = ($numSemainePremierJanvier == 1) ? $numSemaine - 1 : $numSemaine;
        //-- timestamp du jour dans la semaine recherchée ----------------
        $timeStampDate = strtotime('+' . $decallage . ' weeks', $timeStampPremierJanvier);
        //-- recherche du lundi de la semaine en fonction de la ligne précédente ---------
        $jourDebutSemaine = ($jourPremierJanvier == 1) ? date('d-m-Y', $timeStampDate) : date('d-m-Y', strtotime('last monday', $timeStampDate));
        
        return "Le premier jour de la semaine N° $numSemaine est  le $jourDebutSemaine<br>";
    }
    function first_day_week($numSemaine, $annee){
        //-- les paramètres ------------
        //$numSemaine = 47;
        // $annee = 2009;
        $timeStampPremierJanvier = strtotime($annee . '-01-01');
        $jourPremierJanvier = date('w', $timeStampPremierJanvier);
        
        //-- recherche du N° de semaine du 1er janvier -------------------
        $numSemainePremierJanvier = date('W', $timeStampPremierJanvier);
        
        //-- nombre à ajouter en fonction du numéro précédent ------------
        $decallage = ($numSemainePremierJanvier == 1) ? $numSemaine - 1 : $numSemaine;
        //-- timestamp du jour dans la semaine recherchée ----------------
        $timeStampDate = strtotime('+' . $decallage . ' weeks', $timeStampPremierJanvier);
        //-- recherche du lundi de la semaine en fonction de la ligne précédente ---------
        $jourDebutSemaine = ($jourPremierJanvier == 1) ? date('d-m-Y', $timeStampDate) : date('d-m-Y', strtotime('last monday', $timeStampDate));
        
        return $jourDebutSemaine;
    }

    function month_week($semaine, $annee){
        
        return (new DateTime())->setISODate($annee, $semaine)->format('m');;
    }

    function jours_ferie($idspecialite,$semaine){
        $tableau=Array();
        $vacances=0;
        $ferie=0;
        $examen=0;
        $stage=0;
        $soutenance=0;
        $nombre=0;
        foreach(CalendrierVac::q()->where("idannee=? and idecole=?",$_SESSION["annee"],$_SESSION["ecole"])->execute() as $vacance){
            
            if(in_array($idspecialite,explode(',',$vacance->idspecialite)) or $vacance->idspecialite=="dim"){ 
                $nombre++;
                //if($vacance->idspecialite=="dim"){ echo("dim"); }
                $start = new DateTime($vacance->debut);
                $end = new DateTime($vacance->fin);
                if($start==$end){
                    $end->modify('+ 1 days');
                }
               
                if($vacance->idspecialite=="dim"){ $end->modify('+ 1 days'); }
                //echo($vacance->debut."  ".$vacance->fin);
                // echo("<br>");
                foreach (new DatePeriod($start, new DateInterval('P1D') /* pas d'un jour */, $end) as $dt) {//echo("there");
                    $week=week_number($dt->format('Y-m-d'));
                    if($week==$semaine){
                        //echo(date('W',$dt->format('Y-m-d')));
                        switch ($vacance->type) {
                            case '1':
                                $ferie++;
                                break;
                            case '2':
                                $ferie++;
                                break;
                            case '3':
                                $examen++;
                                break;
                            case '4':
                                $stage++;
                                break;
                            case '5':
                                $soutenance++;
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                        // echo $dt->format('Y-m-d');
                        // echo("<br>");
                    }
                }

            }
        } 
        $tableau['ferie'] = $ferie;
        $tableau['examen'] = $examen;
        $tableau['stage'] = $stage;
        $tableau['soutenance'] = $soutenance;
        $tableau['nombre'] = $nombre;
        //var_dump($tableau);
        return $tableau;
    }
    

    function horaire_semaine(){
        $idecole=$_SESSION["ecole"];
            $heure=0;
            //$heure= date('H:i',$heure);
            $tampon=strtotime("01:00:00");
        foreach(horaire::q()->where("idecole=? and jour!=0 and issupprimer=0",$_SESSION["ecole"])->execute() as $horaire){
            if($horaire->heure_debut!=0 and $horaire->heure_fin!=0){
                $h1=strtotime($horaire->heure_debut);
                $h2=strtotime($horaire->heure_fin);
                // echo date('H',$h2-$h1)." ";
                $sous=date('H',$h2-$h1)-1;
                $heure= $sous+$heure;
            }
        }
        return $heure;
    }
    function moy_note($note1,$note2){
        if($note1==""){
            return $note2;
        }elseif($note2==""){
            return $note1;
        }else{
            $moy=($note1+$note2)/2;
            return $moy;
        }
    }

    function plus_grand($note1,$note2){
        if($note1==""){
            return $note2;
        }elseif($note2==""){
            return $note1;
        }else{
            if($note1>=$note2){
                return $note1;
            }else{
                return $note2;
            }
        }
        
    }

    function moy_total($note1,$note2,$pourcentage1,$pourcentage2){
        $total =($note1*$pourcentage1)/100 + ($note2*$pourcentage2)/100;

        return $total;
    }

    function null($number){
        if($number==""){
            return null;
        }else{
            return $number;
        }
    }
    function zero($number){
        if($number==""){
            return 0;
        }else{
            return $number;
        }
    }
    function int_note($note){
        if($note>20){
            return 20;
        }elseif($note<0){
            return 0;
        }else{
            return $note;
        }
    }

    function mode_paiement($mode){
        
        switch ($mode) {
            case '1':   //permanent
                return "Espèce";
                break;
            case '2':   //vacataire
                return "Chèque";
                break;
            case '3':   //permanent
                return "Prime";
                break;
            case '4':   //vacataire
                return "Versement";
                break;
            default:
                
                break;
        }
    }
    function is_jour_special($idspecialite,$mois,$jour,$annee){
        
        // echo($idspecialite." ".$mois." ".$jour." ".$annee);

        $date=$jour."-".$mois."-".$annee;
        $date=date("d-m-Y", strtotime($date));
        foreach(CalendrierVac::q()->execute() as $vacance){
    
            if(in_array($idspecialite,explode(',',$vacance->idspecialite))){
                $datedeb= new DateTime($vacance->debut); 
                $datefin = new DateTime($vacance->fin); 
                
                foreach (new DatePeriod($datedeb, DateInterval::createFromDateString('1 day'), $datefin) as $dt) {
                    $deb=$dt->format('d-m-Y');
                    if($deb==$date){
                        return("true");
                    }
                }
                
            }
        }
        return ("false");
    }
    function jour_special($idspecialite,$mois,$jour,$annee){
        $date=$jour."-".$mois."-".$annee;
        echo($date);echo"<br>";
        $date=date("d-m-Y", strtotime($date));
        foreach(CalendrierVac::q()->execute() as $vacance){
            if(in_array($idspecialite,explode(',',$vacance->idspecialite))){
                switch ($vacance->type) {
                    case '1':
                        return "background-color:#FF7588;";
                        break;
                    case '2':
                        return "background-color:#FF7588;";
                        break;
                    case '3':
                        return "background-color:black;"; 
                        break;
                    case '4':
                        return "background-color:#16D39A;";
                        break;
                    case '5':
                        return "background-color:#FFA87D;";
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }else{
                return "bizarre";
            }
        }
    }
    function niveau_etude($niveau){
        switch ($niveau) {

            case '0':
                echo("Bac ");
                break;
            
            case '1':
                echo("Bac +2 ");
                break;
            case '2':
                echo("Bac +3 ");
                break;
            
            case '3':
                echo("Master ");
                break;
            
            case '4':
                echo("Ingenieur ");
                break;

            case '5':
                echo("Docteur ");
                break;
            
            case '6':
                echo("Primaire ");
                break;
            
            case '7':
                echo("Lycee ");
                break;
            
            case '8':
                echo("Sans etudes ");
                break;
            
            case '9':
                echo("Bac + 1 ");
                break;
            
            case '10':
                echo("Bac +Tech ");
                break;
            
            case '11':
                echo("3e annee fondament");
                break;
            case '12':
                echo("Tronc commun");
                break;
            
            case '13':
                echo("2e annee sec");
                break;
            
            case '14':
                echo("Licence");
                break;

            case '15':
                echo("3e annee college");
                break;
            
            case '16':
                echo("Bac + qualification");
                break;
            
            default:
                echo("Autre");
                break;
        }
    }
    function serie($serie){
        switch ($serie) {

            case 'C':
                echo("C");
                break;
            
            case 'D':
                echo("D");
                break;
            
            case 'A':
                echo("A");
                break;
            
            case 'Ti':
                echo("Ti");
                break;
            
            case 'B':
                echo("B");
                break;
            
            case 'F4':
                echo("F4");
                break;
            
            case 'Autre':
                echo("Autre");
                break;
            
            default:
                echo("Autre");
                break;
        }
    }

    function typepers($type){

        switch ($type) {

            case '0':
                echo("Infirmerie");
                break;
            
            case '1':
                echo("Bibliotheque");
                break;
            
            case '2':
                echo("Atelier");
                break;
            
            case '3':
                echo(" Parc automobile");
                break;
            
            case '4':
                echo(" Administration");
                break;
            
            case '5':
                echo("Autres...");
                break;
            
            default:
                # code...
                break;
        }
    }
    function decision($decision){
        switch ($decision) {

            case '0':
                echo("Admis");
                break;
            
            case '1':
                echo("Admis + bourse");
                break;
                
            case '2':
                echo("Redouble");
                break;
                
            case '3':
                echo("Exclus");
                break;
            default:
                # code...
                break;
        }
    }
    function mat_etu($spec){
        $annee=AnneeScolaire::get($_SESSION["annee"]);
        $ecole=Ecole::get($_SESSION["ecole"]);
        $mat="";
        if($ecole->with_prefixe==1){
            $mat=$ecole->prefixe_mat;
        }
        if($ecole->annee_chiffre_1==0){
            $taille1 = bin2hex(openssl_random_pseudo_bytes(zero($ecole->taille_annee_chiffre1)));
            $mat.=$taille1;
        }else{
            $mat.=$annee->annee_debut;
        }
        if($ecole->texte_filiere==1){
            $mat.=explode(" ",$spec)[0];
        }else{
            $mat.=$ecole->lettre_spe;
        }
        if($ecole->annee_chiffre_2==0){
            $taille2 = bin2hex(openssl_random_pseudo_bytes(zero($ecole->taille_annee_chiffre2)));
            $mat.=$taille2;
        }else{
            $mat.=$annee->annee_debut;
        }
        return $mat;
    }

    function mat_ens($ispers,$type){
        $annee=AnneeScolaire::get($_SESSION["annee"]);
        $ecole=Ecole::get($_SESSION["ecole"]);
        $mat="";
        if($ecole->with_prefixe_prof==1){
            $mat=$ecole->prefixe_mat;
        }
        if($ecole->annee_chiffre_1_prof==0){
            $taille1 = aleatoire(zero($ecole->taille_annee_chiffre1_prof));
            $mat.=$taille1;
        }else{
            $mat.=$annee->annee_debut;
        }
        if($ecole->texte_filiere_prof==1){
            if($ispers==0){
                $mat.="ens";
            }else{
                switch ($type) {

                    case '0':
                    $mat.="inf";
                        break;
                        
                    case '1':
                    $mat.="bib";
                        break;
                    
                    case '2':
                    $mat.="ate";
                        break;
                    
                    case '3':
                    $mat.="par";
                        break;
                        
                    case '4':
                    $mat.="adm";
                        break;
                        
                    case '5':
                    $mat.="aut";
                        break;
                    
                    default:
                        $mat.="";
                        break;
                }
            }
            
        }else{
            $mat.=$ecole->lettre_spe_prof;
        }
        if($ecole->annee_chiffre_2_prof==0){
            $taille2 =  aleatoire(zero($ecole->taille_annee_chiffre2_prof));
            $mat.=$taille2;
        }else{
            $mat.=$annee->annee_debut;
        }
        return $mat;
    }
    function aleatoire($longueur)
    {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($longueur/strlen($x)) )),1,$longueur);
    }
    function randomColor() { 
        $str = '#'; 
        for($i = 0 ; $i < 6 ; $i++) { 
            $randNum = rand(0 , 15); 
            switch ($randNum) { 
                case 10: $randNum = 'A'; break; 
                case 11: $randNum = 'B'; break; 
                case 12: $randNum = 'C'; break; 
                case 13: $randNum = 'D'; break; 
                case 14: $randNum = 'E'; break; 
                case 15: $randNum = 'F'; break; 
            } 
            $str .= $randNum; 
        } 
        return $str; 
    } 
    function in_horaire($jour,$debut,$fin) { 
        foreach(Horaire::q()->where("idecole=? and jour=? and type!=2",$_SESSION["ecole"],0)->execute() as $horaire){
            if( ($debut>$horaire->heure_debut and $debut<$horaire->heure_fin ) or ($fin>$horaire->heure_debut and $fin<$horaire->heure_fin) or 
                ($debut==$horaire->heure_debut and $fin==$horaire->heure_fin) or ($debut<=$horaire->heure_debut and $fin>=$horaire->heure_fin ) ){// echo("there");
                    return 0;
                }
        }
        foreach(Horaire::q()->where("idecole=? and jour=? and type!=2",$_SESSION["ecole"],$jour)->execute() as $horaire){
            if( ($horaire->heure_debut<=$debut and $horaire->heure_fin>=$fin ) ){ 
                    return 1;
                }
        }
        return 0; 
    } 
    function prix($id){
        $produit=Produit::get($id);
        if(isset(Promotion::q()->where("etat=1 and idproduit=? and ((datefin>?) or (datefin=? and heurefin>=?))",
            $produit->id,date("Y-m-d"),date("Y-m-d"),date("H:i:s"))->execute()[0]) ){

            $promotion=Promotion::q()->where("etat=1 and idproduit=? and ((datefin>?) or (datefin=? and heurefin>=?))",
            $produit->id,date("Y-m-d"),date("Y-m-d"),date("H:i:s"))->execute()[0];

            $prix=$produit->prix-$produit->prix*$promotion->pourcentage/100;
            return $prix;
        }else{
            return $produit->prix;
        }
    }
    function enstock($id){
        $entree=0; $sortie=0; $stock=0; $commande=0;
        foreach (Stock::q()->where("idelement=? and type_element=0 and type=0",$id)->execute() as $e) {
            $entree+=$e->quantite;
        }
        foreach (Stock::q()->where("idelement=? and type_element=0 and type=1".$id)->execute() as $s) {
            $sortie+=$s->quantite;
        }
        foreach (Produit_commande::q()->where("idelement=? and type_element=0 and idcommande in (select id from commande where servi=1)",$id)->execute() as $s) {
            $commande+=$s->quantite;
        }
        $stock= Boisson::get($id)->quantite + $entree - $sortie - $commande;
        return $stock;
    }
    function error_stock($id){
        return "Il ne reste que ".enstock($id)." ".Boisson::get($id)->intitule." en stock <br>";
    }
?>