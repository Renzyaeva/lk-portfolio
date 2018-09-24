<?php
function makeComment($id_item, $id_type, $id_user, $portfolioHome, $rights) {
	$list_comment = $portfolioHome->getCommentWork($id_item, $id_type, $id_user);
	if($list_comment && is_array($list_comment)) {
		foreach($list_comment as $item_comment) {
			$owner_name = $portfolioHome->getValue('id', $item_comment['id_owner'], 'user', array('firstname', 'secondname', 'lastname'), 2);
			//var_dump($owner_name);
			if($owner_name) {
				$commenter_name = '<a href="/portfolio/'.$item_comment['id_owner'].'" target="_blank">'.$owner_name['lastname'].' '.$owner_name['firstname'].' '.$owner_name['secondname'].'</a>';
			} else {
				$commenter_name = 'Гость';
			}
		//var_dump($owner_name);
			if($rights == 'write') {
				$list_comment_work['is_show'] = true;
				$list_comment_work['list'] .= $commenter_name.' ['.$item_comment['date_create_date'].']: '.$item_comment['text'];
				if(!$item_comment['is_moderation']) $list_comment_work['list'] .= '&nbsp;<a href="/portfolio/'.$id_user.'/comment/'.$item_comment['id'].'/ok" onclick="if(!confirm(\'Вы уверены, что хотите одобрить комментарий?\')) return false;">Одобрить</a>';
				else $list_comment_work['list'] .= ' - <a href="/portfolio/'.$id_user.'/comment/'.$item_comment['id'].'/cancel" onclick="if(!confirm(\'Вы уверены, что хотите отменить одобрение?\')) return false;">Отменить одобрение</a>';
			
				$list_comment_work['list'] .= ' - <a href="/portfolio/'.$id_user.'/comment/'.$item_comment['id'].'/del" onclick="if(!confirm(\'Вы уверены, что хотите навсегда удалить комментарий?\')) return false;">Удалить</a>';
				
			} else {
				if($item_comment['is_moderation'] == 1) {
					$list_comment_work['is_show'] = true;
					$list_comment_work['list'] .= $commenter_name.' ['.$item_comment['date_create_date'].']: '.$item_comment['text'];
				}
			}
		$list_comment_work['list'] .= '<br>';
		}
	}
	return $list_comment_work;
}
?>