<?php

class User {
	private $user_id;
	private $user_group_id;
	private $username;
	private $permission = array();

	public function __construct() {
        $this->CI =& get_instance();

		if (isset($this->CI->session->data['user_id'])) {
			$user_query = $this->CI->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$this->CI->session->data['user_id'] . "' AND status = '1'");

			if ($user_query->num_rows) {
				$this->CI->user_id = $user_query->row['user_id'];
				$this->CI->username = $user_query->row['username'];
				$this->CI->user_group_id = $user_query->row['user_group_id'];

				$this->CI->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" .$_SERVER['REMOTE_ADDR'] . "' WHERE user_id = '" . (int)$this->CI->session->data['user_id'] . "'");

				$user_group_query = $this->CI->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

				$permissions = json_decode($user_group_query->row['permission'], true);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->CI->permission[$key] = $value;
					}
				}
			} else {
				$this->CI->logout();
			}
		}
	}

	public function login($username, $password) {
		$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");

		if ($user_query->num_rows) {
			$this->session->data['user_id'] = $user_query->row['user_id'];

			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];
			$this->user_group_id = $user_query->row['user_group_id'];

			$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

			$permissions = json_decode($user_group_query->row['permission'], true);

			if (is_array($permissions)) {
				foreach ($permissions as $key => $value) {
					$this->permission[$key] = $value;
				}
			}

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['user_id']);

		$this->user_id = '';
		$this->username = '';
	}

	public function hasPermission($key, $value) {
		if (isset($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	}

	public function isLogged() {
		return $this->user_id;
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUserName() {
		return $this->username;
	}

	public function getGroupId() {
		return $this->user_group_id;
	}
}