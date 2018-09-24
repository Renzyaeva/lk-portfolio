<?php
require_once ($modules_root . "portfolio/class/PortfolioHome.class.php");
if(!$portfolioHome)	$portfolioHome = new PortfolioHome($request);
require_once("core/lib/vendor/phpoffice/phpword/bootstrap.php");
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;

if($request->hasValue('au')) {

}
//var_dump($request);
if ($loggedIn) {
	if ($request->hasValue('adddoc') && $request->hasValue('save')) {
		$item = $functions->getForm($portfolioHome->item_doc);
		$item['id_user'] = $current_user['id'];
		if($item['date_begin']) {
			$date = explode('.', $item['date_begin']);
			if(is_array($date)) {
				$item['date_begin'] = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
			}
		}
		if($item['date_end']) {
			$date = explode('.', $item['date_end']);
			if(is_array($date)) {
				$item['date_end'] = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
			}
		}
		
		$item['date'] = date('U');
		if($_FILES['upload_file']['name']){
			$file_ext =  strtolower(strrchr($_FILES['upload_file']['name'],'.'));
			$file_name = $functions->imagename();
			$item['file_name'] = $file_name.$file_ext;
		}
		
		$id_doc = $portfolioHome->saveDoc($item);
		
		if($_FILES['upload_file']['name']){
			$file_ext =  strtolower(strrchr($_FILES['upload_file']['name'],'.'));
			$uploaddir = 'files/lk/docs/';
			$uploadfile  = $uploaddir.$id_doc.$file_name.$file_ext;
			$uploadfile_to_base  = $file_name.$file_ext;
			move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadfile);
		}
		$response->redirect('/portfolio/my');
	} elseif ($request->hasValue('addconf') && $request->hasValue('save')) {
		$item = $functions->getForm($portfolioHome->item_confernce);
		$item['id_user'] = $current_user['id'];
		if($item['date_begin']) {
			$date = explode('.', $item['date_begin']);
			if(is_array($date)) {
				$item['date_begin'] = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
			}
		}
		if($item['date_end']) {
			$date = explode('.', $item['date_end']);
			if(is_array($date)) {
				$item['date_end'] = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
			}
		}
		
		$item['date'] = date('U');
		if($item['url']) $item['url'] = str_ireplace('http://', '', $item['url']);
		$id_conf = $portfolioHome->saveConference($item);
		$response->redirect('/portfolio/my');
	} elseif($request->hasValue('savetel')) {
		if($current_user['id']==$request->getValue('portfolio')) {
			$user = $functions->getForm(array('tel'));
			$user['id'] = $current_user['id'];
			$portfolioHome->save_esia_par($user, array('tel'));
			$portfolioHome->saveMoodleUserPhone($user['id'], $user['tel']);
			$response->redirect('/portfolio/my');
		}
	} elseif($request->hasValue('saveemail')) {
		if($current_user['id']==$request->getValue('portfolio')) {
			$user = $functions->getForm(array('email'));
			$user['id'] = $current_user['id'];
			$portfolioHome->save_esia_par($user, array('email'));
			$portfolioHome->saveMoodleUserEmail($user['id'], $user['email']);
			$response->redirect('/portfolio/my');
		}
	} elseif($request->hasValue('showdopinfo')) {
		if($current_user['id']==$request->getValue('portfolio')) {
			$user = $functions->getForm(array('is_show'));
			if(!$user['is_show']) $user['is_show']='0';
			$user['id'] = $current_user['id'];
			$portfolioHome->save_esia_par($user, array('is_show'));
			$list_profile = $request->getValue('id_profile');
			$url_profile = $request->getValue('url_profile');

			for($i=0; $i<count($list_profile); $i++) {
				$profile['id_user'] = $current_user['id'];
				if(strstr($url_profile[$i], 'pnzgu.ru')) {
					$tmp = explode('//', $url_profile[$i]);
					if(is_array($tmp) && $tmp[1]) $profile['profile_url'] = $tmp[1];
					else $profile['profile_url'] = $url_profile[$i];
				} else {
					if($tmp0 = strstr($url_profile[$i], '.')) {
						$tmp = explode('/', $tmp0);
						$profile['profile_url'] = $tmp[1];
					} else $profile['profile_url'] = $url_profile[$i];
					//$profile['profile_url'] = $url_profile[$i];
				}
				$profile['id_profile'] = $list_profile[$i];
				$current_profile = $portfolioHome->getProfileBy($current_user['id'], 'id_profile', $profile['id_profile']);
				if($current_profile) $profile['id'] = $current_profile['id'];
				$portfolioHome->save('user_profile', $profile, $portfolioHome->item_profile);
			}
			$response->redirect('/portfolio/my');
		}
	} elseif($request->hasValue('hideexec')) {
		if($current_user['id']==$request->getValue('portfolio')) {
			$user['id'] = $request->getValue('hideexec');
			$user['is_show'] = '0';
			$portfolioHome->save_esia_exec($user, array('is_show'));
			$response->redirect('/portfolio/my');
		}
	} elseif($request->hasValue('showexec')) {
		if($current_user['id']==$request->getValue('portfolio')) {
			$user['id'] = $request->getValue('showexec');
			$user['is_show'] = '1';
			$portfolioHome->save_esia_exec($user, array('is_show'));
			$response->redirect('/portfolio/my');
		}
	} elseif($request->hasValue('delprof')) {
		$current_profile = $portfolioHome->getProfileBy($current_user['id'], 'id', $request->getValue('delprof'));
		if($current_user['id'] == $current_profile['id_user']) {
			$prof['id'] = $request->getValue('delprof');
			$portfolioHome->del('user_profile', $prof['id']);
		}
		$response->redirect('/portfolio/my');
	} elseif($request->hasValue('deldoc')) {
		$item = $portfolioHome->getOneDoc('id',$request->getValue('deldoc'));
		if($item['id_user']==$current_user['id']) {
			$doc['id'] = $request->getValue('deldoc');
			$doc['is_deleted'] = '1';
			$portfolioHome->saveDoc($doc, array('is_deleted'));
			$response->redirect('/portfolio/my');
		}
	} elseif($request->hasValue('delconf')) {
		$item = $portfolioHome->getOneConference('id',$request->getValue('delconf'));
		if($item['id_user']==$current_user['id']) {
			$conf['id'] = $request->getValue('delconf');
			$conf['is_deleted'] = '1';
			$portfolioHome->saveConference($conf, array('is_deleted'));
			$response->redirect('/portfolio/my');
		}
	}  elseif($request->hasValue('saveph1')) {
		if($_FILES['upload_photo1']['name']){
			if($request->getValue('saveph1') && $rights=='write') {
				$id_user = $request->getValue('saveph1');
			} else {
				$id_user = $current_user['id'];
			}
			$file_ext =  strtolower(strrchr($_FILES['upload_photo1']['name'],'.'));
			$uploaddir = 'files/lk/photo/';
			$uploadfile  = $uploaddir.$id_user.$file_ext;
			move_uploaded_file($_FILES['upload_photo1']['tmp_name'], $uploadfile);
			$uploadfile_to_base  = $id_user.$file_ext;
			$user['image'] = $uploadfile_to_base;
			$user['id'] = $id_user;
			$portfolioHome->save_esia_par($user, array('image'));
		}
		if($request->getValue('saveph1') && $rights=='write')
			$response->redirect('/portfolio/'.$request->getValue('saveph1'));
		else
			$response->redirect('/portfolio/my');
	} elseif($request->hasValue('saveph2')) {
		if($_FILES['upload_photo2']['name']){
			if($request->getValue('saveph2') && $rights=='write') {
				$id_user = $request->getValue('saveph2');
				$file_ext =  strtolower(strrchr($_FILES['upload_photo2']['name'],'.'));
				$uploaddir = 'files/sphinx/';
				$uploadfile  = $uploaddir.$id_user.$file_ext;
				move_uploaded_file($_FILES['upload_photo2']['tmp_name'], $uploadfile);
			}
		}
		$response->redirect('/portfolio/'.$request->getValue('saveph2'));
	} elseif($request->hasValue('savepass')) {
		if($usersHome && $rights="write" && $request->getValue('id') && $request->getValue('password') && $request->getValue('login')) {
			$user['id'] = $request->getValue('id');
			$user['login'] = $request->getValue('login');
			$user['password'] = $request->getValue('password');
			$usersHome->save_esia($user);
			$usersHome->password_moodle($user['login'],$user['password'] , 1);
		}
		$response->redirect('/portfolio/'.$user['id']);
	} elseif($request->hasValue('savemayfer')) {
		if($usersHome && $rights="write" && $request->getValue('id') && $request->getValue('mayfer') && $request->getValue('mayfer_date_begin') && $request->getValue('mayfer_date_end')) {
			$user['id'] = $sphinx['id_user'] = $request->getValue('id');
			$user['mayfer'] = $request->getValue('mayfer');
			$user['mayfer_date_begin'] = $functions->remakeDate($request->getValue('mayfer_date_begin'));
			$user['mayfer_date_end'] = $functions->remakeDate($request->getValue('mayfer_date_end'));
			$usersHome->save_esia($user);
			//добавить сохранение сфинкса по ид: если есть, то апдейт, если нет, то инсерт
			$id_sphinx_hidden = $request->getValue('id_sphinx');
			$id_sphinx = $portfolioHome->getSphinx($id_sphinx_hidden);
			if($id_sphinx_hidden && $id_sphinx && is_array($id_sphinx)) {
				$sphinx['id'] = $id_sphinx_hidden;
			}
			$user_tmp = $portfolioHome->getValue('id', $user['id'], 'user', array('firstname', 'secondname', 'lastname'), 2);
			$sphinx['name'] =  $user_tmp['lastname']." ".$user_tmp['firstname']." ".$user_tmp['secondname'];
			$sphinx['date_create'] = date('Y-m-d',$user['mayfer_date_begin']);
			$sphinx['date_exp'] = date('Y-m-d',$user['mayfer_date_end']);
			if($request->getValue('is_empl')) $sphinx['is_empl'] = 1;
			if($request->getValue('is_student')) $sphinx['is_student'] = 1;
			$sphinx['CODEKEY'] = "0x20".$user['mayfer'][6].$user['mayfer'][7].$user['mayfer'][4].$user['mayfer'][5].$user['mayfer'][2].$user['mayfer'][3].$user['mayfer'][0].$user['mayfer'][1]."000000";
			$sp_dev = $portfolioHome->getSphinxDevList();
			if(is_array($sp_dev)) {
				$arr = Array();
				foreach ($sp_dev as $value) {
					if($request->getValue('spdev'.$value['id'])) {
						array_push($arr, $value['id']);
					}
				}
				$sphinx['dev_user'] = $arr;
			} 
			$portfolioHome->save_sphinx($sphinx, $portfolioHome->item_sphinx);
		}
		$response->redirect('/portfolio/'.$user['id']);
	} elseif($request->getValue('room') && $request->getValue('id_meet') && $request->getValue('addusr') && $rights=='write') {
		$item_list = $portfolioHome->getUserMeetList($request->getValue('addusr'));
		if($item_list) {
			foreach ($item_list as $value) {
				if(!$portfolioHome->getUserMeetList($request->getValue('id_meet'),$value['id_user'])) {
					echo $value['id_user'].'-'.$request->getValue('id_meet');
					$portfolioHome->insertUserToMeet($value['id_user'], $request->getValue('id_meet'));
				}
			}
		}
		$response->redirect('/portfolio/room/'.$request->getValue('room').'/id_meet/'.$request->getValue('id_meet'));
	} elseif ($request->getValue('comment') && $rights == 'write') {
		if($request->hasValue('ok')) {
			$comment_kurs_m['id'] = $request->getValue('comment');
			//$comment_kurs_m['id_type'] = $request->getValue('comment_type');
			$comment_kurs_m['id_moderator'] = $current_user['id'];
			$comment_kurs_m['date_begin'] = date('U');
			$comment_kurs_m['is_moderation'] = 1;
			//var_dump($comment_kurs_m);
			$portfolioHome->save('comment_work', $comment_kurs_m, array('id_moderator', 'id', 'date_begin', 'is_moderation'));
			$response->redirect('/portfolio/'.$request->getValue('portfolio'));
		} elseif($request->hasValue('cancel')) {
			$comment_kurs_m['id'] = $request->getValue('comment');
			$comment_kurs_m['id_moderator'] = $current_user['id'];
			$comment_kurs_m['is_moderation'] = 0;
			$portfolioHome->save('comment_work', $comment_kurs_m, array('id_moderator', 'id', 'is_moderation'));
			$response->redirect('/portfolio/'.$request->getValue('portfolio'));
		} elseif($request->hasValue('del')) {
			$portfolioHome->del('comment_work', $request->getValue('comment'));
			$response->redirect('/portfolio/'.$request->getValue('portfolio'));
		}
	} elseif($request->getValue('save_ippr')) {
		$ippr = $functions->getForm($portfolioHome->item_ippr);
		$ippr_dop = $functions->getForm($portfolioHome->item_ippr_dop);
		if($_FILES['upload_file']['name']){
			$file_ext =  strtolower(strrchr($_FILES['upload_file']['name'],'.'));
			$uploaddir = 'files/lk/ippr/';
			$uploadfile  = $uploaddir.$current_user['id'].$file_ext;
			$uploadfile_to_base  = $current_user['id'].$file_ext;
			move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadfile);
			$ippr['upload_file'] = $uploadfile_to_base;
		}
		if($request->getValue('is_goal') == 'on') $ippr['is_goal'] = 1;
		else $ippr['is_goal'] = 0;
		$ippr['work_date_begin'] = $functions->remakeDate($request->getValue('work_date_begin'));
		$ippr['dpo_date_begin'] = $functions->remakeDate($request->getValue('dpo_date_begin'));
        $ippr['work_date_begin2'] = $functions->remakeDate($request->getValue('work_date_begin2'));
        $ippr['dpo_date_begin2'] = $functions->remakeDate($request->getValue('dpo_date_begin2'));
		$id = $portfolioHome->save_esia('user_ippr', $ippr, $portfolioHome->item_ippr);
		$ippr_plan['id_ippr'] = $ippr['id'];
		
		if($ippr_dop) {
			$portfolioHome->delIPPR($ippr['id']);
			for($i=0; $i<count($ippr_dop['plan_event']); $i++) {
				$ippr_plan['plan_event'] = $ippr_dop['plan_event'][$i];
				$ippr_plan['plan_period'] = $ippr_dop['plan_period'][$i];
				$ippr_plan['plan_res'] = $ippr_dop['plan_res'][$i];
				$ippr_plan['plan_done'] = $ippr_dop['plan_done'][$i];
				$ippr_plan['plan_reason'] = $ippr_dop['plan_reason'][$i];
				$portfolioHome->save_esia('user_ippr_plan', $ippr_plan, $portfolioHome->item_ippr_dop);	
			}
		}
		//var_dump($ippr);
		//var_dump($ippr_dop);
		$response->redirect('/portfolio/'.$ippr['id_user'].'/ippr/'.$ippr['id_exec']);
	} elseif($request->getValue('save_resume')) {
		$resume = $functions->getForm($portfolioHome->item_resume);
		if(!$resume['date_create']) $resume['date_create'] = date('U');
		$resume['date_update'] = date('U');
		if($resume['yes_pers']) $resume['yes_pers'] = 1;
		else $resume['yes_pers'] = 0;
		//var_dump($resume);
		$id = $portfolioHome->save_esia('user_resume', $resume, $portfolioHome->item_resume);
		$response->redirect('/portfolio/'.$resume['id_user'].'/resume');
	} elseif($request->getValue('rightsdel') && $rights='write' && !$rights_dep) {
		$portfolioHome->del('user_rights', $request->getValue('rightsdel'));
		$response->redirect('/portfolio/'.$request->getValue('portfolio'));
	} elseif($request->hasValue('rightsadd') && $rights='write' && !$rights_dep) {
		$field_list = array('id_user','rights','id_dep','id_module');
		$item_list = $functions->getForm($field_list);
		if($request->hasValue('id_dep')) $item_list['id_dep']='1';
		//var_dump($item_list);
		$portfolioHome->save_rights('user_rights', $item_list, $field_list);
	} elseif($request->hasValue('portfolio') && $request->getValue('study_group') && $request->hasValue('set_curator')) {
	    $group['id'] = $request->getValue('study_group');
	    if($request->getValue('set_curator')) {
	        $group['id_curator'] = $request->getValue('set_curator');
            $portfolioHome->save_esia('user_study_group', $group, array('id', 'id_curator'));
            $current_curator['id'] = $request->getValue('set_curator');
            $current_curator['is_curator'] = 1;
            $portfolioHome->save_esia('user_execution', $current_curator, array('id', 'is_curator'));
        } else {
            $current_curator['id'] = $portfolioHome->getValue('id', $group['id'], 'user_student_group', array('id_curator'))['id_curator'];
            $current_curator['is_curator'] = 0;
            $portfolioHome->save_esia('user_execution', $current_curator, array('id', 'is_curator')); //убрали отметку о кураторстве в экзекьюшенах

	        $group['id_curator'] = 0;
            $portfolioHome->save_esia('user_study_group', $group, array('id', 'id_curator')); //удбрали связку с куратором в таблице учебных групп
        }

        $response->redirect('/portfolio/study_group/'.$request->getValue('study_group'));
    } elseif($request->hasValue('del_photo')) {
        if($current_user['is_curator'] || $rights=='write') {
            $del_photo['id'] = $request->getValue('id_user');
            $del_photo['image'] = '';
            $portfolioHome->save_esia('user', $del_photo, array('id', 'image'));
            if(file_exists($files_dir."lk/photo/".$request->getValue('id_user').".jpg")) {
            	unlink($files_dir."lk/photo/".$request->getValue('id_user').'.jpg');
            }
            $response->redirect('/portfolio/'.$request->getValue('id_user'));
        }
    } elseif($request->getValue('ippr') && $request->hasValue('viewdoc')) {
        $ip = $portfolioHome->getUserIPPR($request->getValue('portfolio'), $request->getValue('ippr'));
        $user = $usersHome->getBy('id', $request->getValue('portfolio'));
        $exec = $usersHome->getByExec($request->getValue('ippr'));
        $ip['dep'] = $exec['name_department'];
        $ip['name'] = $exec['name'];
        $ip['programmitem'] = $exec['spec_name'];
        $ip['id_exec'] = $exec['id'];
        $templateProcessor = new TemplateProcessor(realpath('files/lk/docs/templates/form_ippr.docx'));
        foreach ($ip as $field => $content) {
            $templateProcessor->setValue($field, $content);
        }
        
        $filename = 'ИППР #'.$ip['id'].' - '.$user['name'];
        $file = realpath('files/lk/docs/templates/tmp').'/'.$filename.'.docx';
        $templateProcessor->saveAs($file);
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            die();
        } else {
            die($file);
        }
    }
}

if($request->getValue('save_comment_kurs') || $request->getValue('save_comment_doc')) {
	$comment_kurs['text'] = $request->getValue('text_comment');
	$comment_kurs['id_user'] = $request->getValue('portfolio');
	$comment_kurs['id_owner'] = $current_user['id'];
	$comment_kurs['id_item'] = $request->getValue('id_item');
	$comment_kurs['id_type'] = $request->getValue('id_type');
	$comment_kurs['date_create'] = date('U');
	$portfolioHome->save('comment_work', $comment_kurs, array('id_user', 'id_owner', 'id_item', 'id_type', 'text', 'date_create'));
	$response->redirect('/portfolio/'.$request->getValue('portfolio'));
} 
?>