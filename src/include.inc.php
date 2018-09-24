<?php
require_once ($modules_root . "portfolio/class/PortfolioHome.class.php");
require_once($modules_root."users/class/UsersHome.class.php");

if(!$usersHome)	$usersHome = new UsersHome($request);
if(!$portfolioHome)	$portfolioHome = new PortfolioHome($request);

	if($request->getValue('portfolio')) {
		$id_portfolio = $request->getValue('portfolio');
		$portfolio_user = $usersHome->getBy('id',$id_portfolio, -1);
	} elseif($current_user) {
		$id_portfolio = $current_user['id'];
		$portfolio_user = $current_user;
	}
	if($portfolio_user && ($request->hasValue('my') || $id_portfolio != $current_user['id'] || $request->getValue('portfolio'))) {
		$module['title'] = 'Портфолио. '.$portfolio_user['name'];
		if($request->hasValue('ippr')) {
			$module['title'] .= '. Индивидуальный план персонального развития выпускника';
		}
		if($request->hasValue('resume')) {
			$module['title'] .= '. Резюме';
		}
	} elseif($request->hasValue('contact')) {
		$module['title'] = 'Контактная информация';
	} elseif($request->hasValue('employees')) {
		if($request->hasValue('all') || $item_domen['id_site']!=1) {
			$module['title'] = 'Сотрудники';
		} else {
			$module['title'] = 'Руководство. Педагогический (научно-педагогический) состав';
		}
	} elseif($request->hasValue('struct')) {
		$module['title'] = 'Структура';
	} elseif($request->hasValue('room')) {
		$module['title'] = 'Посещаемость ';
		if($request->getValue('room')) {
			$item = $portfolioHome->getRoomById($request->getValue('room'));
			if($item) {
				$module['title'] .= $item['name']; 
			}
		}
	} elseif($request->hasValue('study_group')) {
		$module['title'] = 'Список учебных групп';
	} else {
		$module['title'] = 'Портфолио';
	}
	if($request->getValue('study_group')) {
		$item_group = $usersHome->getStudyGroup($request->getValue('study_group'));
		$module['title'] = 'Группа '.$item_group['name'];
		if($request->hasValue('print')) $module['title'] .= ". Ведомость выдачи паролей"; 
		if($item_group['is_hidden']) $module['title'] .= ' (закрытая информация)';
	} 
	if($request->getValue('id_meet')) {
		if(!$meet_item) $meet_item = $portfolioHome->getMeet($request->getValue('id_meet'));
		//if($rights=='write') var_dump($meet_item);
		if($meet_item) $module['title'] .= '. '.$meet_item['name'];
	}
	
?>