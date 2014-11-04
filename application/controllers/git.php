<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Git extends CI_Controller {

	public $url = 'https://api.github.com/repos/'; // link to git repositories
	public $repo = 'joyent/node'; // current repository

	public function index() {
		$data = $this->sendCurl(); // get JSON from git api
		$array = $this->convertData($data); // take only part data from that JSON

		usort($array, array($this, "cmp_git")); // sorting array by author and date inside author

		$this->load->view('layouts/header'); // load header
		$this->load->view('git', array('git' => $array));
		$this->load->view('layouts/footer'); // load footer
	}

	/*
	 * return json string 	 
	 */

	private function sendCurl() {
		$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
		$url = $this->url . $this->repo . "/commits";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return data into the variable
		curl_setopt($ch, CURLOPT_USERAGENT, $agent); // without agent git will retun permission denied

		$output = curl_exec($ch);
		curl_close($ch);

		return $output;
	}

	/*
	 * return array
	 */

	private function convertData($data) {
		$array = array();

		foreach (json_decode($data) as $k => $v) {
			$array[$k]['sha'] = $v->sha;
			$array[$k]['url'] = $v->html_url;
			$array[$k]['author'] = $v->commit->author->name;
			$array[$k]['date'] = $v->commit->author->date;
			$array[$k]['message'] = $v->commit->message;
		}

		return $array;
	}

	/*
	 * return number
	 */

	public function cmp_git($a, $b) {
		$al = strtolower($a['author']);
		$bl = strtolower($b['author']);

		if ($al == $bl)
			if ($a['date'] == $b['date'])
				return 0;
			else
				return ($a['date'] > $b['date']) ? -1 : +1; // if we have the same autor sort it by date field
		return ($al > $bl) ? +1 : -1;
	}

}
