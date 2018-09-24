<?php
class PortfolioHome {
	private $db_instance;
	private $db_instance2;
	private $db_instance3;
	private $db_instance5;
	private $db_instance6;
	private $request;
	private $dep = false;
	private $sql_search;
	public $url; 
	
	public $item_docs_type = array('id', 'name','header','field1','field2','field3','field4','field5','field6','field7','field8');
	public $item_confernce_type = array('id', 'name','header');
	public $item_confernce = array('id', 'name','id_user','organization','id_type','date_begin','date_end','topic','mentor','fonancing','url','url_eb','id_doc','date','id_level','is_deleted');
	public $item_confernce_all = array('id', 'name','id_user','organization','id_type','type','date_begin','date_end','topic','mentor','fonancing','url','url_eb','id_doc','id_level','is_deleted');
	public $item_doc = array('id', 'id_user', 'id_type', 'series', 'number', 'dop_info1', 'dop_info2', 'dop_info3', 'dop_info4', 'dop_info5', 'dop_info6', 'date_begin', 'date_end', 'id_operator','date', 'rights', 'is_deleted', 'file_name');
	public $item_doc_all = array('id', 'id_user', 'id_type', 'name','is_protected', 'series', 'number', 'dop_info1', 'dop_info2', 'dop_info3', 'date_begin', 'date_end', 'id_operator','date', 'rights', 'is_deleted', 'file_name','department_name');
	public $item_education_all = array('id', 'name','id_user','id_type','type','spec','kind');
	public $item_lib = array('id', 'title', 'id_user', 'id_ir', 'code', 'id_resource_type');
	public $item_libdoc = array('id', 'name', 'id_user', 'id_type');
	public $item_profile_type = array('id', 'name', 'url', 'image', 'is_deleted');
	public $item_profile = array('id', 'id_user', 'id_profile', 'profile_url', 'image', 'url', 'is_deleted');
	public $item_sphinx = array('ID', 'NAME', 'CODEKEY');
	public $item_kurs = array('userid', 'course', 'name', 'grade', 'filename', 'theme', 'submission', 'coursename', 'contextid', 'comment', 'id', 'commenttext', 'discipline_index');
	public $item_comment = array('id', 'id_user', 'id_type', 'id_owner', 'id_item', 'id_moderator', 'date_create', 'bate_begin', 'text', 'is_moderation', 'is_deleted');
	public $item_ippr = array('id', 'id_user', 'id_exec', 'dopprogramm', 'prpractice', 'dpractice', 'is_goal', 'activity', 'function', 'graf', 'type', 'ready', 'work_condition', 'cash', 'work_date_begin', 'work_org', 'work_position', 'work_need_edu', 'work_type', 'work_other', 'upload_file', 'dpo_date_begin', 'dpo_org', 'dpo_spec', 'dpo_form', 'dpo_other', 'work_date_begin2', 'work_org2', 'work_position2', 'work_need_edu2', 'work_type2', 'work_other2', 'dpo_date_begin2', 'dpo_org2', 'dpo_spec2', 'dpo_form2', 'dpo_other2');
	public $item_ippr_dop = array('id_ippr', 'plan_event', 'plan_period', 'plan_res', 'plan_done', 'plan_reason', 'is_deleted');
	public $item_resume = array('id', 'id_user', 'date_create','date_update', 'know_lng', 'know_plng', 'know_pk', 'know_prog', 'work_condition', 'know_dop', 'yes_pers', 'is_deleted');

	function __construct($request = NULL) {
		$this->db_instance = $GLOBALS["db"];
		$this->db_instance2 = $GLOBALS["db2"];
		$this->db_instance3 = $GLOBALS["db3"];
		$this->db_instance5 = $GLOBALS["db5"];
		$this->db_instance6 = $GLOBALS["db6"];
		$this->db_instance7 = $GLOBALS["db7"];
		$this->request = $request;
	}
	
	public function saveTest($post,$get) {
		$sql = "INSERT INTO `test` SET `post_text`='".$post."', `get_text`='".$get."', `date`='".date('U')."', `ip`='".$_SERVER['REMOTE_ADDR']."'";
		$this->db_instance2->query($sql);
	}
	
	public function getValues($par=false, $id=false, $table, $array, $type=false, $order=false) {
		$sql = "SELECT * FROM `".$table."`"; 
		if($par) $sql .= " WHERE `".$par."`='".$id."'";
		
		if(!strstr($sql,'WHERE')) $sql .= ' WHERE '; else $sql .= ' AND '; 
		$sql .= " `is_deleted` = 0 ";
		if($order) $sql .= " ORDER BY ".$order."";
		if($type == '1') $item = $this->db_instance->getListData($sql, $array);
		elseif($type == '2') $item = $this->db_instance2->getListData($sql, $array);
		elseif($type == '3') $item = $this->db_instance3->getListData($sql, $array);
		elseif($type == '4') $item = $this->db_instance4->getListData($sql, $array);
		elseif($type == '5') $item = $this->db_instance5->getListData($sql, $array);
		return $item;
	}
	
	public function getValue($par, $id, $table, $array, $type=false) {
		$sql = "SELECT * FROM `".$table."` WHERE `".$par."`='".$id."'";
		$sql .= " AND `is_deleted` = 0 ";
		if($type == '1') $item = $this->db_instance->getOneData($sql, $array);
		elseif($type == '2') $item = $this->db_instance2->getOneData($sql, $array);
		elseif($type == '3') $item = $this->db_instance3->getOneData($sql, $array);
		elseif($type == '4') $item = $this->db_instance4->getOneData($sql, $array);
		elseif($type == '5') $item = $this->db_instance5->getOneData($sql, $array);
		return $item;
	}
	
	public function getListDocType($is_protected=false) {
		$sql = "SELECT *  FROM  `docs_types` ";
		if(!$is_protected) $sql .= " WHERE `is_protected`=0";
		$sql .= " ORDER BY `name`";
		$item = $this->db_instance2->getListData($sql, $this->item_docs_type);
		return $item;
	}

	public function getDocType($id) {
		$sql = "SELECT *  FROM  `docs_types` WHERE `id`='".$id."'";
		$item = $this->db_instance2->getOneData($sql, $this->item_docs_type);
		return $item;
	}
	
	public function getListDoc($par = null, $val = null, $is_protected=-1, $is_file=false) {
		$sql = "SELECT `docs`.*, `docs_types`.`name`, `docs_types`.`is_protected`, CONCAT_WS(' ',`dop_info1`,`dop_info2`,`dop_info3`) as `department_name`  FROM  `docs`, `docs_types` WHERE `docs`.`id_type`=`docs_types`.`id` ";
		if($par && $val) $sql .= " AND `".$par."`='".$val."'"; 
		if($is_protected>=0) {
			$sql .= " AND `docs_types`.`is_protected`='".$is_protected."' ";
		}
		if($is_file) {
			$sql .= " AND `docs`.`file_name` IS NOT NULL";
		}
		$sql .= " AND `docs`.`is_deleted`='0' ORDER BY `docs`.`id_type`";
		$item = $this->db_instance2->getListData($sql, $this->item_doc_all);
		return $item;
	}
	
