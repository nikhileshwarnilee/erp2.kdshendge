<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Feetype extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('fees_type', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'feetype/index');

        $this->form_validation->set_rules(
            'code', $this->lang->line('fees_code'), array(
                'required',
                array('check_exists', array($this->feetype_model, 'check_exists')),
            )
        );
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'required');
        if ($this->form_validation->run() == false) {

        } else {
            $data = array(
                'type'                       => $this->input->post('name'),
                'code'                       => $this->input->post('code'),
                'description'                => $this->input->post('description'),
                'include_in_search_due_fees' => (int) $this->input->post('include_in_search_due_fees'),
            );
            $this->feetype_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/feetype/index');
        }
        $feegroup_result     = $this->feetype_model->get();
        $data['feetypeList'] = $feegroup_result;

        $this->load->view('layout/header', $data);
        $this->load->view('admin/feetype/feetypeList', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('fees_type', 'can_delete')) {
            access_denied();
        }

        $this->feetype_model->remove($id);
        redirect('admin/feetype/index');
    }

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('fees_type', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'feetype/index');
        $data['id']          = $id;
        $feetype             = $this->feetype_model->get($id);
        $data['feetype']     = $feetype;
        $feegroup_result     = $this->feetype_model->get();
        $data['feetypeList'] = $feegroup_result;
        $this->form_validation->set_rules(
            'name', $this->lang->line('name'), array(
                'required',
                array('check_exists', array($this->feetype_model, 'check_exists')),
            )
        );
        $this->form_validation->set_rules('code', $this->lang->line('fees_code'), 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/feetype/feetypeEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id'                         => $id,
                'type'                       => $this->input->post('name'),
                'code'                       => $this->input->post('code'),
                'description'                => $this->input->post('description'),
                'include_in_search_due_fees' => (int) $this->input->post('include_in_search_due_fees'),
            );
            $this->feetype_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/feetype/index');
        }
    }

    public function changeSearchDueFeesStatus()
    {
        if (!$this->rbac->hasPrivilege('fees_type', 'can_edit')) {
            access_denied();
        }

        $id                         = (int) $this->input->post('id');
        $include_in_search_due_fees = (int) $this->input->post('include_in_search_due_fees');

        if (!in_array($include_in_search_due_fees, array(0, 1), true)) {
            echo json_encode(array('status' => 0, 'message' => 'Invalid selection.'));
            return;
        }

        $result = $this->feetype_model->updateSearchDueFeesStatus($id, $include_in_search_due_fees);

        if ($result) {
            echo json_encode(array('status' => 1, 'message' => $this->lang->line('update_message')));
        } else {
            echo json_encode(array('status' => 0, 'message' => $this->lang->line('something_went_wrong')));
        }
    }

}
