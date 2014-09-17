<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Blogs extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> helper('url');

	}

	public function index() {

		$data['title'] = "Blog";
		$data['content_view'] = "blog_v";
		$data['banner_text'] = "Blog";
		$data['left_content']="true";
		
		$data['all'] = Blog::getAll();
		$data['link'] = "blog_v";
		$data['quick_link'] = "contact";
		$this -> load -> view("template", $data);
	}

	public function post_blog() {
		$post = $_POST['blog_post'];
		$title = $_POST['heading'];
		$time = date("Y-m-d G:i:s", time());
		$u_id = $this -> session -> userdata('user_id');
		$u = new Blog();
		$u -> title = $title;
		$u -> post = $post;
		$u -> user_id = $u_id;
		$u -> time_p = $time;
		$u -> save();
		$this -> index();
	}

	public function view() {
		$id = $this -> uri -> segment(3);
		$data['title'] = "View Blog";
		$data['content_view'] = "view_blog";
		$data['banner_text'] = "View Blog";
		$data['left_content']="true";
		
		$data['all1'] = Blog_Comment::getAll($id);
		$data['all'] = Blog::viewBlog($id);
		$data['link'] = "view_blog";
		$data['quick_link'] = "contact";
		$this -> load -> view("template", $data);
	}

	public function post_comment() {
		$id=$_POST['pcomments'];
		$comments=$_POST['comments'];
		$time = date("Y-m-d G:i:s", time());
		$state = new Blog_Comment();
		$state -> blog_id = $id;
		$state -> date_b = $time;
		$state->comment=$comments;
		$state -> save();
		
		$data['title'] = "View Blog";
		$data['content_view'] = "view_blog";
		$data['banner_text'] = "View Blog";
		$data['incident'] = Incidence::get_incidence_count();
		$data['disease'] = Incidence::get_disease_count();
		$data['confirm'] = Incidence::confirm();
		$data['list'] = Diseases::getAll();
		$data['all1'] = Blog_Comment::getAll($id);
		$data['all'] = Blog::viewBlog($id);
		$data['link'] = "view_blog";
		$data['quick_link'] = "contact";
		$this -> load -> view("template", $data);
	}

}