	public function getOneDoc($par = null, $val = null) {
		$sql = "SELECT * FROM  `docs`, `docs_types` WHERE `docs`.`id_type`=`docs_types`.`id` ";
		if($par && $val) $sql .= " AND `docs`.`".$par."`='".$val."'"; 
		$item = $this->db_instance2->getOneData($sql, $this->item_doc_all);
		return $item;
	}
	
	public function saveDoc($item, $items = false) {
		if(!$items) $items =  $this->item_doc;
		$id = $this->db_instance2->saveData($item, 'docs', $items);
		return $id;
	}	
	public function getListLib($id_user, $type=false) {
		if(!$type) {
			$sql = "SELECT `user_infresources`.*, `infresources`.`title`,`infresources`.`code`,`infresources`.`id_resource_type`  FROM  `user_infresources`
				LEFT OUTER JOIN `infresources` ON `infresources`.`id`=`user_infresources`.`id_ir` 
				WHERE `user_infresources`.`id_user`='".$id_user."' AND `user_infresources`.`is_deleted`='0' AND `infresources`.`is_deleted`='0'";
			$array = $this->item_lib;
		} else {
			$sql = "SELECT *  FROM  `doc` WHERE `doc`.`id_user`='".$id_user."' AND `firstname` IS NULL AND `secondname` IS NULL AND `lastname` IS NULL AND `is_deleted`='0'";
			$array = $this->item_libdoc;
		}
		$item = $this->db_instance5->getListData($sql, $array);
		if(!$item) {
			if(!$type) {
				$sql = "SELECT * FROM  `infresources` WHERE `infresources`.`id_user`='".$id_user."' AND `infresources`.`is_deleted`='0'";
				$array = $this->item_lib;
			} else {
				$sql = "SELECT * FROM `doc` WHERE `doc`.`id_user`='".$id_user."' AND `doc`.`is_deleted`='0'";
				$array = $this->item_libdoc;
			}
			$item = $this->db_instance5->getListData($sql, $array);
		}
		return $item;
	}
	public function getListConferenceType() {
		$sql = "SELECT *  FROM  `conference_type` ";
		$item = $this->db_instance2->getListData($sql, $this->item_confernce_type);
		return $item;
	}
	
	public function getConferenceType($id) {
		$sql = "SELECT *  FROM  `conference_type` WHERE `id`='".$id."'";
		$item = $this->db_instance2->getOneData($sql, $this->item_confernce_type);
		return $item;
	}
	
	public function getListConference($par = null, $val = null,$id_type=null) {
		$sql = "SELECT `conference`.*, `conference_type`.`name` as `type`  FROM  `conference`, `conference_type` WHERE `conference`.`id_type`=`conference_type`.`id` ";
		if($par && $val) $sql .= " AND `".$par."`='".$val."'";
		if($id_type)  $sql .= " AND `id_type`='".$id_type."'";
		$sql.= " AND `conference`.`is_deleted`=0";
		$item = $this->db_instance2->getListData($sql, $this->item_confernce_all);
		return $item;
	}
	
	public function getListEducation($par = null, $val = null,$id_type=null) {
		$sql = "SELECT `user_education`.*, `education_type`.`name` as `type`, `user_execution_kind`.`name` as `kind`  
		FROM `education_type`, `user_education` 
		LEFT OUTER JOIN `user_execution_kind` ON `user_execution_kind`.`id`=`user_education`.`id_kind` 
		WHERE `user_education`.`id_type`=`education_type`.`id` ";
		if($par && $val) $sql .= " AND `".$par."`='".$val."'";
		if($id_type)  $sql .= " AND `id_type`='".$id_type."'";
		$item = $this->db_instance2->getListData($sql, $this->item_education_all);
		return $item;
	}
	
	public function getListKurs($id_user) {
		/*$sql = "SELECT ma.id, ma.course, ma.name, ma.intro , mag.assignment, mag.userid, mag.grade , maf.assignment, maf.submission , mf.contextid, mf.filepath, mf.filename, mf.userid, mf.itemid ,mbdspr.name as coursename, mbdsp.id, mbdsp.mdluser , mbdst.theme 
				FROM mdl_assign ma 
				LEFT JOIN mdl_block_dof_s_persons mbdsp ON mbdsp.id = '".$id_user."' 
				LEFT JOIN mdl_assign_grades mag ON ma.id = mag.assignment AND mag.userid = mbdsp.mdluser 
				LEFT JOIN mdl_assignsubmission_file maf ON ma.id = maf.assignment 
				LEFT JOIN mdl_files mf ON mf.itemid = maf.submission AND mf.userid = mbdsp.mdluser 
				LEFT JOIN mdl_block_dof_s_topics mbdst ON ma.course = mbdst.programmitemid AND mbdst.studentid = mbdsp.id 
				LEFT JOIN mdl_block_dof_s_programmitems mbdspr ON mbdspr.mdlcourse = ma.course
				WHERE mf.filename !='.' AND mf.component = 'assignsubmission_file' AND mag.grade>0 "; 
		
		$sql = "SELECT ma.id, ma.course courseid, ma.name, ma.intro, mag.assignment, mag.userid, mag.grade, maf.assignment, maf.submission, mf.contextid, mf.filepath, mf.filename, mf.userid, mf.itemid, mbdsp.id, 
					   mbdsp.mdluser, mbdst.theme, CASE (CASE WHEN mbdsp1.semesternum = 0 THEN mbdsp1.fsemester_type ELSE mbdss.semester_num END) WHEN 0 THEN 'осенний' WHEN 1 THEN 'весенний' ELSE '' END AS semestr2, mbdsp1.agenum AS course, mac.commenttext as comment
 				FROM mdl_assign ma 
				LEFT JOIN mdl_block_dof_s_persons mbdsp ON mbdsp.id = '".$id_user."'
				LEFT JOIN mdl_assign_grades mag ON ma.id = mag.assignment AND mag.userid = mbdsp.mdluser
				LEFT JOIN mdl_assignsubmission_file maf ON ma.id = maf.assignment
				LEFT JOIN mdl_assignfeedback_comments mac ON ma.id = mac.assignment AND mac.grade=mag.id
				LEFT JOIN mdl_files mf ON mf.itemid = maf.submission AND mf.userid = mbdsp.mdluser
				LEFT JOIN mdl_block_dof_s_programmitems mbdsp1 ON mbdsp1.mdlcourse = ma.course
				LEFT JOIN mdl_block_dof_s_topics mbdst ON mbdsp1.id = mbdst.programmitemid AND mbdst.studentid = mbdsp.id
				LEFT JOIN mdl_block_dof_s_semesterdata mbdss ON mbdss.id = mbdst.semesterid
				WHERE mf.filename !='.' AND mf.component = 'assignsubmission_file' AND ma.name like '%курсов%'; "; */
				
		$sql = "SELECT  ma.id, ma.course courseid, ma.name, ma.intro, mag.assignment, mag.userid, mag.grade, maf.assignment, maf.submission, mf.contextid, mf.filepath, mf.filename, mf.userid, mf.itemid
		, mbdsp.id, mbdsp.mdluser
		, mbdst.theme
		, CASE (CASE WHEN mbdsp1.semesternum = 0 THEN mbdsp1.fsemester_type ELSE mbdss.semester_num END) WHEN 0 THEN 'осенний' WHEN 1 THEN 'весенний' ELSE '' END AS semestr2
		, mbdsp1.agenum AS course, mac.commenttext, mbdsp1.name as coursename, mbdsp1.discipline_index
		FROM mdl_assign ma
		LEFT JOIN mdl_block_dof_s_persons mbdsp ON mbdsp.id = '".$id_user."'
		LEFT JOIN mdl_assign_grades mag ON ma.id = mag.assignment AND mag.userid = mbdsp.mdluser
		LEFT JOIN mdl_assignsubmission_file maf ON ma.id = maf.assignment
		LEFT JOIN mdl_files mf ON mf.itemid = maf.submission AND mf.userid = mbdsp.mdluser
		LEFT JOIN mdl_block_dof_s_programmitems mbdsp1 ON mbdsp1.mdlcourse = ma.course
		LEFT JOIN mdl_block_dof_s_topics mbdst ON mbdsp1.id = mbdst.programmitemid AND mbdst.studentid = mbdsp.id
		LEFT JOIN mdl_block_dof_s_semesterdata mbdss ON mbdss.id = mbdst.semesterid
		LEFT JOIN mdl_assignfeedback_comments mac ON mac.assignment = ma.id AND mac.id=(SELECT max(mdl_assignfeedback_comments.id)  FROM mdl_assignfeedback_comments WHERE mdl_assignfeedback_comments.assignment = ma.id)
		WHERE mf.filename !='.' AND mf.component = 'assignsubmission_file' AND ma.name like '%курсов%'";
		$item = $this->db_instance3->getListData($sql, $this->item_kurs);
		return $item;
	}
	
