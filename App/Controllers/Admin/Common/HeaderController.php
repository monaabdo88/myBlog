<?php 
namespace App\Controllers\Admin\Common;
use System\Controller;
class HeaderController extends Controller
{
    public function index()
    {
        $data['title'] = $this->html->getTitle();
        $data['user']  = $this->load->model('User')->user();
        return $this->view->render('admin/common/header', $data);
    }
}