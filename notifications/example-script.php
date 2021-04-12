<?php
// PHP + curl example - should be available on 99% webhosting services
/*
	types
	stake - change live stake
	stakekey - change delegator 
	taxes
	pledge (submitted in blockchain)
	blocks - minted blocks
	pledged - real pledge
	relay - when is down.., 
	relay-online - when is back online
	dailysum - daily recap (soon)
	epochsum - epoch recap (soon)
*/

/*
//uncomment this part, if you want repost only notifications with blocks, epochsum, dailysum

	if(!$_POST['msg'] or !in_array($_POST['type'],array("blocks","epochsum","dailysum")))
		die();
*/ 

  function bot($method,$datas=[]){
      $url = "https://api.telegram.org/botAPIKEY/".$method; // APIKEY replace with yours; do not remove from start "bot"; ie: bot123456789:AABBCCDDEEFF_HHQQ
      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL,$url);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); 
      $res = curl_exec($ch);
       
      if(curl_error($ch)){
          var_dump(curl_error($ch));
      }
      
      return json_decode($res,true);
  }
  
  
print_r(bot('sendMessage',[
		 'chat_id'=>-1001308187, // replace with your chat id
		 'text'=>$_POST['msg'],
		 'parse_mode' => 'HTML'
]));
	
?>OK
