<?php
require_once ($modules_root . "portfolio/class/PortfolioHome.class.php");
require_once ($modules_root . "portfolio/src/functions.inc.php");
require_once ($modules_root . "card/class/CardHome.class.php");
require_once ($modules_root."users/class/UsersHome.class.php");
require_once ($modules_root."anketa/class/AnketaHome.class.php"); $use_anketa = true;
require_once ($modules_root . "portfolio/src/get_marks_from_dof.php");



if(!$portfolioHome)	$portfolioHome = new PortfolioHome($request);
if(!$usersHome)	$usersHome = new UsersHome($request);
if(!$cardHome)	$cardHome = new CardHome($request);
if(!$anketaHome && $use_anketa)	$anketaHome = new AnketaHome($request);

$otchet_type = array('Экзамен','Зачет','Курсовая работа','Курсовой проект','Дифф. зачет');

if($loggedIn && $use_anketa) {
	//Права на анкету
	$tmp = $moduleHome->getModuleBy('links','anketa');
	$rights_anketa = $usersHome->checkRights($current_user['groups'],$tmp['id']);
}

if($loggedIn) {
	//Права на модуль карточки, трудоустройства, воинского учета
	if($rights=='write') $rights_card = $rights_work = 'write';
	else {
		$tmp = $moduleHome->getModuleBy('links','card');
		$rights_card = $usersHome->checkRights($current_user['groups'],$tmp['id']);
		$rights_card_dep = $usersHome->rights_dep; 
		if($rights=='use' && $rights_card!='write' && $rights_card!='use') $rights_card = 'use';

		$tmp = $moduleHome->getModuleBy('links','work');
		$rights_work = $usersHome->checkRights($current_user['groups'],$tmp['id']);
		if($rights=='use' && $rights_work!='write' && $rights_work!='use') $rights_work = 'use';

		$tmp = $moduleHome->getModuleBy('links','mil');
		$rights_mil = $usersHome->checkRights($current_user['groups'],$tmp['id']);
		if($rights=='use' && $rights_mil!='write' && $rights_mil!='use') $rights_mil = 'use';
	}
}

function outNps($list_nps, &$list, &$i, $all) {
	global $portfolioHome;
	global $templateHome;
	global $modules_root;
	
	foreach ($list_nps as $value) {
		if($value['name']==$old_name) {
			$value['name'] = '';
			$value['i']='';
		} else {
			$list_edu = $portfolioHome->getListEducation('id_user',$value['id_user']);
			foreach ($list_edu as $item) {
				$value['education'] .= $templateHome->parse($modules_root."portfolio/tpl/edu_row.tpl", $item);
			}
			$exp = $portfolioHome->getUserExp($value['id_user']);
			$value['exp'] .= $templateHome->parse($modules_root."portfolio/tpl/row_exp.tpl", $exp);
			$old_name = $value['name'];
			$i++;
			$value['i']=$i;
		}
		$site = $portfolioHome->getSite($value['id_department']);
		if($site) {
			$value['site'] = $templateHome->parse($modules_root."portfolio/tpl/row_nps_site.tpl", $site);
		}
		$subject_list = $portfolioHome->getSubjectList($value['id_user']);
		if($subject_list) {
			foreach ($subject_list as $item) {
				$value['subject_list'] .= $templateHome->parse($modules_root."portfolio/tpl/row_subject.tpl", $item);
			}
		}
		if($all) $value['all'] = '/all';
		$list['rows'].= $templateHome->parse($modules_root."portfolio/tpl/row_nps.tpl", $value);
	}

}



if($request->hasValue('au')) {
	$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/au.tpl", $item);
}


//Получение идентификатора текущего портфолио
if($request->hasValue('portfolio')) {
	if($request->getValue('portfolio')) {
		$id_portfolio = $request->getValue('portfolio');
	} else {
		$id_portfolio = $current_user['id'];
	}
}

