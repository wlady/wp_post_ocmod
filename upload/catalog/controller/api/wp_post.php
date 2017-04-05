<?php

/**
 * Class ControllerApiWpPost
 * User: wlady
 * Date: 03.03.17
 * Time: 18:30
 */
class ControllerApiWpPost extends Controller {

    /**
     * Получить запись WP в виде закодированного в base64 объекта
     * и сохранить в базу
     */
    public function index() {

        $this->load->language('api/wp_post');
		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$post_data = unserialize(base64_decode($this->request->post['post']));
			// запись WP должна быть в форме массива
            if (!is_array($post_data)) {
                $json['error'] = $this->language->get('error_wp_post');
            } else {
                $this->load->model('wp/post');
                $this->model_wp_post->add($this->session->data['api_id'], $post_data);
                $json['success'] = $this->language->get('text_success');
            }
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
