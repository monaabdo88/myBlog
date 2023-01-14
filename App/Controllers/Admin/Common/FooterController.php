<?php 
namespace App\Controllers\Admin\Common;
use System\Controller;
class FooterController extends Controller
{
    public function index()
    {
        $user = $this->load->model('User')->user();
        return $this->view->render('admin/common/footer', $data);
    }
}