<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 首页
class Welcome extends MY_Controller
{
    protected $seo_id;
    protected $banner_id;

    public function __construct()
    {
        parent::__construct();

        $this->load->helpers('uisite_helper');

        $this->seo_id = 1;
        $this->banner_id = 2;
    }

    // 首页
    public function index()
    {
        $data = array();

        // seo
        $data['header'] = header_seoinfo(0, 0);

        // local name
        $data['local_name'] = '首页';

        // banners
        $data['banners'] = $this->db->order_by('sort_id', 'desc')->get_where('banners', array('audit' => 1, 'cid' => $this->banner_id))->result_array();
        foreach ($data['banners'] as $key => $banner) {
            list($data['banners'][$key]['title'], $data['banners'][$key]['sub_title']) = explode('|', $banner['title']);
            $data['banners'][$key]['photo'] = tag_photo($banner['photo'], 'url');
        }

        // marketing
        $data['marketing']['title'] = $this->db->get_where('page', array('cid' => 5))->row_array();
        $data['marketing']['banners'] = $this->db->order_by('sort_id', 'asc')->where_in('cid', array(6, 7, 8, 9))->get('page')->result_array();
        foreach ($data['marketing']['banners'] as $key => $banner) {
            $data['marketing']['banners'][$key]['photo'] = tag_photo($banner['photo'], 'url');
        }

        // ecommerce
        $data['ecommerce']['title'] =  $this->db->get_where('page', array('cid' => 11))->row_array();
        $data['ecommerce']['b2c'] = tag_single(12, 'content');
        $data['ecommerce']['o2o'] = $this->db->get_where('page', array('cid' => 13))->row_array();
        $data['ecommerce']['o2o']['photo'] = tag_photo($data['ecommerce']['o2o']['photo'], 'url');

        // tourism
        $data['tourism']['title'] = $this->db->get_where('page', array('cid' => 15))->row_array();
        $data['tourism']['banners'] = $this->db->order_by('sort_id', 'asc')->where_in('cid', array(16, 17, 18, 19))->get('page')->result_array();
        foreach ($data['tourism']['banners'] as $key => $banner) {
            $data['tourism']['banners'][$key]['photo'] = tag_photo($banner['photo'], 'url');
        }

        // media
        $data['media']['title'] = $this->db->get_where('page', array('cid' => 21))->row_array();
        $data['media']['banners'] = $this->db->order_by('sort_id', 'asc')->where_in('cid', array(22, 23, 24, 25, 26, 27))->get('page')->result_array();
        foreach ($data['media']['banners'] as $key => $banner) {
            $data['media']['banners'][$key]['photo'] = tag_photo($banner['photo'], 'url');
        }

        // footer
        $data['footer']['navigation'] = tag_single(29, 'content');
        $data['footer']['icp'] = tag_single(30, 'content');
        $data['footer']['mp'] = $this->db->get_where('page', array('cid' => 31))->row_array();
        $data['footer']['mp']['photo'] = tag_photo($data['footer']['mp']['photo'], 'url');
        $data['footer']['iso'] = tag_photo(tag_single(32, 'photo'));

        $this->load->view('welcome', $data);
    }
}
