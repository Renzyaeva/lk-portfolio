<?php
require_once ($modules_root . "portfolio/class/PortfolioHome.class.php");
if(!$portfolioHome)	$portfolioHome = new PortfolioHome($request);

if($request->hasValue('portfolio') && $request->hasValue('au')) {
	$operation = false;
	$text = file_get_contents('php://input');
	$f = fopen('/home/web/lk/www/scripts/test/au/test_data', 'a');
	fwrite($f, "\n\n\n".date('Y-m-d H:i:s')."\n\n");
	$json_text = json_decode($text, true);
	
	$answer = 'answer';
	
//	$portfolioHome->saveTest($text, $type.$envent_count);
	
    if(is_array($json_text)) {
    	if($json_text['type']=='Z5RWEB') {
    		$room = $portfolioHome->getRoomBySn($json_text['sn']);
    		if(is_array($json_text['messages'])) {
    			foreach($json_text['messages'] as $value1) {
    				$id_msg = $value1['id'];
    				$type = $value1['operation'];
    				if($value1['success']==1) {
    					$portfolioHome->setDone();
    				} elseif($value1['operation']=='ping') {
    					if($value1['active']=='1') {
    						
    					}
    					if($value1['mode']!='0') {
//    						$ans = '{"date":"'.date('Y-m-d H:i:s').'","interval":15,"messages":[{"id":'.$id_msg.',"operation":"set_mode","mode":0}]}';
    					} 
    					
//    					$ans = '{"date":"'.date('Y-m-d H:i:s').'","interval":15,"messages":[{"id":123456789,"operation":"add_cards","cards":​[{"card":"00007CF24B41","flags":0,"tz":1}]}]}';
//   						$ans = '{"date":"'.date('Y-m-d H:i:s').'","interval":15,"messages":[{"id":'.$id_msg.',"operation":"open_door","direction":0}]}';
 
    					$msg = $portfolioHome->getDo();
    					if($msg) {
    						$answer .= 'do-'.$msg['id'];
    						$ans = '{"date":"'.date('Y-m-d H:i:s').'","interval":15,"messages":[{"id":'.$id_msg.','.$msg['message'].'}]}';
    						$msg = $portfolioHome->setDo($msg['id']);
    					}    					    					
   						if(!$ans) $ans = '{"date":"'.date('Y-m-d H:i:s').'", "interval":10, "messages":null}';
    				} elseif($value1['operation']=='power_on') {
    						$ans = '{"date":"'.date('Y-m-d H:i:s').'","interval":10,"messages":[{"id":'.$id_msg.', "operation":"set_active", "active":1, "online":0}, {"id":1189641421, "operation":"events","events_success":1}]}';
    				} elseif($value1['operation']=='events') {
    					if(is_array($value1['events'])) {
    						$envent_count = 0;
    						foreach($value1['events'] as $value2) {
    							if($value2['card']) {
    								fwrite($f, 'E>'.$value2['card'].' >--'.$lesson.'-> '.$value2['time']."-\n");
    								//получаем пользователея по карте
    								$user = $portfolioHome->getUserByCard($value2['card'][0].$value2['card'][1].$value2['card'][2].$value2['card'][3].$value2['card'][4].$value2['card'][5].$value2['card'][6].$value2['card'][7]);
    								if($user['id']) {
    									//дата и время в разных проявлениях
    									$date = $functions->makeUnixDate($value2['time'], '-', 'date-obr');
    									$time = $functions->makeUnixDate($value2['time'], '-', 'time');
    									$date_full = $functions->makeUnixDate($value2['time'], '-', 'all-obr');

    									//номер пары
    									if($room['id']!='43') {
    										$lesson = $portfolioHome->getLessonNum($time);
    										$presens = $portfolioHome->getPresensByRoom($room['id'], $lesson['id'], $date);
    										fwrite($f, 'DATE->'.$date.' >--'.$time.'-> '.$date_full."-\n");
    										if(!$presens['id']) $presens['id'] = $portfolioHome->savePresensByRoom($room['id'], $lesson['id'], $date);
    										fwrite($f, 'USER>'.$presens['id'].' >--'.$user['id'].'-> '.$date_full."-\n");
    										$portfolioHome->saveUserPresens($presens['id'], $user['id'],$date_full,$room['id']);
    										fwrite($f, 'EE>'.$value2['card'].' >--'.$lesson.'-> '.$value2['time']."-\n");
    									} else {
    										$portfolioHome->saveUserPresens(0, $user['id'],$date_full,$room['id']);
    									}
    								} else {
    									fwrite($f, 'EE-no>'.$value2['event'].' - '.$value2['time']."-\n");
    								}
    							}
    							$envent_count++;
    						}
    						$ans = '{"date":"'.date('Y-m-d H:i:s').'","interval":10,"messages":[{"id":'.$id_msg.',"operation":"events","events_success":'.$envent_count.'}]}';
    					    //            {"date":"2018-02-07 13:03:04","interval":8, "messages":[{"id":1189641421, "operation":"events","events_success":1}]}
    						//$ans = '{"id":'.$id_msg.', "operation":"events", "events_success":'.$envent_count.'}';
    					}
    				}
    			}
    		}
    	}
    }
	
    $portfolioHome->saveTest($text, $type.$envent_count);
    
	if(!$ans) $ans = '{"date":"'.date('Y-m-d H:i:s').'","interval":10,"messages":null}';
	$portfolioHome->saveTest($ans, $answer);
	echo $ans;
	 fclose($f);

//echo '{"date":"2018-01-29 14:25:28","interval":8,"messages":[{"id":1,"operation":"open_door","direction":0},{"id":2,"operation":"open_door","direction":0}]}';

} elseif($request->hasValue('portfolio') && $request->hasValue('addconf') && $request->getValue('id_type') && $loggedIn) {
	//Вывод формы ввода нформации о конференции
	$item = $portfolioHome->getListConferenceType();
	$item['list_type'] = $functions->makeOption($item,$request->getValue('id_type'));
	$item['id_type'] =  $request->getValue('id_type');
	$type = $portfolioHome->getConferenceType($request->getValue('id_type'));
	$type_header = explode('%', $type['header']);
	$i=0;
	foreach ($type_header as $value) {
		$i++;
		$item['field'.$i]=$value;
	}
	$item_docs = $portfolioHome->getListDoc('id_user',$id_portfolio,0,true);
	$item['list_doc'] = $functions->makeOption($item_docs);
	echo $templateHome->parse($modules_root."portfolio/tpl/form_conf.tpl", $item);
}
?>