	public function getListKursThemeMdl($idUser, $idSpec=0) {
		$sql = "SELECT mbdsp1.id, mbdsp1.name, mbdst.theme, mbdst.semesterid, mbdsp1.id AS programmitem_id, mbdsp1.mdlcourse -- MDLid дисциплины
		-- , mbdsp1.sname -- Название в диплом
		-- , mbdsp1.en_name -- Англ. название
		, mbdsp1.agenum
		, mbdsp1.semesternum
		, mbdsp1.fsemester_type
		, mbdsp1.discipline_index
		, (IF(mbdsp1.semesternum = 1, mbdss.semester_num, mbdsp1.fsemester_type)) AS semester
		, mbdsc.controltype
		FROM mdl_block_dof_s_persons mbdsp 
		LEFT JOIN mdl_block_dof_s_topics mbdst ON mbdst.studentid = mbdsp.id 
		LEFT JOIN mdl_block_dof_s_semesterdata mbdss ON mbdst.semesterid = mbdss.id
		LEFT JOIN mdl_block_dof_s_programmitems mbdsp1 ON mbdsp1.id = mbdst.programmitemid
		LEFT JOIN mdl_block_dof_s_controlevents mbdsc ON mbdsc.programmitemid = mbdsp1.id AND mbdsc.semesterid = mbdss.id
		WHERE mbdsp.id = '".$idUser."' AND mbdsc.controltype IN (3, 4)  -- AND mbdsp1.programmid = ".$idSpec."  
		AND mbdst.status = 'active'  order by agenum, semester";
		$item = $this->db_instance3->getListData($sql, array('id', 'name', 'theme', 'discipline_index'));
		return $item;
	}
	
