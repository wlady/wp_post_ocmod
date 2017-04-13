<?php

class ControllerExtensionModuleWpPost extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('extension/module/wp_post');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_module->addModule('wp_post', $this->request->post);
            } else {
                $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
        }

        $labels = $this->language->all();

        if (isset($this->error['warning'])) {
            $labels['text_error_warning'] = $this->error['warning'];
        }

        if (isset($this->error['name'])) {
            $labels['text_error_name'] = $this->error['name'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/wp_post', 'token=' . $this->session->data['token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/wp_post', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }

        $links = array();
        if (!isset($this->request->get['module_id'])) {
            $links['action'] = $this->url->link('extension/module/wp_post', 'token=' . $this->session->data['token'], true);
        } else {
            $links['action'] = $this->url->link('extension/module/wp_post', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
        }
        $links['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);
        $data['links'] = $links;

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
        }

        $data['token'] = $this->session->data['token'];

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        $this->load->helper('wp_post');
        $this->load->config('wp_post');
        $url = $this->config->get('wp_address') . $this->config->get('wp_posts');
        $res = curl_get($url);
        if ($res) {
            $categories = json_decode($res);
            foreach ($categories as $category) {
                $data['categories'][$category->id] = $category->name;
                $data['cats'][$category->name] = 0;
            }
        }

        if (!empty($module_info['categories'])) {
            $data['cats'] = $module_info['categories'];
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['limit'])) {
            $data['limit'] = $this->request->post['limit'];
        } elseif (!empty($module_info)) {
            $data['limit'] = $module_info['limit'];
        } else {
            $data['limit'] = 5;
        }

        if (isset($this->request->post['sort'])) {
            $data['sort'] = $this->request->post['sort'];
        } elseif (!empty($module_info)) {
            $data['sort'] = $module_info['sort'];
        } else {
            $data['sort'] = 'desc';
        }

        if (isset($this->request->post['order'])) {
            $data['order'] = $this->request->post['order'];
        } elseif (!empty($module_info)) {
            $data['order'] = $module_info['order'];
        } else {
            $data['order'] = '';
        }

        if (isset($this->request->post['tpl'])) {
            $data['tpl'] = $this->request->post['tpl'];
        } elseif (!empty($module_info)) {
            $data['tpl'] = $module_info['tpl'];
        } else {
            $data['tpl'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = 0;
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $data['i18n'] = $labels;

        $this->response->setOutput($this->load->view('extension/module/wp_post', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/wp_post')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }
}
