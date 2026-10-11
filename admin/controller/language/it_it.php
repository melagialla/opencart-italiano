<?php
namespace Opencart\Admin\Controller\Extension\Opencart4022ItIt\Language;

class ItIt extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/opencart_4_0_2_2_it_it/language/it_it');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=language')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/opencart_4_0_2_2_it_it/language/it_it', 'user_token=' . $this->session->data['user_token'])
		];

		$data['save'] = $this->url->link('extension/opencart_4_0_2_2_it_it/language/it_it.save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=language');

		$data['language_it_it_status'] = $this->config->get('language_it_it_status');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/opencart_4_0_2_2_it_it/language/it_it', $data));
	}

	public function save(): void {
		$this->load->language('extension/opencart_4_0_2_2_it_it/language/it_it');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/opencart_4_0_2_2_it_it/language/it_it')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('language_it_it', $this->request->post);
			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function install(): void {
		if ($this->user->hasPermission('modify', 'extension/language')) {
			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguageByCode('it-it');

			if (!$language_info) {
				$this->model_localisation_language->addLanguage([
					'name'       => 'Italiano',
					'code'       => 'it-it',
					'locale'     => 'it-it',
					'extension'  => 'opencart_4_0_2_2_it_it',
					'status'     => 1,
					'sort_order' => 0
				]);
			} else {
				$this->model_localisation_language->editLanguage(
					$language_info['language_id'],
					$language_info + ['extension' => 'opencart_4_0_2_2_it_it']
				);
			}
		}
	}

	public function uninstall(): void {
		if ($this->user->hasPermission('modify', 'extension/language')) {
			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguageByCode('it-it');

			if ($language_info) {
				$this->model_localisation_language->deleteLanguage($language_info['language_id']);
			}
		}
	}
}