	public function getListMarkEsia($id_subject, $id_user, $in_portfolio=false) {
		$sql = "SELECT `id_subject`, `id_exam`, `id_mark`, `date`
		FROM (SELECT * FROM `user_mark` WHERE ";
		if($in_portfolio) {
			$sql .= "`id_mark`>0 AND ";
		}
		$sql .= " `id_subject`='".$id_subject."' AND `id_user`='".$id_user."' ORDER BY id desc) t GROUP BY id_exam"; 
//			FROM `user_mark` WHERE `id_mark`>0 AND `id_subject`='".$id_subject."' AND `id_user`='".$id_user."' AND `date` = (SELECT MAX(`date`) FROM `user_mark` WHERE `id_subject`='".$id_subject."' AND `id_user`='".$id_user."')";
		$item = $this->db_instance2->getListData($sql, array('id_exam', 'id_mark', 'date'));
		return $item;
	}
	
	public function getOneConference($par = null, $val = null,$id_type=null) {
		$sql = "SELECT `conference`.*, `conference_type`.`name` as `type`  FROM  `conference`, `conference_type` WHERE `conference`.`id_type`=`conference_type`.`id` ";
		if($par && $val) $sql .= " AND `conference`.`".$par."`='".$val."'";
		if($id_type)  $sql .= " AND `id_type`='".$id_type."'";
		$sql .= " AND `conference`.`is_deleted`=0";
		$item = $this->db_instance2->getOneData($sql, $this->item_confernce_all);
		return $item;
	}	
	
	public function getUserList($id_position, $is_student=true, $is_current=true) {
		$sql = "SELECT `user`.`id` AS `id_user`, 
		`user`.`code`,
		`user`.`is_empl`,
		`user`.`login`, 
		`user`.`password`,  
		 CONCAT_WS(' ',`lastname`,`firstname`,`secondname`) AS `name`,
		`user_execution`.`id` AS `id`,
		`user_execution`.`personal_number`,
		`user_execution`.`id_category` AS `id_category`,
		`user_execution`.`id_position` AS `id_position`,
		`user_execution`.`date_begin`,
		`user_execution`.`date_end`,
		`user_execution`.`is_praepostor`,
		`user_execution`.`rate`
		FROM `user`,`user_execution` ";
		$sql .= " WHERE `user_execution`.`id_position`='".$id_position."' AND `user`.`id`=`user_execution`.`id_user`";
		if($is_current) $sql .=" AND `user_execution`.`is_deleted`!='1' AND (`user_execution`.`date_end` IS NULL OR `user_execution`.`date_end`='0' OR `user_execution`.`date_end`>'".date('U')."') ";
		if($is_student) $sql .= " AND `user`.`is_student`=1";
		$sql .= " ORDER BY `user`.`lastname`,`user`.`firstname`";
		$items = $this->db_instance2->getListData($sql, array('id','id_user','code','name','name_en','personal_number','id_position','id_category','date_begin','date_end','rate','is_praepostor','login','password','is_empl'));
		return $items;
	}
	
	public function getNps($id_dep = false,$par_dep = false, $all = false, $order=false) {
		$sql = "SELECT `user`.`id` AS `id_user`, `user`.`code`, CONCAT_WS(' ',`lastname`,`firstname`,`secondname`) AS `name`,
		`user_execution`.`id` AS `id`,
		`user_execution`.`id_category` AS `id_category`,
		`user_execution`.`id_position` AS `id_position`,
		`user_execution`.`date_begin`,
		`user_execution`.`date_end`,
		`user_execution`.`id_department`,
		`department`.`name` AS `name_department`,
		`dep_parent`.`id` AS `id_parentdep`,
		`dep_parent`.`name` AS `name_parentdep`,
		`dep_parent`.`type` AS `type_parentdep`,
		`user_position`.`name` AS `name_position`
		FROM `user`,`user_execution`
		LEFT OUTER JOIN `department` ON `user_execution`.`id_department`=`department`.`id`
		LEFT OUTER JOIN `department` AS `dep_parent` ON `department`.`id_parent`=`dep_parent`.`id` 
		LEFT OUTER JOIN `user_position` ON `user_execution`.`id_position`=`user_position`.`id`
		WHERE `user`.`id`=`user_execution`.`id_user` AND `user`.`is_empl`='1' AND `id_category`>'10' 
		AND (`user_execution`.`date_end` IS NULL OR `user_execution`.`date_end`='0' OR `user_execution`.`date_end`>'".date('U')."') " ;
		if(!$all) $sql .= " AND `id_category`='12476189' ";
		if($id_dep && $par_dep) $sql .= " AND (`user_execution`.`id_department`='".$id_dep."' OR `dep_parent`.`id`='".$par_dep."') ";
		elseif($id_dep) $sql .= " AND `user_execution`.`id_department`='".$id_dep."'";
		elseif($par_dep) $sql .= " AND `dep_parent`.`id`='".$par_dep."'";
		if(!$all) $sql .= " ORDER BY `user`.`lastname`,`user`.`firstname`";
		else {
            if($order) $sql .= " ORDER BY ".$order;
		    else $sql .= " ORDER BY `department`.`weight`,`department`.`id`, `user`.`lastname`,`user`.`firstname`";
        }

		//echo $sql;
		$items = $this->db_instance2->getListData($sql, array('id','id_user','name','id_position','id_category','date_begin','date_end','id_department','name_department','name_parentdep','id_parentdep','name_position','exp','exp_pgu'));
		return $items;
	}
//		LEFT OUTER JOIN `user_education` ON `user_education`.`id_user`=`user_execution`.`id_user`
	
	public function getOneUser($id_exec) {
		$sql = "SELECT `user`.`id` AS `id_user`, `user`.`code`, CONCAT_WS(' ',`lastname`,`firstname`,`secondname`) AS `name`,
		`user_execution`.`id` AS `id`,
		`user_execution`.`id_category` AS `id_category`,
		`user_execution`.`id_position` AS `id_position`
		FROM `user`,`user_execution`
		WHERE `user`.`id`=`user_execution`.`id_user` AND `user_execution`.`id`='".$id_exec."'"; 
		$items = $this->db_instance2->getOneData($sql, array('id','id_user','name','id_position','id_category'));	
		return $items;	
	}
	
	public function getUserEductionList($id_user) {
		$sql = "SELECT `user_education`.*, `education_type`.`name` as `type_name` 
		FROM `user_education` LEFT OUTER JOIN `education_type` ON `education_type`.`id`=`user_education`.`id_type`
		WHERE `user_education`.`id_user`='".$id_user."' ORDER BY `user_education`.`id_type`";
		$items = $this->db_instance2->getListData($sql, array('id','id_user','name','type_name'));
		return $items;
	}
	
	public function getUserExp($id_user) {
		$sql = "SELECT `exp`,`exp_pgu` FROM `user_exp` WHERE `id_user`='".$id_user."'";
		$item = $this->db_instance2->getOneData($sql, array('exp','exp_pgu'));
		return $item;
	}
	
	public function getProfileBy($id_user, $par=false, $val=false) {
		$sql = "SELECT * FROM `user_profile` WHERE `id_user`='".$id_user."' AND `is_deleted`='0' ";
		if($par) $sql .= " AND `".$par."` = '".$val."'";
		$item = $this->db_instance->getOneData($sql, $this->item_profile);
		return $item;
	}
	public function getProfilesBy($id_user, $par=false, $val=false) {
		$sql  = " SELECT `user_profile`.*, `profile_type`.`image`,`profile_type`.`url` FROM `user_profile`  ";
		$sql .= " LEFT OUTER JOIN `profile_type` ON `profile_type`.`id`=`user_profile`.`id_profile`";
		$sql .= " WHERE `id_user`='".$id_user."' AND `user_profile`.`is_deleted`='0'";
		if($par) $sql .= " AND `".$par."` = '".$val."'";
		$item = $this->db_instance->getListData($sql, $this->item_profile);
		return $item;
	}
	
	public function getDep($id_parent = 0, $level = 0){
		if(!$id_parent) $id_parent = 0;
		$sql = "SELECT * FROM `department` WHERE `id_parent`='".$id_parent."' AND `is_deleted`='0' AND `is_show`='1'";
		$items = $this->db_instance2->getListData($sql, array('id','id_parent','name'));
		$list = array();
		$i=0;
		foreach($items as $value) {
			$items2 = $this->getDep($value['id'], $level+1);
			$items[$i]['level'] = $level;
			array_push($list,$items[$i]);
			if($items2) {
				$list = array_merge($list,$items2);
			}
			$i++;
		}
		return $list;
	}
	
	public function getSite($id_dep = false, $id_site = false) {
		$sql = "SELECT `site`.`id`,`site`.`email`,`site`.`tel`,`site`.`addres`,`site`.`id_dep`,`site`.`id_boss`,`site`.`pologenie`,`domens`.`link` FROM `site`,`domens` WHERE `site`.`id`=`domens`.`id_site` AND ";
		if($id_dep)  $sql .= " `site`.`id_dep`='".$id_dep."' ";
		elseif($id_site)  $sql .= " `site`.`id`='".$id_site."' ";
		$sql .= " AND `domens`.`main`='1' AND `domens`.`is_deleted`='0' AND `site`.`is_deleted`='0'";
		$item = $this->db_instance->getOneData($sql, array('email','tel', 'addres', 'link', 'id_dep', 'id_boss','pologenie','id'));
		return $item;
	}
	
	public function getSubjectList($id_teacher) {
		$sql = "SELECT `mdl_block_dof_s_programmitems`.`name`, `mdl_block_dof_s_programmitems`.`mdlcourse`
		FROM `mdl_block_dof_s_programmitems`, mdl_block_dof_s_teachers mbdst
		LEFT JOIN mdl_block_dof_s_appointments mbdsa ON mbdsa.id = mbdst.appointmentid
		LEFT JOIN mdl_block_dof_s_eagreements mbdse ON mbdsa.eagreementid = mbdse.id
		LEFT JOIN mdl_block_dof_s_persons mbdsp ON mbdse.personid = mbdsp.id
		WHERE mbdst.programmitemid = `mdl_block_dof_s_programmitems`.`id` AND 
		`mbdsp`.`id` = '".$id_teacher."' AND mbdst.status = 'active' AND mbdsp.id IS NOT NULL GROUP BY `mdl_block_dof_s_programmitems`.`name`";
		$items = $this->db_instance3->getListData($sql, array('mdlcourse','name'));
		return $items; 
	}	
	
	
	private  function getListSQL ($par = null, $rights =null) {
		if($this->sql_search) return $this->sql_search;
		$sql = " FROM `user` ";
		$sql0 .= " WHERE `user`.`firstname`!='' AND `user`.`lastname`!='' ";
		if($par) {
		//echo '=';
			$rusfor = false;
			foreach ($par as $key => $value) {
				if(!$this->dep && ($key == 'id_category' || $key == 'id_department' || $key == 'course' || $key == 'is_goal')) {
					$this->dep = true;
					$sql_join .= " LEFT OUTER JOIN `user_execution` ON `user`.`id`=`user_execution`.`id_user` AND `user_execution`.`is_deleted`='0'";
				}
				if(!$rusfor && ($key == 'russian' || $key == 'foreign')) {
					$rusfor = true;
					$sql_join .= " LEFT OUTER JOIN `user_add` ON `user`.`id`=`user_add`.`id_user` ";
				}
				if($key == 'id_category') {
					if($sql1) $sql1 .= " AND ";
					$sql1 .= " `user_execution`.`id_category`='".$value."'";
				} elseif ($key == 'zach') {
					if($sql1) $sql1 .= " AND ";
					$sql1 .= " `user`.`is_student`='1' AND `is_abt`='1'";
				} elseif($key == 'is_goal') {
					if($sql1) $sql1 .= " AND ";
					$sql1 .= " `user_execution`.`is_goal`='1'";
				} elseif($key == 'id_department') {
					if($sql1) $sql1 .= " AND ";
					$sql1 .= " `user_execution`.`id_department`='".$value."'";
				} elseif($key == 'russian') {
					if($sql1) $sql1 .= " AND ";
					$sql1 .= " `user_add`.`id_country`='1'";
				} elseif($key == 'foreign') {
					if($sql1) $sql1 .= " AND ";
					$sql1 .= " `user_add`.`id_country`!='1' AND `user_add`.`id_country`!='0' AND `user_add`.`id_country` IS NOT NULL";
				} elseif($key == 'course') {
					$sql_join .= " LEFT OUTER JOIN `user_study_group` ON `user_study_group`.`id`=`user_execution`.`id_position` ";
					if($sql1) $sql1 .= " AND ";
					$sql1 .= " `user_study_group`.`course`='".$value."'";
				} else {
					if($key == 'name' && $value) {
						$name = explode(' ', $value);
						if(is_array($name)) {
							foreach ($name as $val) {
								if($val) {
									if($sql_add) $sql_add .= " AND ";
									$sql_add .= "(`lastname` LIKE '%".$val."%' OR `firstname` LIKE '%".$val."%' OR `secondname` LIKE '%".$val."%')";
								}
							}
							if($sql1) $sql1 .= " AND ";
							$sql1 .= " (`mayfer`='".$val."' OR (".$sql_add.")) ";
						}
					} elseif($key == 'is_deleted' && ($rights=='write' || $rights=='use')) {
						if($sql1) $sql1 .= " AND ";
						$sql1 .= "`user`.`".$key."`"."='".$value."'";
					} elseif($key && $key != 'name') {
						if($sql1) $sql1 .= " AND ";
						$sql1 .= "`user`.`".$key."`"."='".$value."'";
					}
				}
			}
			if($sql1) $sql0 .= " AND";
		}
		if($rights!='use' && $rights!='write') {
		//echo '-';
			if(!$sql0) $sql0 .= " WHERE ";
			//if($sql1) $sql1 .= " AND ";
			$sql1 .= " AND `user`.`is_deleted`"."='0'";
		}

		$sql .= $sql_join.$sql0.$sql1;
		$sql .= " GROUP BY `user`.`id`";
		$sql .= " ORDER BY `lastname`,`firstname`,`secondname`";
		$this->sql_search = $sql;
		return $sql;

	}
	
	public function getListUserPages($par = null, $begin=null, $limit=null, $rights=null) {
		$sql = "SELECT 
		`user`.`id` AS `id_user`, 
		`user`.`is_student`,
		`user`.`is_empl`,
		`user`.`code`,
		`user`.`login`,
		`user`.`password`,
		`user`.`is_deleted`, 
		CONCAT_WS(' ',`lastname`,`firstname`,`secondname`) AS `name`";
		if($this->dep) $sql .= ", `user_execution`.`id_department`, `user_execution`.`rate` ";
	
		$sql .= $this->getListSQL($par, $rights);
		
		if ($limit) {
			if(!$begin) $begin = 0;
			$sql .= " LIMIT ".$begin.", ".$limit." ";
		}
		$items = $this->db_instance2->getListData($sql, array('id_user','code','name','rate','name_department','name_group','is_student','is_empl', 'id_department', 'is_deleted', 'rate','login','password'));
		unset($this->dep);
		return $items; 
	}

	public function getCountUserPages($par = null, $rights=null) {
		//$sql = "SELECT 	count(`user`.`id`) ";
		$sql = "SELECT COUNT(*) as `cnt` FROM (";
		$sql .= "SELECT `user`.`id` ".$this->getListSQL($par, $rights);
		$sql .= ") cnt ";
		$items = $this->db_instance2->getOneData($sql, array('cnt'));
		return $items; 
	}	
	
	public function setURL($num, $text) {
		$this->url[$num] = $text;
	}
	
	public function getURL($num, $num2=0, $url = null) {
		$no_url = false;
		if($this->url) {
			foreach ($this->url as $key => $value) {
				if($this->request->getValue($value)) $val = $this->request->getValue($this->url[$key]).'/';
				else $val = '';
				if(($key!=$num && !in_array($key, $num2)) && $value) $ret .= $value.'/'.$val;
				if($key == $num) $no_url = true;
			}
		}
		if(!$no_url && $url) $ret .= $url.'/';
		return $ret;
	}
	
	public function getUserContact($id_user) {
		$sql = "SELECT `email`, `tel` FROM `user` WHERE `id` = ".$id_user."; ";
		$items = $this->db_instance2->getOneData($sql, array('email', 'tel'));
		return $items;
	}
	public function getDebt($id_user) {
		$sql = "SELECT SUM(`user_debt`.`summ_remn`) AS `debt` FROM `user_contract`,`user_debt` WHERE `user_contract`.`id`=`user_debt`.`id_contract` AND `user_debt`.`summ_remn`>0 AND `id_user` = '".$id_user."'";
		$items = $this->db_instance2->getOneData($sql, array('debt'));
		return $items; 
	}
	
	public function getDepList() {
		$sql = "SELECT * FROM `department` WHERE `is_deleted`='0' ORDER BY `name`";
		$item_list = $this->db_instance2->getListData($sql, array('id','id_parent','name'));
		return $item_list;
	}
	public function getCourseList() {
		$sql = "SELECT `course` as `id`, CONCAT_WS(' ',`course`,'курс') as `name` FROM `user_study_group` GROUP BY `course`";
		$item_list = $this->db_instance2->getListData($sql, array('id', 'name'));
		return $item_list;
	}
	
	public function getSphinx($id) {
		$sql = "SELECT * FROM `personal` WHERE `id` = ".$id."; ";
		$items = $this->db_instance6->getOneData($sql, $this->item_sphinx);
		return $items;
	}
	
	public function getSphinxDevList() {
		$sql = "SELECT `id`,`name` FROM `devices` WHERE `TYPE`='DEVICE'";
		$item_list = $this->db_instance6->getListData($sql, array('id','name'));
		return $item_list;
	}

	public function getSphinxDevUser($id_user) {
		$sql = "SELECT * FROM `devbindings` WHERE `EMP_ID`='".$id_user."'";
		$item_list = $this->db_instance6->getListData($sql, array('DEV_ID'));
		if(is_array($item_list)) {
			$arr = Array();
			foreach ($item_list as $value) {
				array_push($arr, $value['DEV_ID']);
			}
		}
		return $arr;
	}
	
	public function save_sphinx($user) {
		if($user['id']) {
			$sql = "UPDATE `personal` SET ";
		} else {
			if($user['is_empl']) {
				if($user['id_user']) {
							$sql_exec = "SELECT `ue1`.*, `up`.`name`,`dep`.`name` as `dep`,`dep`.`id` as `id_dep` FROM `user_execution` as `ue1`
							LEFT OUTER JOIN `user_position` `up` ON `up`.`id`=`ue1`.`id_position`
							LEFT OUTER JOIN `department` `dep` ON `dep`.`id`=`ue1`.`id_department`
							WHERE `id_user`='".$user['id_user']."' AND `rate`=(SELECT MAX(`ue2`.`rate`) FROM `user_execution` as `ue2` WHERE `ue2`.`id_user`='".$user['id_user']."') AND `ue1`.`is_deleted`=0";
							$item_exec = $this->db_instance2->getOneData($sql_exec, array('id', 'name', 'dep', 'id_dep', 'date_end'));
				}
				$id_parent = '47083';
				$pos = $item_exec['name'];
			} elseif($user['is_student']) {
				if($user['id_user']) { 
							$sql_exec = "SELECT `ue1`.*, `dep`.`name` as `dep`,`dep`.`id` as `id_dep`,`ug`.`code` FROM `user_execution` as `ue1`
							LEFT OUTER JOIN `user_study_group` `ug` ON `ug`.`id`=`ue1`.`id_position`
							LEFT OUTER JOIN `department` `dep` ON `dep`.`id`=`ue1`.`id_department`
							WHERE `id_user`='".$user['id_user']."' AND `rate`=(SELECT MAX(`ue2`.`rate`) FROM `user_execution` as `ue2` WHERE `ue2`.`id_user`='".$user['id_user']."') AND `ue1`.`is_deleted`=0";
							$item_exec = $this->db_instance2->getOneData($sql_exec, array('id', 'dep', 'id_dep', 'code', 'date_end'));
				}
				$id_parent = '47085';
				$pos = 'Учащийся '.$item_exec['code'];
			}
							
			$sql = "INSERT INTO `personal` SET `PARENT_ID`=".$id_parent.", `TYPE`='EMP', `CODEKEY_DISP_FORMAT`='W34', `DESCRIPTION`='Добавлен из Портфолио ЭИОС', `POS`='".$pos.". ".$item_exec['dep']."', `STATUS`='AVAILABLE',
					`CREATEDTIME`='".$user['date_create']."', ";
		}
		$sql .= " `NAME`='".$user['name']."', `CODEKEY`=".$user['CODEKEY'].",`CODEKEYTIME`='".$user['date_create']."',`EXPTIME`='".$user['date_exp']."' ";
		if($user['id']) {
			$sql .= "WHERE `ID`='".$user['id']."'";
			$this->db_instance6->query($sql);
		} else {
			$this->db_instance6->query($sql);
			$user['id'] = $this->db_instance6->insertId();
			$sql_upd = "UPDATE `user` SET `id_sphinx`=".$user['id']." WHERE `id`=".$user['id_user']." ";
			$this->db_instance2->query($sql_upd);
		}
			
		
		
		if(is_array($user['dev_user'])) {
			$sql = "DELETE FROM `devbindings` where `EMP_ID`='".$user['id']."'";
			$this->db_instance6->query($sql);
			foreach ($user['dev_user'] as $value) {
				$sql = "INSERT INTO `devbindings` SET `EMP_ID`='".$user['id']."', `DEV_ID`='".$value."'";
				$this->db_instance6->query($sql);
			}
		}
		
		$sql = "SELECT * FROM `rulebindings` WHERE `PERSONAL_ID`='".$user['id']."' AND `RULE_ID`='1'";
		$rule = $this->db_instance6->getOneData($sql, array('RULE_ID'));
		if(!$rule) {
			$sql = "INSERT INTO `rulebindings` SET `PERSONAL_ID`='".$user['id']."', `RULE_ID`='1'";
			$this->db_instance6->query($sql);
		}
		
		if($user['is_empl']) {
			$sql = "SELECT * FROM `rulebindings` WHERE `PERSONAL_ID`='".$user['id']."' AND `RULE_ID`='4'";
			$rule = $this->db_instance6->getOneData($sql, array('RULE_ID'));
			if(!$rule) {
				$sql = "INSERT INTO `rulebindings` SET `PERSONAL_ID`='".$user['id']."', `RULE_ID`='4'";
				$this->db_instance6->query($sql);
			}
		}
		$sql = "UPDATE PARAMI SET PARAMVALUE=1 WHERE NAME='SYNCDB_REQUEST'";
		$this->db_instance6->query($sql);
	}
	
	public function getRoomBySn($sn) {
		$sql = "SELECT `id`,`name`,`build` FROM `room` WHERE `serial_number`='".$sn."'";
		$item = $this->db_instance->getOneData($sql, array('id','name','build'));
		return $item;
	}

	public function getRoomById($id) {
		$sql = "SELECT `id`,`name`,`build` FROM `room` WHERE `id`='".$id."'";
		$item = $this->db_instance->getOneData($sql, array('id','name','build'));
		return $item;
	}	
	
	public function getLessonNum($time) {
		$sql = "SELECT `id` FROM `lesson_time` WHERE `time_begin`<'".($time+900)."' AND `time_end`>'".$time."'";
		$item = $this->db_instance->getOneData($sql, array('id'));
		return $item;
	}
	
	public function getUserByCard($card) {
		$sql = "SELECT `id` FROM `user` WHERE `mayfer`='".$card."'";
		$item = $this->db_instance2->getOneData($sql, array('id'));
		return $item;
	}
	
	public function getPresensByRoom($id_room,$lesson_num,$date) {
		$sql = "SELECT `id` FROM `presence_schedule` WHERE `id_room`='".$id_room."' AND `lesson_num`='".$lesson_num."' AND `date`='".$date."'";
		$item = $this->db_instance->getOneData($sql, array('id'));
		return $item;
	}
	public function getCommentWork($id_item, $id_type, $id_user) {
		$sql = "SELECT * FROM  `comment_work` WHERE `id_type`='".$id_type."' AND `id_user`='".$id_user."' AND `id_item`='".$id_item."' AND `is_deleted`=0";
		$item = $this->db_instance->getListData($sql, $this->item_comment);
		return $item;
	}
	public function savePresensByRoom($id_room,$lesson_num,$date) {
		$sql = "INSERT INTO `presence_schedule` SET `id_room`='".$id_room."',`lesson_num`='".$lesson_num."',`date`='".$date."',`id_type`=3";
		$this->db_instance->query($sql);
		return $this->db_instance->insertId();
	}

	public function getUserPresens($id_presens,$id_user) {
		$sql = "SELECT `id` FROM `user_presence` WHERE `id_presence`='".$id_presens."' AND `id_user`='".$id_user."'";
		$item = $this->db_instance->getOneData($sql, array('id'));
		return $item;
	}
	
	public function getDo($do = false) {
		$sql = "SELECT * FROM `test1` WHERE `is_deleted`='0'";
		if($do) $sql .= " AND `is_do`='1'";
		else $sql .= " AND `is_do`='0'";
		$item = $this->db_instance2->getOneData($sql, array('id','message'));
		return $item;
	}

	public function setDo($id) {
		$sql = "UPDATE `test1` SET `is_do`='1' WHERE `id`='".$id."'";
		$this->db_instance2->query($sql);
	}

	public function setDone() {
		$sql = "UPDATE `test1` SET `is_deleted`='1' WHERE `is_do`='1'";
		$this->db_instance2->query($sql);
	}
	
	public function getPresensByUser($id_user, $limit = 50) {
		$sql = "SELECT `date`,`room`.`name`,`room_user`.`name` as `name_user`,`lesson_num`,`type`,`date_create` 
				FROM `user_presence` 
				LEFT OUTER JOIN `room` as room_user ON `user_presence`.`id_room` = `room_user`.`id` 
				LEFT OUTER JOIN `presence_schedule` ON `user_presence`.`id_presence`=`presence_schedule`.`id` 
				LEFT OUTER JOIN `room` ON `presence_schedule`.`id_room` = `room`.`id` WHERE `id_user`='".$id_user."' 
				ORDER BY `date_create` DESC,`date` DESC,`lesson_num` DESC";
		if($limit) $sql .= " LIMIT ".$limit;
		$item = $this->db_instance->getListData($sql, array('date','name','name_user','lesson_num','type','date_create'));
		return $item;
	}	
	
	public function getBookByUser($id_user) {
		$sql = "SELECT `id_db`,`code`,`name`,`author`,`date_begin`,`date_end`,`date` 
				FROM `user_ibook` 
				LEFT OUTER JOIN `irbis` ON `user_ibook`.`id_irbis` = `irbis`.`id` 
				WHERE `id_user`='".$id_user."' AND `user_ibook`.`is_deleted`=0 AND `irbis`.`is_deleted`=0
				ORDER BY `date_create` DESC";
		$item_list = $this->db_instance5->getListData($sql, array('id_db','code','name','author','date_begin','date_end','date'));
		return $item_list;
	}	
	
	public function getListRoom() {
		$sql = "SELECT `id`,`name`,`build` FROM `room` ORDER BY `build`, `name`";
		$item_list = $this->db_instance->getListData($sql, array('id','name','build'));
		return $item_list;
	}
	
	public function getListPresensByRoom($id_room, $date_begin = null, $date_end = null,$limit = null) {
		$sql = "SELECT `date`,`room`.`name`,`room_user`.`name`,`lesson_num`,`user_presence`.`type`,`user_presence`.`date_create`,`user_presence`.`id_user`,
				 CONCAT_WS(' ',`esia`.`user`.`lastname`,`esia`.`user`.`firstname`,`esia`.`user`.`secondname`) AS `name_user`,
				 `esia`.`user`.`is_student`,`esia`.`user`.`is_empl` ,
				 `user_execution`.`id_department`,`department`.`name` as `dep`
				FROM `user_presence` 
				LEFT OUTER JOIN `room` as `room_user` ON `user_presence`.`id_room` = `room_user`.`id` 
				LEFT OUTER JOIN `presence_schedule` ON `user_presence`.`id_presence`=`presence_schedule`.`id` 
				LEFT OUTER JOIN `esia`.`user` ON `user_presence`.`id_user`=`esia`.`user`.`id`
				LEFT OUTER JOIN `esia`.`user_execution` ON `user_execution`.`id_user`=`esia`.`user`.`id` AND  `user_execution`.`rate`=1 AND  `user_execution`.`is_deleted` = 0 AND `user_execution`.`id_position` != 0 
				LEFT OUTER JOIN `esia`.`department` ON `user_execution`.`id_department`=`esia`.`department`.`id` 
				LEFT OUTER JOIN `room` ON `presence_schedule`.`id_room` = `room`.`id` WHERE (`room_user`.`id`='".$id_room."' OR `room`.`id`='".$id_room."')";
		if($date_begin && $date_end) {
			$sql.= " AND `user_presence`.`date_create`>='".$date_begin."' AND `user_presence`.`date_create`<='".$date_end."' ";
		}
		$sql .=" ORDER BY `user_presence`.`date_create` DESC,`date` DESC,`lesson_num` DESC";
		if($limit) $sql .= " LIMIT ".$limit;
		
		$item = $this->db_instance->getListData($sql, array('date','name','name_user','lesson_num','type','date_create','id_user','is_student','is_empl','id_department','dep'));
		return $item;
	}	
	
	public function getMeetList($id_room = null){
		$sql = "SELECT * FROM `user_meet` WHERE `is_deleted`=0 ";
		if($id_room) $sql .= " AND `id_room`='".$id_room."'";
		return $this->db_instance->getListData($sql, array('id','name','id_room','date'));
	}
	
	public function getMeet($id_meet = null){
		$sql = "SELECT * FROM `user_meet` WHERE `is_deleted`=0  AND `id`='".$id_meet."'";
		return $this->db_instance->getOneData($sql, array('id','name','id_room','date'));
	}
	
	public function getUserMeetList($id_meet,$id_user = null){
		$sql = "SELECT `id_user` FROM `user_to_meet` WHERE `id_meet`='".$id_meet."' AND `is_deleted`=0 ";
		if($id_user)  {
			$sql .= " AND `id_user`='".$id_user."'";
			return $this->db_instance->getOneData($sql, array('id_user'));
		} else {
			return $this->db_instance->getListData($sql, array('id_user'));
		}
	}
	
	public function insertUserToMeet ($id_user, $id_meet) {
		$sql ="INSERT INTO `user_to_meet` SET `id_user`='".$id_user."', `id_meet`='".$id_meet."'";
		$this->db_instance->query($sql);
	}

	
	public function getUserOnMeet($id_meet,$id_room, $date){
		$sql = "SELECT `lk`.`user_to_meet`.`id_user`, CONCAT_WS(' ',`lastname`,`firstname`,`secondname`) AS `name`, `user_presence`.`date_create`  
				FROM `lk`.`user_to_meet` 
				LEFT OUTER JOIN `esia`.`user` ON `esia`.`user`.`id`= `lk`.`user_to_meet`.`id_user` 
				LEFT OUTER JOIN `lk`.`user_presence` ON `lk`.`user_presence`.`id_user`= `lk`.`user_to_meet`.`id_user` 
				AND `lk`.`user_presence`.`id_room`='".$id_room."'
				AND `lk`.`user_presence`.`date_create`>='".($date-3600)."' AND `lk`.`user_presence`.`date_create`<='".($date+5400)."'
				WHERE `id_meet`='".$id_meet."'  ORDER BY `name`";
		return $this->db_instance->getListData($sql, array('id_user','name','date_create'));
	}
	
	public function getErrParusList($ord = null){
		$sql = "SELECT `id`,`eios_id`,`familyname`,`firstname`,`lastname`,`error_text`, `faculty`, `stgroup`, `datevvoda`, `doc_pref`, `doc_numb`, `doc_date`
				FROM `user_flags5` ";
		//		WHERE `error_text` IS NOT NULL AND `error_text`!=''";
		if($ord == 1) {
			$sql .= "ORDER BY `faculty`, `familyname`,`firstname`,`lastname`";
		} elseif($ord == 2) {
			$sql .= "ORDER BY `datevvoda` DESC, `familyname`,`firstname`,`lastname`";
		} else {
			if($ord) $sql .= " WHERE `datevvoda`='".$ord."' ORDER BY `familyname`,`firstname`,`lastname` ";
			else $sql .= "ORDER BY `familyname`,`firstname`,`lastname`";
		}
		return $this->db_instance7->getListData($sql, array('id','eios_id','familyname','firstname','lastname','error_text', 'faculty', 'stgroup', 'datevvoda', 'doc_pref', 'doc_numb', 'doc_date'));
	}
	
	public function getUserIPPR($id_user=0, $id_exec=0, $id_group=0){
		$sql = "SELECT * FROM `user_ippr` WHERE `id_user`='".$id_user."' AND `id_exec`='".$id_exec."' AND `is_deleted`=0";
		//echo $sql;
		return $this->db_instance2->getOneData($sql, $this->item_ippr);
	}
	public function getUserIPPRPlan($id){
		$sql = "SELECT * FROM `user_ippr_plan` WHERE `id_ippr`='".$id."' AND `is_deleted`=0";
		return $this->db_instance2->getListData($sql, $this->item_ippr_dop);
	}

	public function getControlMark($id_exec=0, $id_user=0, $id_position=0, $id_spec=0, $cardHome=0) {
		$nomark_lk = $this->getControlLK($id_exec, $id_user, $id_position, $id_spec, $cardHome);		
	}

	private function getControlMoodle($id_exec=0, $id_user=0) {

	}

	private function getControlLK($id_exec=0, $id_user=0, $id_position=0, $id_spec=0, $cardHome=0) {
		//$sql .= "";
		$all_subject_list = $cardHome->getAllMoodleSubject($id_spec, $id_position);
		foreach ($all_subject_list as $subject_item) {
			//var_dump($subject_item);
			$sem = ($subject_item['agenum']*2 - 1)+$subject_item['semester'];
			$id_subject = $cardHome->getValues2 ( 'id_moodle', $subject_item ['mdlcourse'], 'id_semestr', $sem, 'study_subject', array ('id') );
			$ids_marks = $this->getListMarkEsia($id_subject ['id'], $id_user);
			//if($ids_marks) echo $id_user.' - '.$subject_item ['mdlcourse'].'+<br>';
			//else echo $id_user.' - '.$subject_item ['mdlcourse'].'-<br>';
		}

		//$nomark_mdl = $this->getControlMoodle($id_exec, $id_user);
	}

	public function getRightsByUser($id) {
		$sql = "SELECT `user_rights`.*, `modules`.`description`
				FROM `user_rights`
				LEFT JOIN `modules` ON `user_rights`.`id_module`=`modules`.`id` 
				WHERE `user_rights`.`id_user` ='".$id."' AND `user_rights`.`is_deleted`='0'";
		return $this->db_instance->getListData($sql, array('id','rights','id_dep','description'));
	}

	public function getGroupTeachersList($id_group) {
	    $sql = "SELECT `mdl_block_dof_s_agroups`.`name`,`mdl_block_dof_s_programms`.`departmentid` 
                FROM `mdl_block_dof_s_agroups` 
                LEFT JOIN `mdl_block_dof_s_programms` ON `mdl_block_dof_s_programms`.id=`mdl_block_dof_s_agroups`.`programmid` 
                WHERE `mdl_block_dof_s_agroups`.`status`='active' AND `mdl_block_dof_s_agroups`.`id` = '".$id_group."'; ";
	    //echo $sql;
        $id_dep = $this->db_instance3->getOneData($sql, array('departmentid'));
        return $this->getNps($id_dep['departmentid']);
    }

	public function saveUserPresens($id_presens,$id_user,$date,$id_room = 0) {
		$sql = "INSERT INTO `user_presence` SET `id_room`='".$id_room."',`id_presence`='".$id_presens."',`id_user`='".$id_user."',`date_create`='".$date."'";
		if($id_presens) {
			if(!$this->getUserPresens($id_presens, $id_user)) {
				$this->db_instance->query($sql);
				return $this->db_instance->insertId();
			} 
		} else {
			$this->db_instance->query($sql);
			return $this->db_instance->insertId();
		}
	}
	
	public function saveConference($item, $items=false) {
		if(!$items) $items = $this->item_confernce;
		$id = $this->db_instance2->saveData($item, 'conference', $items);
		return $id;
	}	
	
	public function save_esia_par($user, $items = null) {
		$id_user = $this->db_instance2->saveData($user, 'user', $items);
		return $id_user;
	}
	
	public function save_esia_exec($user, $items = null) {
		$id_user = $this->db_instance2->saveData($user, 'user_execution', $items);
		return $id_user;
	}	
	
	public function saveMoodleUser($id, $par, $val) {
		$sql ="UPDATE moodle.mdl_block_dof_s_persons SET `".$par."`='".$val."' WHERE `id`=".$id."";
		 
		$this->db_instance3->query($sql);
	}
	
	public function saveMoodleUserEmail($id, $email) {
		$sql = "UPDATE moodle.mdl_block_dof_s_persons mbdsp
    				LEFT JOIN moodle.mdl_user mu ON mbdsp.mdluser = mu.id
    				SET mbdsp.email = '".$email."', mu.email = '".$email."' WHERE mbdsp.id = ".$id."; ";
		$this->db_instance3->query($sql);
	}

	public function saveMoodleUserPhone($id, $phone) {
		$sql = "UPDATE moodle.mdl_block_dof_s_persons mbdsp
    				LEFT JOIN moodle.mdl_user mu ON mbdsp.mdluser = mu.id
    				SET mbdsp.phonework = '".$phone."', mu.phone1 = '".$phone."' WHERE mbdsp.id = ".$id."; ";
		$this->db_instance3->query($sql);
	}
	
	public function saveSphinx($id, $mayfer, $mayfer_date_begin=0, $mayfer_date_end=0) {
		$sql = "UPDATE `personal` SET `CODEKEY`=".$mayfer." WHERE `id` = ".$id."; ";
		$this->db_instance6->query($sql);
	}
	
	public function save($table, $item, $items = false) {
		$id = $this->db_instance->saveData($item, $table, $items);
		return $id;
	}

	public function save_rights($table, $item, $items = false) {
		$sql = "INSERT INTO `user_rights` SET `id_user`='".$item['id_user']."', `id_module`='".$item['id_module']."', `rights`=b'".$item['rights']."'";
		if($item['id_dep']) $sql .=" , `id_dep`='".$item['id_dep']."'";
		$this->db_instance->query($sql);
		return $id;
	}	
	
	public function save_esia($table, $item, $items = false) {
		$id = $this->db_instance2->saveData($item, $table, $items);
		return $id;
	}
	
	public function del($table, $id) {
	$sql = "UPDATE `".$table."` SET `is_deleted`=1 WHERE `id`='".$id."'";
		$this->db_instance->query($sql);
	}
	public function delIPPR($id) {
	$sql = "UPDATE `user_ippr_plan` SET `is_deleted`=1 WHERE `id_ippr`='".$id."'";
		$this->db_instance2->query($sql);
	}
}
?>