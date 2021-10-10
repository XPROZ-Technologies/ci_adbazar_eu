<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('customer', $this->language);


    }

    public function index() {
        $this->loadModel(array('Mconfigs', 'Mservices'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Services');
        $data['activeMenu'] = "services";
        /**
         * Commons data
         */
        
        $data['activeMenuService'] = 0;

        $data['services'] = $this->Mservices->getHighlightListByLang($data['language_id']);
        
        $this->load->view('frontend/service/customer-service', $data);
    }

    public function detail($slug = '', $id = 0) {
        if(empty($id)){
            redirect('services.html');
        }

        $this->loadModel(array('Mconfigs', 'Mservices', 'Mbusinessprofiles', 'Mservicetypes', 'Mbusinessservicetype'));

        $serviceId = $this->Mservices->getFieldValue(array('id' => $id, 'service_status_id' => STATUS_ACTIVED), 'id', 0);

        if($serviceId == 0){
            redirect('services.html');
        }

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Service Detail');
       
        $data['activeMenu'] = "services";
        /**
         * Commons data
         */

        $data['activeMenuService'] = $serviceId;

        $service_name = "service_name_".$this->Mconstants->languageShortCodes[$data['language_id']];
        $data['serviceInfo'] = $this->Mservices->get($serviceId, true, '', "{$service_name} as service_name, id, service_name_en as service_slug");

        $service_type_name = "service_type_name_".$this->Mconstants->languageShortCodes[$data['language_id']];
        $data['serviceTypes'] = $this->Mservicetypes->getBy(array('service_id' => $serviceId), false, "display_order", "{$service_type_name} as service_type_name, id");
        
        $per_page = $this->input->get('per_page');
        $data['per_page'] = $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] = $search_text;
        $service_types = $this->input->get('service_types');
        $data['service_types'] =  explode(',', $service_types);
        
        $getData = array('service_id' => $serviceId, 'business_status_id' => STATUS_ACTIVED, 'search_text_fe' => $search_text);
        $rowCount = $this->Mbusinessprofiles->getCount($getData);
        $data['listProfiles'] = array();
        
        /**
         * PAGINATION
         */
        $perPage = DEFAULT_LIMIT_BUSINESS_PROFILE;
        //$perPage = 2;
        if(is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
        $pageCount = ceil($rowCount / $perPage);
        $page = $this->input->get('page');
        if(!is_numeric($page) || $page < 1) $page = 1;
        $data['baseServiceUrl'] = base_url('service/'.makeSlug($data['serviceInfo']['service_slug']).'-'.$data['serviceInfo']['id'].'.html');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['baseServiceUrl'].'?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['listProfiles'] = $this->Mbusinessprofiles->search($getData, $perPage, $page);
        for($i = 0; $i < count($data['listProfiles']); $i++){
            $data['listProfiles'][$i]['businessServiceTypes'] = $this->Mservicetypes->getListByBusiness($data['listProfiles'][$i]['id'], $service_type_name);
            $data['listProfiles'][$i]['isOpen'] = $this->checkBusinessOpenHours($data['listProfiles'][$i]['id']);
        }

        $this->load->view('frontend/service/customer-service-list', $data);
    }

    public function getListServiceTypeSelect2Ajax(){
        $data = $this->commonDataCustomer('');
        $service_type_name = "service_type_name_".$this->Mconstants->languageShortCodes[$data['language_id']];
        $serviceId = $this->input->post('service_id');
        $this->load->model('Mservicetypes');
        if(empty($serviceId)) $serviceId = 0;
        $list = $this->Mservicetypes->getListServiceTypeSelect2AjaxFrontend($serviceId, $service_type_name);
        $serviceTypesHtml = "";
        if(!empty($list)){
            foreach($list as $itemService){
                $serviceTypesHtml .= '<option value="'.$itemService['id'].'">'.$itemService['service_type_name'].'</option>';
            }
        }
        echo $serviceTypesHtml;die;
    }
    
}