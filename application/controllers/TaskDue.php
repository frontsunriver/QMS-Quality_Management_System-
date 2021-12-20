<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH.'/libraries/BaseController.php';
class TaskDue extends BaseController//CI_Controller
{
	public function __construct(){
        parent::__construct();
        $this->load->library('session');
	}

    public function sendNotification() {

        $sql = "SELECT `control_list`.id, control_list.process_id, control_list.`name` , c.consultant_name, control_list.review_date,
            control_list.sme, e1.employee_name process_owner_name, e1.employee_email process_owner_email,
            control_list.responsible_party, e2.employee_name inspector_name, e2.employee_email inspector_email,
            `frequency`.`frequency_name`, `frequency`.`days`, `frequency`.`type`,
            DATEDIFF(control_list.review_date, IF (`control_list`.active <> 1, `control_list`.`active_at`, now())) due,
            IF (`control_list`.active <> 1, `control_list`.`active_at`, now()) now_date
            FROM `control_list`
            LEFT JOIN employees e1 ON e1.employee_id = control_list.sme
            LEFT JOIN employees e2 ON e2.employee_id = control_list.responsible_party
            LEFT JOIN `process` ON `process`.`id` = `control_list`.`process_id`
            LEFT JOIN `risk` ON `process`.`risk_id` = `risk`.`id`
            LEFT JOIN `frequency` ON `frequency`.`frequency_id` = `control_list`.`frequency`
            LEFT JOIN consultant c ON c.consultant_id = e1.consultant_id
            WHERE control_list.review_date is not null
            ORDER BY `control_list`.`status` ASC, `review_date` DESC  limit 2";


        $Tit_due_in = "Task is Due in";
        $email_temp_due_in_inspector = $this->getEmailTemp('Task is Due in to Inspector');
        $email_temp_due_in_process_owner = $this->getEmailTemp('Task is Due in to Process Owner');

        $Tit_due_today = "Task is Due today";
        $email_temp_due_today_inspector = $this->getEmailTemp('Task is Due today to Inspector');
        $email_temp_due_today_process_owner = $this->getEmailTemp('Task is Due today to Process Owner');

        $Tit_due_on = "Task is Past Due";
        $email_temp_past_due_inspector = $this->getEmailTemp('Task is Past Due to Inspector');
        $email_temp_pPast_due_process_owner = $this->getEmailTemp('Task is Past Due to Process Owner');

        $datas = $this->db->query($sql)->result();

        foreach($datas as $data) {
            $review_date = $data->review_date;
            $actionName = $data->name;
            $due_date = $data->due;
            $days = $data->days;
            $admin_name = $data->consultant_name;
            $process_owner_name = $data->process_owner_name;
            $process_owner_email = $data->process_owner_email;
            $inspector_name = $data->inspector_name;
            $inspector_email = $data->inspector_email;

            $due = $due_date + $days;
            $email_inspector = $email_temp_due_in_inspector;
            $email_proces_owner = $email_temp_due_in_process_owner;
            $tit = $Tit_due_in;

            if($due > 7)
                continue;

            if($due == 0){
                $email_inspector = $email_temp_due_today_inspector;
                $email_proces_owner = $email_temp_due_today_process_owner;
                $tit = $Tit_due_today;
            }
            if($due < 0){
                $email_inspector = $email_temp_past_due_inspector;
                $email_proces_owner = $email_temp_pPast_due_process_owner;
                $tit = $Tit_due_on;
            }

            $due = abs($due);
            if($due == 1)
                $due = $due." day";
            else
                $due = $due." days";

            $due_date = date('Y-m-d', strtotime($review_date . ' + ' . $days . ' days'));

            $email_inspector['message'] = str_replace("{Inspector NAME}", $inspector_name, $email_inspector['message']);
            $email_inspector['message'] = str_replace("{Admin NAME}", $admin_name, $email_inspector['message']);
            $email_inspector['message'] = str_replace("{Name}", $actionName, $email_inspector['message']);
            $email_inspector['message'] = str_replace("{Date}", $due_date, $email_inspector['message']);
            $email_inspector['message'] = str_replace("{number of Days}", $due, $email_inspector['message']);
            $email_inspector['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_inspector['message']);

            $this->sendemail($inspector_email, $tit, $email_inspector['message'], $email_inspector['subject']);

            $email_proces_owner['message'] = str_replace("{Process Owner NAME}", $process_owner_name, $email_proces_owner['message']);
            $email_proces_owner['message'] = str_replace("{Admin NAME}", $admin_name, $email_proces_owner['message']);
            $email_proces_owner['message'] = str_replace("{Name}", $actionName, $email_proces_owner['message']);
            $email_proces_owner['message'] = str_replace("{Date}", $due_date, $email_proces_owner['message']);
            $email_proces_owner['message'] = str_replace("{number of Days}", $due, $email_proces_owner['message']);
            $email_proces_owner['message'] = str_replace("{LOGO}", "<img src='cid:logo'>", $email_proces_owner['message']);

            $this->sendemail($process_owner_email, $tit, $email_proces_owner['message'], $email_proces_owner['subject']);
        }
    }
}