if($request->hasValue('portfolio') && $request->hasValue('err') && ($rights=='write' || $rights_card=='write')) {
	if($request->getValue('err') == 1) {
		$module['text'] .= "Сортировка: <b>по факультетам</b>, <a href='/portfolio/err'>по алфавиту</a>, <a href='/portfolio/err/2'>по дате ввода</a><br><br>";
	} elseif($request->getValue('err') == 2) {
		$module['text'] .= "Сортировка: <a href='/portfolio/err/1'>по факультетам</a>, <a href='/portfolio/err'>по алфавиту</a>, <b>по дате ввода</b><br><br>";
	} else {
		if($request->getValue('err')) {
			$date_select['date_err'] = $request->getValue('err');
			$module['text'] .= "Сортировка: <a href='/portfolio/err/1'>по факультетам</a>, <a href='/portfolio/err'>по алфавиту</a>, <a href='/portfolio/err/2'>по дате ввода</a><br><br>";

		} else $module['text'] .= "Сортировка: <a href='/portfolio/err/1'>по факультетам</a>, <b>по алфавиту</b>, <a href='/portfolio/err/2'>по дате ввода</a><br><br>";
	}
	
	$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/date_selector.tpl", $date_select);
	$module['text'] .= "<table class='ispgut'><tr class='ispguth'><td>№ п/п</td><td>ФИО (группа обучения)</td><td>Префикс реестра Сбербанк</td><td>Номер реестра Сбербанк</td><td>Дата реестра Сбербанк</td><td>Дата ввода данных</td><td>Ошибка</td><td>Оператор</td></tr>";
	$err_parus_list = $portfolioHome->getErrParusList($request->getValue('err'));
	if($err_parus_list) {
		$i=0;
		$fname = '';
		foreach ($err_parus_list as $value) {
			if($fname!=$value['faculty'] && $request->getValue('err') == 1) {
				$fname=$value['faculty'];
				$module['text'] .= '<tr><td colspan="8"><b>'.$value['faculty']."</b></td></tr>\n";
			}
			$i++;
			$value['i'] = $i;
			$user_from_parus = $cardHome->getValues('id', $value['eios_id'], 'user', array('id_operator'));
			$user_operator = $cardHome->getValues('id', $user_from_parus['id_operator'], 'user', array('firstname', 'secondname', 'lastname'));
			$value['operator'] = '<a href="/portfolio/'.$user_from_parus['id_operator'].'">'.$user_operator['lastname'].' '.$user_operator['firstname'].' '.$user_operator['secondname'].'</a>';
			//var_dump($user_from_parus);
			$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/row_err.tpl", $value);
		}
	}
	$module['text'] .= "</table>";
	
} elseif($request->hasValue('portfolio') && $request->hasValue('room') && $rights=='write') {
	if(!$request->getValue('room')) {
		$item_list = $portfolioHome->getListRoom();
		if($item_list) {
			foreach ($item_list as $value) {
				$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/row_room.tpl", $value);
			}
		}
	} else {
		//Если есть диапазон дат
		if($request->getValue('date_begin') && $request->getValue('date_end')) {
			$presence['date_begin'] = $functions->remakeDate($request->getValue('date_begin'));
			$presence['date_end']   = $functions->remakeDate($request->getValue('date_end')) + 86400;
		} else {
			$presence['date_end'] = date('U');
			$presence['date_begin'] = mktime(0,0,0,date('n')-1,date('j'),date('Y'));
		}
		//Выбор списка встреч
		$meet_list = $portfolioHome->getMeetList($request->getValue('room'));
		if($meet_list) {
			$presence['meet'] = $functions->makeOption($meet_list,$request->getValue('id_meet'));
		}
		//Обработка встречи
		if($request->getValue('id_meet')) {
			if(!$meet_item) $meet_item = $portfolioHome->getMeet($request->getValue('id_meet'));
			$user_list = $portfolioHome->getUserOnMeet($request->getValue('id_meet'),$request->getValue('room'),$meet_item['date_unix']);
//			$item_list = $portfolioHome->getListPresensByRoom($request->getValue('room'),($meet_item['date_unix']-3600),($meet_item['date_unix']+5400));
//			$user_list = array_merge($user_list,$item_list);
			$count_user = 0;
			$count_pres = 0;
		}
		
		if($request->getValue('id_meet') && !$user_list) {
			$presence['date_begin'] = ($meet_item['date_unix']-3600);
			$presence['date_end']   = ($meet_item['date_unix']+5400);
		}
		
		if($request->getValue('id_meet') && $user_list) {
			if($user_list) {
				$old_id = false;
				foreach ($user_list as $value1) {
					if(!$value || $value['id_user']!=$value1['id_user']) {

						if($value) {
							if(!$value['date_date']) $value['date_date'] = 'отсутствует';
							$presence['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_presence.tpl", $value);
						}
						$count_user++;
						$value = $value1;
						$value['count_user'] = $count_user;
						if($value1['date_create_unix']) {
							if(!$value['date_date'])   $count_pres++;
							$value['date_date'] = $value1['date_create'];
						}
					} else {
						if($value1['date_create_unix']) {
							//							$value['date_date'] .= ', '.$value1['date_create'];
						}
					}
				}
				if(!$value['date_date']) $value['date_date'] = 'отсутствует';
				$presence['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_presence.tpl", $value);
			}
				
			//Обработка полного списка по аудитории
		} else {
			$item_list = $portfolioHome->getListPresensByRoom($request->getValue('room'),$presence['date_begin'],$presence['date_end']);
//			$presence['date_begin'] = $request->getValue('date_begin') ;
//			$presence['date_end'] = $request->getValue('date_end') ;
			
			$duser = array();
			
			if($item_list && is_array($item_list)) {
				$ttt01 = microtime(1);
				foreach ($item_list as $value) {
					if(!$value['date_unix']) $value['date_date'] = $value['date_create'];
					if($value['id_user']) {
//						$user_item = $usersHome->getBy('id',$value['id_user']);
						$value['name'] = "<a href='/portfolio/".$value['id_user']."'>".$value['name_user']."</a>";
					}
					
					if(!$request->getValue('id_meet')) {
						if($value['is_student']) $value['name'] .= " - ст.";
						if($value['is_empl']) $value['name'] .= " - сотр.";
							
						if($value['type']==1) $value['name'] .= " - выход";
						elseif($value['type']==2)$value['name'] .= " - вход";
						elseif($value['type']==3)$value['name'] .= " - неизвестно";
						elseif($value['type']==0)$value['name'] .= " - неопределено";
						elseif($value['type']==5)$value['name'] .= " - запрет выхода";
						elseif($value['type']==6)$value['name'] .= " - запрет входа";
						elseif($value['type']==7)$value['name'] .= " - запрет";
						elseif($value['type']==4)$value['name'] .= " - запрет";
					} else {
						$count_user++;
						$count_pres++;
						$value['count_user'] = $count_user;
					}
					if(!$request->getValue('id_meet') || !in_array($value['id_user'], $duser))
						$presence['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_presence.tpl", $value);
					
					if($request->getValue('id_meet')) array_push($duser, $value['id_user']);
				}
			}
		}
		$presence['id'] = $request->getValue('room');
		$presence['count_user'] = $count_user;
		$presence['count_pres'] = $count_pres;
		$presence['id_meet'] = $meet_item['id'];
		if(!$request->hasValue('print')) $presence['url'] = '/'.$request->variables['query'];
		if($presence['date_begin']) $presence['date_begin']= date('d.m.Y',$presence['date_begin']);
		if($presence['date_end']) $presence['date_end']= date('d.m.Y',$presence['date_end']-1);
		$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/table_presence.tpl", $presence);
	}
	
} elseif($request->hasValue('portfolio') && $request->hasValue('adddoc') && $loggedIn) {
	//Вывод формы ввода документов
	$item = $portfolioHome->getListDocType();
	$item['list_type'] = $functions->makeOption($item,$request->getValue('id_type'));
	foreach ($item as $value) {
		$item['row_hidden'] .= $templateHome->parse($modules_root."portfolio/tpl/row_hidden.tpl", $value);
	}
	
	
	$item['id_type'] =  $request->getValue('id_type');
	$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/form_doc.tpl", $item);
} elseif($request->hasValue('portfolio') && $request->hasValue('adddoc') && $loggedIn) {
	//Вывод формы выбора типа документа
	$item = $portfolioHome->getListDocType();
	$item['list_type'] = $functions->makeOption($item);
	$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/form_doc_type.tpl", $item);
} elseif($request->hasValue('portfolio') && $request->hasValue('addconf') && $request->getValue('id_type') && $loggedIn) {
	//Вывод формы ввода нформации о конференции ajax

} elseif($request->hasValue('portfolio') && $request->hasValue('addconf') && $loggedIn) {
	//Вывод формы выбора типа конференции
	$item = $portfolioHome->getListConferenceType();
	$item['list_type'] = $functions->makeOption($item);
	$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/form_conf_type.tpl", $item);
} elseif($request->hasValue('portfolio') && $request->hasValue('resume') && $loggedIn 
	&& (
		($portfolio_user['is_student'] && $request->getValue('portfolio') == $current_user['id']) 
		|| ($portfolio_user['is_graduate'] && $request->getValue('portfolio') == $current_user['id']) 
		|| $portfolio_user['is_emoloyer'] || $rights == 'write' || $rights_work == 'use' || $rights_work == 'write'
        || $current_user['is_employer']
	) 
) {
	//Вывод формы заполнения авторезюме
	if($request->getValue('portfolio')) {
		$portfolio_user_add = $portfolioHome->getValue('id_user', $request->getValue('portfolio'), 'user_resume', $portfolioHome->item_resume, 2);
		if($portfolio_user_add) {
			$portfolio_user = array_merge($portfolio_user, $portfolio_user_add);
			$portfolio_user['id'] = $portfolio_user_add['id'];
		} else {
			unset($portfolio_user['id']);
			$portfolio_user['id_user'] = $request->getValue('portfolio');
		}

		if($current_user['id'] == $id_portfolio || $rights == 'write') $portfolio_user['edit'] = true;

	}
	//var_dump($portfolio_user);
	if($portfolio_user['sex'] == 0) $portfolio_user['sex'] = 'Жен.';
	elseif($portfolio_user['sex'] == 1) $portfolio_user['sex'] = 'Муж.';
	if($portfolio_user['know_pk'] == 1) $portfolio_user['pk1'] = "checked='checked'";
	elseif($portfolio_user['know_pk'] == 2) $portfolio_user['pk2'] = "checked='checked'";
	elseif($portfolio_user['know_pk'] == 3) $portfolio_user['pk3'] = "checked='checked'";
	elseif($portfolio_user['know_pk'] == 4) $portfolio_user['pk4'] = "checked='checked'";
	$executions = $usersHome->getExecutions($id_portfolio, true);
	foreach ($executions as $item) {
		//var_dump($item);
		$ippr = $portfolioHome->getUserIPPR($id_portfolio, $item['id']);
		if($ippr) {
				if(!$portfolio_user_add['work_condition']) {
					if($portfolio_user['work_condition']) $portfolio_user['work_condition'] .= '. ';
					$portfolio_user['work_condition'] .= $ippr['work_condition'];
				}
			
		}
		if(($item['is_student'] || $item['is_graduate']) && $item['id_category']<100) {
			$tmp = $usersHome->getSpec($item['id_spec']);
			$portfolio_user['edu'] .= $tmp['napravlenie'].'. '.$tmp['profilename'].' - '.$item['name_department'].'('.$item['name_kind'].', '.$item['name_category'].');<br>';
		}
		
	}
	$tmp = $usersHome->getValue('user_add','id_user',$id_portfolio, $usersHome->items_add);
	$portfolio_user['date_birth'] = $tmp['date_birth_date'];
	$portfolio_user['age'] = date('Y') - $tmp['date_birth_year'];

	$list_conf = $portfolioHome->getListConference('id_user', $id_portfolio);
	foreach ($list_conf as $item) {
		if($portfolio_user['science']) $portfolio_user['science'] .= '<br>';
		$portfolio_user['science'] .= $item['type'].': '.$item['name'].', '.$item['topic'];
		if($item['date_begin_unix']) $portfolio_user['science'] .= '['.$item['date_begin_date'].']';
	}

//var_dump($portfolio_user);
	$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/form_resume.tpl", $portfolio_user);
} elseif($request->hasValue('portfolio') || $request->hasValue('employees') || $request->hasValue('contact')) {
	if($id_portfolio && !$request->hasValue('study_cource') && !$request->hasValue('ippr') && ($request->hasValue('my') || ($id_portfolio != $current_user['id'] || $request->getValue('portfolio')))) {
		//Вывод информации о пользователе
		$executions = $usersHome->getExecutions($id_portfolio, true);
		$user = Array();
		$user['id'] = $id_portfolio;
		$tmp = $usersHome->getValue('user_add','id_user', $portfolio_user['id'],array('date_birth','biography'));
		if($tmp['biography'] && $current_user['is_empl']) $user['biography'] = $tmp['biography'];
		if($rights=="write" || $id_portfolio==$current_user['id']) {
			$user['is_show'] = 1;
			$user['code'] = $executions[0]['code'];
			//Вывод дня рождения
			if($tmp['date_birth_unix']!=0) $user['date_birth'] = $tmp['date_birth_date'];
			//Вывод договоров
			$contract_list = $portfolioHome->getValues('id_user', $portfolio_user['id'],'user_contract', array('id','full_numb','status','type'),2);
			if ($contract_list) {
				foreach ($contract_list as $value) {
					//if($rights=='write') var_dump($value);
					$tmp = $portfolioHome->getValue('id_contract',$value['id'],'user_debt',array('id', 'summ_remn'),2);
					if($tmp['summ_remn']>0) $value['debt'] = $tmp['summ_remn'];
					$user['contract_list'] .= $templateHome->parse($modules_root."portfolio/tpl/row_user_contract.tpl", $value);
				}
			}
		}

		$education = $portfolioHome->getListEducation('id_user',$id_portfolio);
		foreach ($education as $value) {
//			$value['date_begin'] = date("d.m.Y", $value['date_begin_unix']);
//			$value["date_end"] = date("d.m.Y", $value["date_end_unix"]);
//			if($value['id_category']<10) $value['rate']='';
			$user['rows_edu'] .= $templateHome->parse($modules_root."users/tpl/row_user.tpl", $value);
		}
		foreach ($executions as $value) {
			if($request->hasValue('my') || $rights=='write') { 
			    $value['is_show_user'] = true;
			}
			if($value['id_department'] && !$value['name_department']) {
			    $value['name_department'] = $portfolioHome->getValue('id', $value['id_department'], 'org', array('name'), 2)['name'];
			    $value['name_category'] = 'Организация-работодатель';
            }
			$user['is_show_user'] = $value['is_show_user'];
			if($value['is_student']) $is_student = true;
			if($request->hasValue('my') || $loggedIn || ($value['is_show'] || $rights=='write') || !$value['date_end_unix'] && $value['name_kind']=='Основной') {
				$value['date_begin'] = date("d.m.Y", $value['date_begin_unix']);
				$value["date_end"] = date("d.m.Y", $value["date_end_unix"]);
				if($value['id_category']<10) $value['rate']='';
				if($value['id_category']>=10 || $value['id_category'] == 0) {
					unset($value['name_group']);
					unset($value['id_spec']);
					unset($value['spec_name']);
				}
				if($value['id_spec'] && $value["id_category"]<10 && $value["id_category"]!=0) {
					$tmp = $usersHome->getSpec($value['id_spec']);
					$value['spec_name'] = $tmp['napravlenie'].'. '.$tmp['profilename'];
					$value['study_cource'] = $tmp['mdl_category'];
					$value["name_position"] = null;
				} 
				if($request->hasValue('my')) $value['is_show_user'] = true;
				if($request->hasValue('my')) $value['my2'] = true;
				if($rights=='write' || in_array($value['id_department'], $current_user['dep_list'])) $value['my2'] = true;
				if($request->hasValue('my') && ($value['date_end_unix'] || $value['name_kind']!='Основной' && $value['id_category']>10)) $value['my'] = true;
				$user['rows'] .= $templateHome->parse($modules_root."users/tpl/row_user.tpl", $value);
			}
		}

		
		if((!$request->getValue('portfolio') || $rights=='write') && $loggedIn ) {
            $user['tel'] = $portfolio_user['tel'];
			$user['email'] = $portfolio_user['email'];
			$user['is_student'] = $portfolio_user['is_student'];
			$user['is_empl'] = $portfolio_user['is_empl'];
			
			if(!$request->getValue('portfolio') || $rights=='write')	$user['my'] = true;
			//Вывод информации о машинах
/*			if(!$carsHome) $carsHome = new CarsHome($request);
			$cars = $carsHome->getCars($current_user['id']);
			foreach ($cars as $value) {
				$kpp = $carsHome->getCarToKpp($value['id']);
				foreach ($kpp as $item) {
					$tmp = $usersHome->getValue('user','id',$item['id_boss'],array('firstname','secondname','lastname'));
					$item['name_boss'] = $tmp['lastname'].' '.$tmp['firstname'][0].$tmp['firstname'][1].'. '.$tmp['secondname'][0].$tmp['secondname'][1].'.';
					$value['kpp'] .= $templateHome->parse($modules_root."cars/tpl/row_kpp.tpl", $item);
				}
				$value['noform'] = true;
				if($rights == 'write') $value['is_admin'] = true;
				$user['cars'] .= $templateHome->parse($modules_root."cars/tpl/row_car.tpl", $value);
			}
//*/
			
		}
		$exp = $portfolioHome->getUserExp($value['id_user']);
		if($exp) $user = array_merge($user, $exp);
		if(is_file('files/lk/photo/'.$user['id'].'.jpg')) {
			$user['is_foto'] = true;
		}
		if($portfolio_user['is_student']) $user['card'] = true;
		if($loggedIn) $user['auth'] = true;
		if($rights_card == 'write' || $rights_card == 'use') $user['no_card'] = false;
		else $user['no_card'] = true;
		$profile_type = $portfolioHome->getValues(false, false, 'profile_type', $portfolioHome->item_profile_type, 1, 'name DESC');
		foreach($profile_type as $item_profile) {
			$user['profile_type'] .= $templateHome->parse('core/templates/option_row.tpl',$item_profile);
		}
		$profile_list = $portfolioHome->getProfilesBy($id_portfolio);
		foreach($profile_list as $item_profile) {
			if(strstr($item_profile['profile_url'], 'pnzgu.ru')) $item_profile['profile_url'] = 'http://'.$item_profile['profile_url'];
			else $item_profile['profile_url'] = $item_profile['url'].'/'.$item_profile['profile_url'];
			$item_profile['id_profile'] = $item_profile['id'];
			if($loggedIn && $id_portfolio==$current_user['id']) $item_profile['del'] = true;
			$user['list_profile'] .= $templateHome->parse($modules_root."portfolio/tpl/table_profile.tpl", $item_profile);
		}
		if($id_portfolio == $current_user['id']) $portfolio['is_owner'] = $user['is_owner'] = true;
		if($rights == "write") {
			$user['admin'] = true;
			if(!$rights_dep) {
				$user['admin_all'] = true;	
			}
			$user['password'] = $portfolio_user['password'];
			$user['login'] = $portfolio_user['login'];
			$user['mayfer'] = $portfolio_user['mayfer'];
			$user['id_sphinx'] = $portfolio_user['id_sphinx'];
			$sp_dev = $portfolioHome->getSphinxDevList();
			if(is_array($sp_dev)) {
				$user_dev = $portfolioHome->getSphinxDevUser($portfolio_user['id_sphinx']);
				
				$i=0;
				foreach ($sp_dev as $value) {
					if($i==0) $user['row_dev'] .= '<tr  align="left">';
					if(in_array($value['id'], $user_dev)) $value['checked'] = true;
					$user['row_dev'] .= $templateHome->parse($modules_root."portfolio/tpl/sphinx_dev.tpl", $value);
					$i++;
					if($i==3) {
						$user['row_dev'] .= '</tr>';
						$i=0;
					}
				}
				if($i!=0) $user['row_dev'] .= '</tr>';
			}
			if($portfolio_user['mayfer_date_begin_unix']) $user['mayfer_date_begin'] = $portfolio_user['mayfer_date_begin'];
			else $user['mayfer_date_begin'] = date('d.m.Y', time());
			if($portfolio_user['mayfer_date_end_unix']) $user['mayfer_date_end'] = $portfolio_user['mayfer_date_end'];
			else $user['mayfer_date_end'] = date('d.m.Y', time()+192844800);
			//$portfolioHome->getSphinx($portfolio_user['id_sphinx']);
			//$sphinx = $portfolioHome->getSphinx('214');
			//var_dump($sphinx);
			
			//Управление правами
			$rights_list = $portfolioHome->getRightsByUser($id_portfolio);
			if($rights_list) {
				foreach ($rights_list as $value) {
					$value['rights'] = decbin($value['rights']);
					if($value['rights'][2]) $value['rights'] = "запись";
					elseif($value['rights'][1]) $value['rights'] = "использование";
					elseif($value['rights'][0] && $r != 'use') $value['rights'] = "чтение";
					$value['id_user'] = $id_portfolio;
					$user['row_rights'] .= $templateHome->parse($modules_root."portfolio/tpl/rights_row.tpl", $value);;
				}
			}
			$module_list = $portfolioHome->getValues(false,false,'modules', array('id','name','decription'),1);
			$user['module_rows'] = $functions->makeOption($module_list, 0);
		}

		if($portfolio_user['is_empl']) {
            $med_rights = $usersHome->checkRights($current_user['groups'], 59);
            if ($med_rights == 'use' || $med_rights == 'write') $user['med'] = true;
        }
		$user['is_deleted'] = $portfolio_user['is_deleted'];
		if(file_exists($files_dir."lk/photo/".$user['id'].".jpg")) {
			$user['show_ph1'] = true;
		}
		if(file_exists($files_dir."sphinx/".$user['id'].".jpg")) {
			$user['show_ph2'] = true;
		}
		if($rights == 'write' || ($rights_mil == 'write' || $rights_mil == 'use')) $user['fvo'] = true;
		//if($current_user['id'] == '31507538')  $module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/user_main.tpl", $user);
		//else $module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/user.tpl", $user);
        //if($rights == 'write') var_dump($portfolio_user);
        if($current_user['is_praepostor'] && $current_user['id'] == $id_portfolio) $user['is_praepostor'] = true;
        if($current_user['is_curator']) {
            foreach ($current_user['dep_list'] as $key => $value) {
                $parent_dep = $portfolioHome->getValue('id', $value, 'department', array('id_parent'), 2)['id_parent'];
                if(in_array($value, $portfolio_user['dep_list']) || in_array($parent_dep, $portfolio_user['dep_list'])) {
                    $user['is_curator'] = true;
                }
            }
        }

		$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/user_main.tpl", $user);
	

		//Вывод информации о документах
		$items = $portfolioHome->getListDoc('id_user', $id_portfolio);
		if($items) {
			foreach ($items as $value) {
				if($old_type!=$value['id_type']) {
					$old_type = $value['id_type'];
					$tmp = $portfolioHome->getDocType($value['id_type']);
					unset($tmp['id']);
					$value = array_merge($value,$tmp);
					unset($tmp);
				}
				$tmp = decbin($value['rights']);
				if(!$value['is_protected'] && ($tmp[2] || $id_portfolio==$current_user['id'] || $tmp[1] && $loggedIn)) {
					if($loggedIn && $id_portfolio==$current_user['id']) $value['my'] = true;
					$portfolio['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row.tpl", $value);
				}
			}
		}
		
		$module['text'].=$templateHome->parse($modules_root."portfolio/tpl/table.tpl", $portfolio);

		//Вывод информации о конференциях
		$items_types = $portfolioHome->getListConferenceType();
		foreach ($items_types as $value_type) {
			$type_header = explode('%', $value_type['header']);
			if(is_array($type_header)) {
				$tmp ='';
				$i=0;
				$item_type = array();
				foreach ($type_header as $value) {
					$i++;
					if($value) {
						$item_type['name']=$value;
						$item_type['field'.$i] = true;
						$tmp .= $templateHome->parse($modules_root."portfolio/tpl/row_conf_header.tpl", $item_type);
						unset($item_type['name']);
					}
				}
				$value_type['header'] = $tmp;
			}
			$items = $portfolioHome->getListConference('id_user', $id_portfolio, $value_type['id']);
			if($items) {
				
/*				if($value_type['id']==1) $value_type['header'] = "<tr align='center'><td>Название олимпиады</td><td>Место проведения</td><td>дата проведения</td><td>Результат</td><td>ссылка на офиц.сайт олимпиады</td>";
				if($value_type['id']==2) $value_type['header'] = "<tr align='center'><td>Название</td><td>Место проведения</td><td>дата проведения</td><td>Тема выступления</td><td>ссылка на офиц.сайт мероприятия</td>";
				if($value_type['id']==3) $value_type['header'] = "<tr align='center'><td>Название</td><td>Место проведения</td><td>дата проведения</td><td>Тема выступления</td><td>ссылка на офиц.сайт мероприятия</td>";
				if($value_type['id']==4) $value_type['header'] = "<tr align='center'><td>Название</td><td>Место проведения</td><td>дата проведения</td><td>Тема</td><td>ссылка на офиц.сайт мероприятия</td>";
				if($value_type['id']==5) $value_type['header'] = "<tr align='center'><td>Название</td><td>Место проведения</td><td>дата проведения</td><td>Тема</td><td>ссылка на офиц.сайт мероприятия</td>";
				if($value_type['id']==6) $value_type['header'] = "<tr align='center'><td>Название</td><td>Место проведения</td><td>дата проведения</td><td>Тема</td><td>ссылка на офиц.сайт мероприятия</td>";
				if($value_type['id']==7) $value_type['header'] = "<tr align='center'><td>Название</td><td>Авторы</td><td>Дата</td><td>Издательство</td><td>Ссылка на эл.версию</td>";
				*/
				foreach ($items as $value) {
					if($value['id_doc']) {
						$doc = $portfolioHome->getOneDoc('id',$value['id_doc']);
						$value['file_name'] = $doc['file_name'];
					}
					if(!$value['date_end_unix']) $value['date_end'] = '';
					$value = array_merge($value,$item_type);
					if($loggedIn && $id_portfolio==$current_user['id']) $value['my'] = true;
					if($value['id_level'] == '1') $value['level'] = 'ВАК';
					elseif($value['id_level'] == '2') $value['level'] = 'РИНЦ';
					elseif($value['id_level'] == '3') $value['level'] = 'Scopus';
					elseif($value['id_level'] == '4') $value['level'] = 'Web of Science';
					
					if($value['url'] && !stristr($value['url'], 'https') && !stristr($value['url'], 'http')) {
						$value['url'] = 'http://'.$value['url'];
					}
					if($value['url_eb'] && !stristr($value['url_eb'], 'https') && !stristr($value['url_eb'], 'http')) {
						$value['url_eb'] = 'http://'.$value['url_eb'];
					}
					$value_type['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_conf.tpl", $value);
				}
				$module['text'].=$templateHome->parse($modules_root."portfolio/tpl/table_conf.tpl", $value_type);
			}
		}
		// вывод информации об оценках
		if($is_student || $id_portfolio==$current_user['id']) {
			//Получение назвний оценок
			$tmp = $portfolioHome->getValues('is_deleted', 0, 'mark', array('id','rus'), 2);
			if($tmp) {
				$mark_name = array();
				foreach ($tmp as $value) {
					$mark_name[$value['id']] = $value['rus'];
				}
			}
			$tmp = $portfolioHome->getValues('is_deleted', 0, 'exam', array('id','id_moodle','name'), 2);
			if($tmp) {
				$exam_name = array();
				$exam_name_moodle = array();
				foreach ($tmp as $value) {
					$exam_name[$value['id']] = $value['name'];
					$exam_name_moodle[$value['id_moodle']] = $value['name'];
				}
			}
			foreach ($executions as $value) {
				if($value['id_category'] < 100) {
					//var_dump($value);
				$study_group = $usersHome->getStudyGroup( $value ['id_position'] );
				$subject = $cardHome->getAllMoodleSubject($study_group['id_spec'], $value['id_position']);
				foreach($subject as $subject_item) {
					//if($rights == 'write') var_dump($subject_item);
					if($current_user['is_show'] || $id_portfolio==$current_user['id'] || $rights == 'write') $subject_item['is_show'] = $is_show = true;
					//$subject_item['competence'] = $cardHome->getSubjectCompetence($subject_item['mdlcourse'])['competence'];
					$mark['is_show'] = $is_show;
					//Вывод имени группы
					$subject_item['name_group'] = $value['name_group'];
					//Курс и семестр
					$subject_item['course'] = $subject_item['agenum'].' курс';
					if($subject_item['semester']) {
						$subject_item['id_semestr'] = $subject_item['agenum']*2;
					} else {
						$subject_item['id_semestr'] = $subject_item['agenum']*2-1;
					}
					if(!$subject_item['competence']) $subject_item['competence'] = '-';
					//Получение Id предмета 					
					$id_subject = $portfolioHome->getValue('id_moodle', $subject_item ['mdlcourse'], 'study_subject', array ('id'),2);
//					$id_subject = $cardHome->getValues2 ( 'id_moodle', $subject_item ['mdlcourse'], false, false, 'study_subject', array ('id'), 0, '`id`');
					//Оценка из ЛК
					$ids_marks = $portfolioHome->getListMarkEsia($id_subject['id'], $id_portfolio, true);
					if($ids_marks) {
//						echo $subject_item['name'];
						//if($rights == 'write') var_dump($ids_marks);
						foreach($ids_marks as $id_mark) {
//							$subject_item['rus'] = $portfolioHome->getValue('id', $id_mark['id_mark'], 'mark', array('rus'), 2)['rus'];
//							$subject_item['mname'] = $portfolioHome->getValue('id', $id_mark['id_exam'], 'exam', array('name'), 2)['name'];
							$subject_item['rus'] = $mark_name[$id_mark['id_mark']];
							$subject_item['mname'] = $exam_name[$id_mark['id_exam']];
							$mark['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_mark.tpl", $subject_item);
						}
					} else {
						$subject_item['name'] .= '.';
						$mark_item = pitem_semester_processor($subject_item['programmitem_id'], $value['id_position'], $id_portfolio);
						//if($rights == 'write') var_dump($mark_item);
						$tmp = $mark_item[$subject_item['fsemester_type']];
                        if(!$subject_item ['fsemester_type'] && $subject_item ['semester']) $tmp = $mark_item[$subject_item ['semester']];
                        //if($rights == 'write') { var_dump($tmp); var_dump($exam_name);}
						if($mark_item) {
						foreach ($tmp as $type_mark => $rus) {
							$subject_item['rus']   = $rus['grade'];
							if($exam_name[$type_mark]) $subject_item['mname'] = $exam_name[$type_mark];
							else $subject_item['mname'] = $exam_name_moodle[$type_mark];
							/*
							switch ($type_mark) {
								case '1':
									$subject_item['mname'] = 'Экзамен';
									break;
								case '2':
									$subject_item['mname'] = 'Зачет';
									break;
								case '3':
									$subject_item['mname'] = 'Курсовая работа';
									break;								
								case '4':
									$subject_item['mname'] = 'Курсовой проект';
									break;							
								case '5':
									$subject_item['mname'] = 'Дифф.зачет';
									break;
								case '6':
									$subject_item['mname'] = 'Контрольная работа';
									break;
								case '7':
									$subject_item['mname'] = 'ИА';
									break;
								case '8':
									$subject_item['mname'] = 'Квалиф. экзамен';
									break;
							}*/
							if($rus['grade'] == 'н/я' && $rus['vrs'] == 1) $subject_item['rus'] = 'Оценка отсутствует';
							$mark['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_mark.tpl", $subject_item);
						}
						} else {
									$mark['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_mark.tpl", $subject_item);
						}
					}
					
					
				}
				}
			}
			/*$items = $cardHome->getMarkSubjectListByUser($id_portfolio);
			if($items && is_array($items)) {
				foreach ($items as $value) {
					//var_dump($value);
					if($value['is_show'] || $id_portfolio==$current_user['id'] || $rights == 'write') $value['is_show'] = $is_show = true;
					$spec = $usersHome->getSpec($value['id_spec']);
					$value['name_group'] = $usersHome->getStudyGroup($value['id_position'])['name'];
					$value['competence'] = $cardHome->getSubjectCompetence($value['id_moodle'])['competence'];
					$value['iddiv'] = $value['id_moodle'];
					$mark['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_mark.tpl", $value);
				}
				$mark['is_show'] = $is_show;
				
			}
			
			$list_moodle_mark = $cardHome->getMoodleMark($id_portfolio);
				
			if($list_moodle_mark && is_array($list_moodle_mark)) {
				foreach ($executions as $tmp) {
					$item_group[$tmp['id_spec']] = $tmp['name_group'];
					$item_group_id[$tmp['id_spec']] = $tmp['id_group'];
				}

				foreach ($list_moodle_mark as $item_moodle_mark) {
					if($rights=='write') {
					//	var_dump($item_moodle_mark);
					}
					
					//echo $rights;
					$mark_item = pitem_semester_processor($item_moodle_mark['id_dis'],$item_group_id[$item_moodle_mark['programmid']],$id_portfolio);
					//if($rights == 'write') { var_dump($item_moodle_mark); var_dump($mark_item); }
					$item_moodle_mark['mname'] = $otchet_type[($item_moodle_mark['controltype']-1)];
					$rus_mark = $item_moodle_mark['mark'];
						
					if($item_moodle_mark['semester_num']) {
						$item_moodle_mark['fsemester_type'] = $item_moodle_mark['semester_num'];
						$item_moodle_mark['id_semestr'] = $item_moodle_mark['agenum']*2;
					} else {
						$item_moodle_mark['id_semestr'] = $item_moodle_mark['agenum']*2-1;
						if($item_moodle_mark['fsemester_type']) $item_moodle_mark['id_semestr'] += 1;
					}
						
					$item_moodle_mark['name_group'] = $item_group[$item_moodle_mark['programmid']];
					
					$item_moodle_mark['course'] = $item_moodle_mark['agenum'].' курс.';
					
					//$tmp = $mark_item[$item_moodle_mark['semester_num']];
					
					$tmp = $mark_item[$item_moodle_mark['fsemester_type']];
					
					if($tmp[$item_moodle_mark['controltype']]['grade'] == 'н/я' && $tmp[$item_moodle_mark['controltype']]['vrs'] == 1) $item_moodle_mark['rus'] = 'Оценка отсутствует';
					else $item_moodle_mark['rus'] = $tmp[$item_moodle_mark['controltype']]['grade'];
					//if($rights=='write') var_dump($mark_item);
					/*
					if($item_moodle_mark['controltype']==2) {
						if(0<$rus_mark && $rus_mark<60) $item_moodle_mark['rus'] = 'не зачтено';
						elseif(60<=$rus_mark && $rus_mark<=100) $item_moodle_mark['rus'] = 'зачтено';
					} else {
						if(0<$rus_mark && $rus_mark<60) $item_moodle_mark['rus'] = 'неудовлетворительно';
						elseif(60<=$rus_mark && $rus_mark<73) $item_moodle_mark['rus'] = 'удовлетворительно';
						elseif(73<=$rus_mark && $rus_mark<87) $item_moodle_mark['rus'] = 'хорошо';
						elseif(87<=$rus_mark && $rus_mark<=100) $item_moodle_mark['rus'] = 'отлично';
					}
						*/
			/*		if($value['is_show'] || $id_portfolio==$current_user['id'] || $rights == 'write') $item_moodle_mark['is_show'] = $is_show = true;
					$item_moodle_mark['iddiv'] = $item_moodle_mark['mdlcourse'];
					//var_dump($item_moodle_mark);
					if($item_moodle_mark['name_group'])
					$mark['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_mark.tpl", $item_moodle_mark);
				}
			}*/
			//if($items || $list_moodle_mark) 
			$module['text'].=$templateHome->parse($modules_root."portfolio/tpl/table_mark.tpl", $mark);
		}
		//вывод информации о Курсовых
		$items = $portfolioHome->getListKursThemeMdl($id_portfolio);
		//if($rights=='write') var_dump($items);
		if($items && is_array($items)) {
			$exist = true;
			foreach ($items as $value) {
				$kurs['rows_mdl'] .= $templateHome->parse($modules_root."portfolio/tpl/row_kurs_mdl.tpl", $value);
			}
		}
		
		$items = $portfolioHome->getListKurs($id_portfolio);
		//var_dump($items);
		if($items && is_array($items)) {
			$exist = true;
			foreach ($items as $value) {
				//var_dump($value);
				if($value['grade'] < 0) $value['grade'] = '';
				if($rights != 'write') $value['comment'] = '';
				/*$list_comment = $portfolioHome->getValues('id_kurs', $value['contextid'], 'comment_kurs', array('id', 'id_owner', 'text', 'is_moderation', 'date_create', 'date_begin'), 1);
				if($list_comment && is_array($list_comment)) {
					foreach($list_comment as $item_comment) {
						$owner_name = $portfolioHome->getValue('id', $item_comment['id_owner'], 'user', array('firstname', 'secondname', 'lastname'), 2);
						if($owner_name) {
							$commenter_name = '<a href="/portfolio/'.$item_comment['id_owner'].'" target="_blank">'.$owner_name['lastname'].' '.$owner_name['firstname'].' '.$owner_name['secondname'].'</a>';
						} else {
							$commenter_name = 'Гость';
						}
						//var_dump($owner_name);
						if($rights == 'write') {
							$value['list_comment'] .= $commenter_name.' ['.$item_comment['date_create_date'].']: '.$item_comment['text'];
							if(!$item_comment['is_moderation']) $value['list_comment'] .= '&nbsp;<a href="/portfolio/'.$id_portfolio.'/comment_kurs/'.$item_comment['id'].'/ok" onclick="if(!confirm(\'Вы уверены, что хотите одобрить комментарий?\')) return false;">Одобрить</a>';
							else $value['list_comment'] .= ' - <a href="/portfolio/'.$id_portfolio.'/comment_kurs/'.$item_comment['id'].'/cancel" onclick="if(!confirm(\'Вы уверены, что хотите отменить одобрение?\')) return false;">Отменить одобрение</a>';
							$value['list_comment'] .= ' - <a href="/portfolio/'.$id_portfolio.'/comment_kurs/'.$item_comment['id'].'/del" onclick="if(!confirm(\'Вы уверены, что хотите навсегда удалить комментарий?\')) return false;">Удалить</a>';
						} else {
							if($item_comment['is_moderation'] == 1) {
								$value['list_comment'] .= $commenter_name.' ['.$item_comment['date_create_date'].']: '.$item_comment['text'];
							}
						}
						$value['list_comment'] .= '<br>';
					}
				}*/
				$comment_row = makeComment($value['contextid'], 1, $id_portfolio, $portfolioHome, $rights);
				//var_dump($comment_row);
				$value['list_comment'] .= $comment_row['list'];
				$value['is_show'] = $comment_row['is_show'];
				$kurs['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_kurs.tpl", $value);
			}
		}
		
		if($exist) $kurs['rows_exist'] = true;
		$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/table_kurs.tpl", $kurs);
		unset($exist);
		//вывод информации о публикациях в ЭБ
		//$lib = array();
		$items = $portfolioHome->getListLib($id_portfolio);
		if($items && is_array($items)) {
			foreach ($items as $value) {
				//if($rights=='write') var_dump($value);
				$value['row_lib'] = true;
				$value['irtype'] = $portfolioHome->getValue('id', $value['id_resource_type'], 'resource_types', array('name'), '5')['name'];
				$lib['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_lib.tpl", $value);
			}
			
		}
		$items = $portfolioHome->getListLib($id_portfolio, true);
		//if($rights=='write') var_dump($items);
		if($items && is_array($items)) {
			foreach ($items as $value) {
				$value['row_libdoc'] = true;
				$value['doctype'] = $portfolioHome->getValue('id', $value['id_type'], 'doc_type', array('name'), '5')['name'];
				$comment_row = makeComment($value['id'], 2, $id_portfolio, $portfolioHome, $rights);
				//var_dump($comment_row);
				$value['list_comment'] .= $comment_row['list'];
				$value['is_show'] = $comment_row['is_show'];

				$lib['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_lib.tpl", $value);
			}
		}
		//echo $lib['rows'];
		$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/table_lib.tpl", $lib);

		//вывод информации о Посещаемости
		if($portfolio['is_owner'] || $rights == 'write' || $rights == 'use') {
			$item_list = $portfolioHome->getPresensByUser($id_portfolio);
			if($item_list && is_array($item_list)) {
				foreach ($item_list as $value) {
					if(!$value['date_unix']) $value['date_date'] = $value['date_create'];
					if(!$value['name']) $value['name'] = $value['name_user'];
					if($value['type']==1) $value['name'] .= " выход"; 
					elseif($value['type']==2)$value['name'] .= " вход";
					elseif($value['type']==3)$value['name'] .= " неопределено";
					$presence['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_presence.tpl", $value);
				}
			}
			
			$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/table_presence.tpl", $presence);		
		}
		//вывод информации о взятых изданиях
		if($portfolio['is_owner'] || $rights == 'write' || $rights == 'use') {
			$item_list = $portfolioHome->getBookByUser($id_portfolio);
			if($item_list && is_array($item_list)) {
				foreach ($item_list as $value) {
					if(!$value['date_unix'] && $value['date_end_unix']<date('U')) {
						$value['att'] = true;
					}
					$book['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/row_book.tpl", $value);
				}
			}
			$module['text'] .= $templateHome->parse($modules_root."portfolio/tpl/table_book.tpl", $book);		
		}
		
	} elseif($request->getValue('study_cource')) {
		$item_list = $usersHome->getSpecCource($request->getValue('study_cource'));
		if($item_list) {
			$module['text'].= '<table>';
			foreach ($item_list as $item) {
				$item['category'] = true;
				$item['id_user'] = $id_portfolio;
				$module['text'].=$templateHome->parse($modules_root."portfolio/tpl/subject_list.tpl", $item);
			}
			$module['text'].= '</table>';
		} else {
			$item_list = $usersHome->getSpecSubjects($request->getValue('study_cource'));
			if($item_list) {
				$module['text'].= '<table>';
				foreach ($item_list as $item) {
					$tmp = $usersHome->getTeacher($item['id']);
					$item['id_teacher'] = $tmp['id'];
					$item['name_teacher'] = $tmp['sortname'];
					$item['id_user'] = $id_portfolio;
					$module['text'].=$templateHome->parse($modules_root."portfolio/tpl/subject_list.tpl", $item);
				}
				$module['text'].= '</table>';
			}
		}
	} elseif($request->hasValue('study_group')) {
		//Вывод дополнительныйх настроек
		if(($rights=='write' || $rights_card=='write' || $rights_card=='use') && !$request->hasValue('print')) {
			if($request->hasValue('dop')) 	$dop['is_dop'] = true;
			else 							$dop['is_dop'] = false;
            $list_users['is_pass'] = true;
			if($rights_card=='write' && in_array($item_group['id_department'], $current_user['dep_list'])) {
				$dop['is_pass'] = true;
				if($request->hasValue('pass') && $rights_card=='write')	$dop['pass'] = true;
				else 							$dop['pass'] = false;
			} else {
				$dop['pass'] = false;
				$dop['is_pass'] = false;
			}
			$dop['link'] = $request->variables['query'];
			//$module['text'].=
            $list_users['select_dop'] = $templateHome->parse($modules_root."portfolio/tpl/select_dop.tpl", $dop);
		}

		//Вывод списка одной группы
		if($request->getValue('study_group')) {
			if($item_group && $item_group['is_hidden'] && $rights!='write' && $rights!='use' && $rights_card!='write') {
				$module['text'].= "За информацией о группе следует обращаться в деканат";
			} else {
				$item_list = $portfolioHome->getUserList($request->getValue('study_group'));
				if($item_list) {
					$i=1;
					//$module['text'].= "<table class='ispgut'>";
					if($request->hasValue('print')) {
						//$module['text'].= "<table class='ispgut' style='font-size: 18px !important;'><tr align='center'><td>ФИО</td><td>\"Логин\" - \"Пароль\"</td><td>Подпись</td>";
                        $list_users['print'] = true;
					} else {
						//$module['text'].= "<table class='ispgut'>";
                        $list_users['print'] = false;
					}
					foreach ($item_list as $item) {
						$item['i'] = $i++.'. ';
						if($item['id_category']<10) $item['card'] = true;
						if($loggedIn) $item['auth'] = true;
						if(!$item['is_empl'] && $rights_card=='write' && $request->hasValue('pass') && (!$rights_card_dep ||  in_array($item_group['id_department'], $current_user['dep_list']))) {
							$item['pass'] = true;
						}
						if($rights=='write' || $rights_card=='write' || $rights_card=='use') {
							if(!$item['rate']) $item['rate'] = ' - договор'; else $item['rate'] = '';
							$debt = $portfolioHome->getDebt($item['id_user']);
							if($debt['debt']) $item['rate'] .= ' <b>(долг: '.$debt['debt'].')</b>';
							$presence = $portfolioHome->getPresensByUser($item['id_user'],1);
							if($presence) {
								$item['presence'] = $presence[0]['date_create'].' '.$presence[0]['name'].$presence[0]['name_user'];
							}
							$ippr = $portfolioHome->getUserIPPR($item['id_user'], $item['id']);
							if(!$ippr['id']) $item['noippr'] = true;
							if($rights=='write') {
								$id_spec = $portfolioHome->getValue('id', $request->getValue('study_group'), 'user_study_group', array('id_spec'), 2);
								$nomarks = $portfolioHome->getControlMark($item['id'], $item['id_user'], $item['id_position'], $id_spec['id_spec'], $cardHome);
							}
							/*$list_moodle_mark = $cardHome->getMoodleMark($item['id_user']);
							if($list_moodle_mark) {
								if($rights=='write') var_dump($list_moodle_mark);
								foreach ($list_moodle_mark as $item_moodle_mark) {

									$mark_item = pitem_semester_processor($item_moodle_mark['id_dis'],$request->getValue('study_group'),$item['id_user']);
									//echo $item_moodle_mark['id_dis'].'-'.$request->getValue('study_group').'-'.$item['id_user'].'<br>';
									$tmp = $mark_item[$item_moodle_mark['semester_num']];

									if(!$tmp[$item_moodle_mark['controltype']]) {
										$item['nomark'] .= $item_moodle_mark['name'].' ('.$otchet_type[($item_moodle_mark['controltype']-1)].') ';
									}
								}
							}*/
							
						} else {
							$item['rate'] = '';
						}
						if($use_anketa && ($rights_anketa=='use' || $rights_anketa=='write')) {
							$tmp = $anketaHome->getCountUser($item['id_user']);
							$item['anketa_user'] = $tmp['countid'];
							$tmp = $anketaHome->getAnketaUser($item['id_user']);
							foreach ($tmp as $value) {
								$item['anketa_url_user'] .= "<a target='_blank' href='/anketa/a_type/".$value['id_type']."/quest/stat'>+</a> ";
							}
						}
						if($request->hasValue('dop')) $item['is_dop'] = true;
						else $item['is_dop'] = false;	
						//$module['text'].=
                        $list_users['rows'] .= $templateHome->parse($modules_root."portfolio/tpl/user_list.tpl", $item);
					}
					//$module['text'].= "</table>";
                    $list_users['list_curator'] = $functions->makeOption($portfolioHome->getNps($item_group['id_department'],$item_group['id_department'], true, '`user`.`lastname`,`user`.`firstname`'), $item_group['id_curator']);
                    $list_users['id_group'] = $request->getValue('study_group');
                    $module['text'].=$templateHome->parse($modules_root."portfolio/tpl/table_user_list.tpl", $list_users);
				}
			}
		} else {
			//Вывод списков групп
			$item_list = $usersHome->getStudyGroupList();
			if($item_list) {
				$count_all = 0;
				$count_course = 0;
				foreach ($item_list as $item) {
					if($request->hasValue('dop')) $item['is_dop'] = true;
					else $item['is_dop'] = false;
					if($item['name_department']!='' || $rights = 'write') {
						if($item['course']==$old_cource) {
							$item['course'] ='';
						} else {
							$old_cource = $item['course'];
							if($count_course) {
								$module['text'].= "<br>Всего по курсу: ".($count_course)."<br>";
								$count_course = 0;
							}
						}
							
						if($item['name_department']==$old_name) {
							$item['name_department'] ='';
						} else {
							$old_name = $item['name_department'];
							if($count_all) {
								$module['text'].= "<br>Всего по подразделению: ".($count_all)."<br>";
								$count_all = 0;
							}
						}
							
						if($rights=='write' || $rights_card=='write') unset($item['is_hidden']);
						if($count_course) $module['text'].= ", ";
						$module['text'].=$templateHome->parse($modules_root."portfolio/tpl/row_group.tpl", $item);
							
						$count_course++;
						$count_all++;
					}
				}
				if($count_course) {
					$module['text'].= "<br>Всего по курсу: ".($count_course)."<br>";
				}
				if($count_all) {
					$module['text'].= "<br>Всего по подразделению: ".($count_all)."<br>";
				}
			}
		}
	} elseif($request->hasValue('employees') && ($request->hasValue('sveden') || $request->hasValue('dep') ||$request->hasValue('pardep') )) {
		if($item_domen['id_site']!=1 && !$request->hasValue('dep')) {
			$site = $portfolioHome->getSite(false, $item_domen['id_site']);
			$id_dep = $site['id_dep'];
			//$id_pardep = $site['id_dep'];
			$all = 1;
		} else {
			$id_dep = $request->getValue('dep');
			$id_pardep = $request->getValue('pardep');
			$all = $request->hasValue('all');
		}
		$list_nps = $portfolioHome->getNps($id_dep,$id_pardep,$all);
		$list = array();
		$i=0;
		outNps($list_nps, $list, $i, $all);
		if($request->getValue('query') == 'sveden/employees') {
			require_once($modules_root."pages/class/PageHome.class.php");
			if(!$pageHome) $pageHome = new PageHome($request, $session, $functions);
			$page = $pageHome->getBy('url','/'.$request->getValue('query'),0, 1);
			$module['text'].= $page['content'];
		}
		$module['text'].= $templateHome->parse($modules_root."portfolio/tpl/table_nps.tpl", $list);
	} elseif($request->hasValue('employees')) {
		$site = $portfolioHome->getSite(false, $item_domen['id_site']);
		$list_dep = $portfolioHome->getDep($site['id_dep']);
		$list_nps = $portfolioHome->getNps($site['id_dep'],0,1);
		$list = array();
		$i = 0;
		outNps($list_nps, $list, $i, 1);
		foreach ($list_dep as $value1) {
			$list_nps = $portfolioHome->getNps($value1['id'],0,1);
			outNps($list_nps, $list, $i, 1);
		}
		$module['text'].= $templateHome->parse($modules_root."portfolio/tpl/table_nps.tpl", $list);
	} elseif($request->hasValue('struct')) {
		if($item_domen['id_site']!=1) {
			$site = $portfolioHome->getSite(false, $item_domen['id_site']);
			$id_dep = $site['id_dep'];
		} else {
			$id_dep = $request->getValue('dep');
		}
		$list = $portfolioHome->getDep($id_dep);
		foreach ($list as $value) {
			if($value['level']) {
				for($i=0;$i<$value['level'];$i++) {
					$value['level_str'] .= ' &nbsp; &nbsp; ';
				}
			}
			$site = $portfolioHome->getSite($value['id']);
			if($site) {
				$value['site'] = $templateHome->parse($modules_root."portfolio/tpl/row_dep_site.tpl", $site);
				$boss = $portfolioHome->getOneUser($site['id_boss']);
				if($boss) {
					$value['boss'] = $templateHome->parse($modules_root."portfolio/tpl/row_dep_boss.tpl", $boss);
				}
			}
			$list['rows'].= $templateHome->parse($modules_root."portfolio/tpl/row_dep.tpl", $value);
		}
		$module['text'].= $templateHome->parse($modules_root."portfolio/tpl/table_dep.tpl", $list);
	} elseif($request->hasValue('contact')) {
		$site = $portfolioHome->getSite(false, $item_domen['id_site']);
		$boss = $portfolioHome->getOneUser($site['id_boss']);
		if($boss) {
			$site['boss'] = $templateHome->parse($modules_root."portfolio/tpl/row_dep_boss.tpl", $boss);
		}
		$module['text'].= $templateHome->parse($modules_root."portfolio/tpl/contact.tpl", $site);
		require_once($modules_root."pages/class/PageHome.class.php");
		if(!$pageHome) $pageHome = new PageHome($request, $session, $functions);
		$page = $pageHome->getBy('url','/contact',0, $item_domen['id_site']);
		$module['text'].= $page['content'];
	} elseif($request->hasValue('ippr') && ($rights == 'write' || $current_user['id']==$id_portfolio)) {
		$ip = $portfolioHome->getUserIPPR($id_portfolio, $request->getValue('ippr'));
		$executions = $usersHome->getExecutions($id_portfolio, true);
		foreach ($executions as $item_exec) {
			if($item_exec['id'] == $request->getValue('ippr')) {
				$ip['dep'] = $item_exec['name_department'];
				$ip['name'] = $item_exec['name'];
				$ip['programmitem'] = $item_exec['spec_name'];
				$ip['id_exec'] = $item_exec['id'];
			}			
		}
		$contact = $portfolioHome->getUserContact($id_portfolio);
		$ip['contact'] = $contact['email'].', '.$contact['tel'];
		$ip['id_user'] = $id_portfolio;
		if($rights == 'write' || $current_user['id']==$id_portfolio) $ip['admin'] = true;
		$add_plan_list = $portfolioHome->getUserIPPRPlan($ip['id']);
		if($add_plan_list && is_array($add_plan_list)) {
			foreach ($add_plan_list as $item_plan_event) {
				if($request->hasValue('edit')) $item_plan_event['is_edit'] = true;
				else $item_plan_event['is_edit'] = false;
			 	$ip['add_plan_list'] .= $templateHome->parse($modules_root."portfolio/tpl/row_plan_event.tpl", $item_plan_event);
			} 
		}
        $ip["work_date_begin"] = date("d.m.Y", $ip["work_date_begin"]);
        $ip["dpo_date_begin"] = date("d.m.Y", $ip["dpo_date_begin"]);
        $ip["work_date_begin2"] = date("d.m.Y", $ip["work_date_begin2"]);
        $ip["dpo_date_begin2"] = date("d.m.Y", $ip["dpo_date_begin2"]);
		if($request->hasValue('add') || $request->hasValue('edit')) {
			$module['text'].= $templateHome->parse($modules_root."portfolio/tpl/form_ip.tpl", $ip);
		} else {
			$module['text'].= $templateHome->parse($modules_root."portfolio/tpl/table_ip.tpl", $ip);
		}
	} elseif(!$module['text']) {
		//Вывод списка пользователей
		$search_pars = array(
			'1'=> array('student','is_student','1',array('2','15','16'),'all'),
			'2'=> array('empl','is_empl','1',array('1','15','16','18'),'all'),
			'3'=> array('active','is_deleted','0',array('4'),'use',$rights_card),
			'4'=> array('deleted','is_deleted','1',array('3'),'use',$rights_card),
			'5'=> array('male','sex','1',array('6'),'all'),
			'6'=> array('female','sex','0',array('5'),'all'),
			'7'=> array('dep','id_department','-1',array('8','9','10'),'all'),
			'8'=> array('course','course','-1',array('7','9','10'),'all'),
			'9'=> array('search_text','name','-1',array('7','8','9','10'),'all'),
			'10'=> array('category','id_category','-1',array('7','8','9'),'all'),
			'11'=> array('full_list',null,null,null,'use',$rights_card),
			'12'=> array('russian','russian','1',array('13'),'use',$rights_card),
			'13'=> array('foreign','foreign','1',array('12'),'use',$rights_card),
			'14'=> array('dop',null,null,null,'write',$rights_card),
			'15'=> array('abt','is_abt','1',array('1','2','16'),'use',$rights_card),
			'16'=> array('zach','zach','1',array('1','2','15'),'use',$rights_card),
			'17'=> array('pass',null,null,null,'write',$rights_card),
			'18'=> array('goal','is_goal','1',array('2'),'use',$rights),
			'19'=> array('number',null,null,null,'use',$rights)
		);
		$par = array();
		foreach ($search_pars as $key => $val) {
			if($val[2]>=0 && $request->hasValue($val[0]) || $val[2]<0 && $request->getValue($val[0])) {
				if($val[2]<0) {
					$value['noshow'] = true;
					$tmp = addslashes(stripcslashes($request->getValue($val[0])));
					$par = array_merge( array( $val[1] => $tmp ), $par );
				} else {
					$par = array_merge( array( $val[1] => $val[2] ), $par );
				}
				$portfolioHome->setURL($key, $val[0]);
				if($val[2]>=0) $value[$val[0]] = true;
			}
		}
		foreach ($search_pars as $key => $val) {
			if($val[2]<0) $val[0] = null;
			$value['url'.$key] = $portfolioHome->getURL($key,$val[3],$val[0]);
			if($val[4]=='all' || $val[5]==$val[4] || $val[5]=='write')	$value['u'.$key]=true;
		}

		if($request->getValue('search_text')) {
			$value['search_text'] = stripcslashes($request->getValue('search_text'));
		}
		//Форма поиска
		$dep_list = $portfolioHome->getDepList();
		$value['dep_list'] = $functions->makeOption($dep_list,$request->getValue('dep'));
		$course_list = $portfolioHome->getCourseList();
		$value['course_list'] = $functions->makeOption($course_list,$request->getValue('course'));
		$category_list = $portfolioHome->getValues(null,null,'user_execution_category',array('id','name'),2);
		$value['category_list'] = $functions->makeOption($category_list,$request->getValue('category'));
		if($loggedIn && ($rights=='write' || $rights=='use')) $value['loggedIn'] = true;
		if(($rights == 'write' || $rights == 'use') && !$request->hasValue('print')) {
			if($request->hasValue('dop')) $dop['is_dop'] = true;
			else $dop['is_dop'] = false;
			//$dop['list'] = true;
//			$dop['link'] = $_SERVER['REQUEST_URI'];
			//$module['text'].=$templateHome->parse($modules_root."portfolio/tpl/select_dop.tpl", $dop);
		}
		if($request->hasValue('dop')) $value['is_dop'] = true;
		else $value['is_dop'] = false;
		if($request->hasValue('full_list')) $value['full_list'] = true;
		else $value['full_list'] = false;
		$value['link'] = $_SERVER['REQUEST_URI'];
		if($request->hasValue('dep') && $request->getValue('dep')) $value['dep'] = $request->getValue('dep');
		//if($request->hasValue('search_text') && $request->getValue('search_text')) $value['search_text'] = $request->getValue('search_text');
		if($rights=='write') { $value['admin'] = true; }
		$module['text'].=$templateHome->parse($modules_root."portfolio/tpl/user_search.tpl", $value);
		$count_users = $portfolioHome->getCountUserPages($par,$rights_card);
		if($count_users) {
			if($request->getValue('p')) {
				$begin = $request->getValue('p')*25-25;
			}
			if($request->hasValue('full_list')) $users = $portfolioHome->getListUserPages($par,0,$count_users['cnt'],$rights_card);
			else $users = $portfolioHome->getListUserPages($par,$begin,25,$rights_card);
			if($users) {
				if($request->hasValue('search_text') && !$request->getValue('search_text')) unset($request->variables['search_text']);
				$module['text'].= '<div class="no-print" style="padding: 10px 0;">'."Всего: ".$count_users['cnt'].'</div>';
				if(!$request->hasValue('full_list')) $module['text'].= '<div class="no-print" style="padding-bottom: 10px;">'.$functions->PagesList($count_users['cnt'],25).'</div>';
				$module['text'].= "<table>";
				foreach ($users as $value) {
					if($value['is_student']) $value['card'] = true;
					if($loggedIn) $value['auth'] = true;
					//Вывод дополнительной информации
					if($request->hasValue('dop')) {
						//Участие в анкетировании
						if($use_anketa && ($rights_anketa=='use' || $rights_anketa=='write')) {
							if($value['is_empl']) {
								$tmp = $anketaHome->getCountTeacher($value['id_user']);
								$value['anketa'] = $tmp['countid'];
								$tmp = $anketaHome->getAnketaTeacher($value['id_user']);
								foreach ($tmp as $item) {
									$value['anketa_url'] .= "<a target='_blank' href='/anketa/a_type/".$item['id_type']."/id_teacher/".$value['id_user']."/quest/stat'>+</a>";
								}
							}
							if($value['is_student']) {
								$tmp = $anketaHome->getCountUser($value['id_user']);
								$value['anketa_user'] = $tmp['countid'];
								$tmp = $anketaHome->getAnketaUser($value['id_user']);
								foreach ($tmp as $item) {
									$value['anketa_url_user'] .= "<a target='_blank' href='/anketa/a_type/".$item['id_type']."/quest/stat'>+</a> ";
								}
							}
						}
						//Платные студенты
						if($value['is_student'] && ($request->hasValue('dop') || $request->hasValue('course') || $request->hasValue('category')) && ($rights=='write' || $rights_card=='use' || $rights_card=='write'))  {
							if(!$value['rate']) $value['rate'] = ' - <img src="/images/debtb.png" title="Обучение по договору" width="20">'; else $value['rate'] = '';
							$debt = $portfolioHome->getDebt($item['id_user']);
							if($debt['debt']) $value['rate'] .= ' <img src="/images/debtr.png" title="Долг за обучение: '.$debt['debt'].'" width="20">';
						}
						/*
						 $presence = $portfolioHome->getPresensByUser($item['id_user'],1);
						 if($presence) {
						 $item['presence'] = $presence[0]['date_create'].' '.$presence[0]['name'].$presence[0]['name_user'];
						 }
						 	
						 $ippr = $portfolioHome->getUserIPPR($item['id_user'], $item['id']);
						 if(!$ippr['id']) $item['noippr'] = true;
						 if($rights=='write') {
						 $id_spec = $portfolioHome->getValue('id', $request->getValue('study_group'), 'user_study_group', array('id_spec'), 2);
						 $nomarks = $portfolioHome->getControlMark($item['id'], $item['id_user'], $item['id_position'], $id_spec['id_spec'], $cardHome);
						 }
						 	
						 */
						$value['is_dop'] = true;
					} else {
					 	$value['is_dop'] = false;
					}
					if($rights=="write" && !$rights_dep && $request->hasValue('pass')
						|| !$value['is_empl'] && $rights_card=='write' && $request->hasValue('pass')  
						&& ($rights_card_dep==='0'  || in_array($value['id_department'], $current_user['dep_list']))) {
						$value['pass'] = true;
					} else $value['pass'] = false;
					if(($rights=='write' || $rights=='use') && $request->hasValue('number')) {
						$value['number'] = true;
					} else $value['number'] = false;
					$module['text'].=$templateHome->parse($modules_root."portfolio/tpl/user_list.tpl", $value);
				}
				$module['text'].= "</table>";
				if(!$request->hasValue('full_list')) $module['text'].= '<div class="no-print" style="padding: 10px 0;">'.$functions->PagesList($count_users['cnt'],25).'</div>';
			} else {
				$module['text'].= "<div><center><br><br><b>По вашему запросу информация не найдена</b><br><br></center></div>";
			}
		}
	}

	//print style injection
    if($request->hasValue('print')) {
        $module['text'].=$templateHome->parse($modules_root."portfolio/tpl/print_injection.tpl", null);
    }
    else{
        $str = $_SERVER['REQUEST_URI'];
        $pos = mb_strpos($str, "?");
        $strUri = "";
        if($pos){
            $strUri = mb_substr($str, 0, $pos).'print'.mb_substr($str, $pos, mb_strlen($str));
        }
        else{
            $strUri = rtrim($_SERVER['REQUEST_URI'], '/').'/print';
        }


        $module['text'].= '<br><div class="no-print"><a href="'.$strUri.'" target="_blank">Печать</a></div>';
    }
}
?>