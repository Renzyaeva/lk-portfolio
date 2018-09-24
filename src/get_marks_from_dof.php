<?php
require_once('/home/web/eiospgu/www/config.php');
require_once('/home/web/eiospgu/www/lib/moodlelib.php');
require_once('/home/web/eiospgu/www/blocks/dof/lib.php');

function pitem_semester_processor($disciplineId, $groupid, $studentid)
{
    global $DOF;
    $semestr_array = [];
    if($oDiscipline = $DOF->storage('programmitems')->get_record(array('id' => $disciplineId)))
    {
        for($i = 0; $i < ($oDiscipline->semesternum + 1); $i++)
        {
            if($semesternumdata = $DOF->storage('semesterdata')->get_semesterdata_by_pitem_and_semestrnum
            ($disciplineId, $i))
            {
                if($oDiscipline->semesternum == 0)
                {
                    $semesternum = $oDiscipline->fsemester_type;
                }
                else
                {
                    $semesternum = $i;
                }
                $res = controlevent_processor($disciplineId,$semesternumdata->id,$groupid,$studentid, $oDiscipline->vrsystemmode);
                if(is_array($res))
                {
                    $semestr_array[$semesternum] = $res;
                }
            }
        }
        if(!empty($semestr_array))
            return $semestr_array;
        else
            return null;
    }
    return null;
}

function controlevent_processor($disciplineId, $semesternumId, $groupId, $studentid, $vrs)
{
    global $DOF;
    $return_mass = [];
    if($controleventsdata = $DOF->storage('controlevents')->get_cntrlevents_by_pitem_and_smstrid($disciplineId,
        $semesternumId))
    {
        foreach($controleventsdata as $key => $val)
        {
            if($val->controltype == '6')
                continue;
            else
            {
                $res_str = getStudentMarks($disciplineId, $semesternumId, $val->id, $groupId,
                    $studentid, $vrs, $val->controltype*1);
                if($res_str != 'ERROR' AND $res_str != 'ERRORINPUTDATA')
                {
                    $return_mass[$val->controltype]['vrs'] = $vrs;
                    $return_mass[$val->controltype]['grade'] = $res_str;
                }
            }
        }
        if(!empty($return_mass))
            return $return_mass;
        else
            return 'ERROR';
    }
    return 'ERROR';
}

function getStudentMarks($disciplineId, $semesternumId, $attestationId, $groupId, $studentid, $vrs, $controltype = 0)
{
    global $DOF;
    if(isset($disciplineId) AND isset($semesternumId) AND isset($attestationId) AND isset($groupId) AND isset($studentid))
    {
        if($DOF->storage('controleventgroups')->is_fixed_controlevent_by_id($attestationId, $groupId) === false)
        {
            return 'ERROR';
        }
        elseif($DOF->storage('controlpointsagroups')->is_fix_all_controlpoints($disciplineId, $semesternumId, $groupId, $attestationId) === false AND $vrs == 0 AND $controltype != 7)
        {
            return 'ERROR';
        }
        else
        {
            $otchenka = $DOF->storage('controleventstudents')->get_txt_final_score($disciplineId, $semesternumId, $studentid, $attestationId);
            return $otchenka;
        }
    }
    else
        return 'ERRORINPUTDATA';
}
$nwarray = [[10384,322,517628992]];
    /** [23067,1967,517663359],[23082,1967,517663359],[23072,1967,517663359],[23065,1967,517663359],[23079,1967,517663359],[23067,1967,517662317],[23072,1967,517662317],[23065,1967,517662317],[23079,1967,517662317],[23079,1967,517662317],[23067,1967,517658502],[23082,1967,517658502],[23072,1967,517658502],[23065,1967,517658502],[23079,1967,517658502],[23082,1967,517658616],[23067,1967,517658616],[23072,1967,517658616],[23065,1967,517658616],[23079,1967,517658616],[23067,1967,517659825],[23072,1967,517659825],[23065,1967,517659825],[23079,1967,517659825],[23079,1967,517659825],[23067,1967,517650644],[23082,1967,517650644],[23072,1967,517650644],[23075,1967,517650644],[23065,1967,517650644],[23079,1967,517650644],[23079,1967,517650644],[23082,1967,517663497],[23067,1967,517663497],[23072,1967,517663497],[23065,1967,517663497],[23067,1967,517663882],[23082,1967,517663882],[23072,1967,517663882],[23065,1967,517663882],[23079,1967,517663882],[23079,1967,517663882],[23067,1967,517652367],[23072,1967,517652367],[23075,1967,517652367],[23079,1967,517652367],[23067,1967,517660220],[23082,1967,517660220],[23072,1967,517660220],[23065,1967,517660220],[23067,1967,517660860],[23082,1967,517660860],[23072,1967,517660860],[23065,1967,517660860],[23079,1967,517660860],[23082,1967,517661002],[23067,1967,517661002],[23072,1967,517661002],[23065,1967,517661002],[23079,1967,517661002],[23079,1967,517661002],[23082,1967,517658493],[23067,1967,517658493],[23072,1967,517658493],[23065,1967,517658493],[23079,1967,517658493],[23082,1967,517661514],[23067,1967,517661514],[23072,1967,517661514],[23065,1967,517661514],[23079,1967,517661514],[23079,1967,517661514],[23067,1967,517650239],[23072,1967,517650239],[23075,1967,517650239],[23065,1967,517650239],[23079,1967,517650239],[23079,1967,517650239],[23067,1967,517659829],[23072,1967,517659829],[23079,1967,517659829],[23082,1967,517660861],[23067,1967,517660861],[23072,1967,517660861],[23065,1967,517660861],[23082,1967,517662176],[23067,1967,517662176],[23072,1967,517662176],[23065,1967,517662176],[23067,1967,517664726],[23067,1967,517657812],[23065,1967,517657812],[23079,1967,517657812],[23067,1967,517658690],[23065,1967,517658690],[23079,1967,517658690],[23067,1967,517659854],[23065,1967,517659854],[23079,1967,517659854]]; */
foreach($nwarray as $k => $v)
    //var_dump(pitem_semester_processor($v[0], $v[1], $v[2]));  // null - ошибка
?>