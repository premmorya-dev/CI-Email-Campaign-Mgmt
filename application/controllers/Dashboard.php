<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{

	    if(!$this->user->isLogged()){
           redirect('User/Login');
		}
		
		$this->load->view('common/backend/header.php');
		$this->load->view('common/backend/navbar.php');
		$this->load->view('common/backend/left_sidebar.php');
		$this->load->view('common/backend/breadcrumb.php');
		$this->load->view('backend/dashboard.php');  // main content page
		$this->load->view('common/backend/footer.php');
	}

	public function webscraper()
	{
		
		
			// Include the Composer autoloader
		
			require_once FCPATH . 'vendor/autoload.php'; // Adjust the path as per your directory structure

			//require_once '/home/prem/web/xyzpro.in/public_html/vendor/guzzlehttp/guzzle/src/Client.php';
			//use GuzzleHttp\Client;

			// Create a Guzzle client
			$client = new Client();

			// URL of the website you want to scrape
			$url = 'https://example.com';

			try {
				// Send a GET request to the website
				$response = $client->request('GET', $url);

				// Get the body of the response (HTML content)
				$html = $response->getBody()->getContents();

				// Now, you can process the HTML content using PHP's DOMDocument or other libraries
				// For example:
				$dom = new DOMDocument();
				@$dom->loadHTML($html); // Use '@' to suppress warnings about poorly formatted HTML

				// Extract specific elements or data from the HTML using DOM methods

				// Example: Get the title of the webpage
				$title = $dom->getElementsByTagName('title')->item(0)->textContent;
				echo "Title: $title";

				// Example: Find all the links in the webpage
				$links = $dom->getElementsByTagName('a');
				foreach ($links as $link) {
					echo "Link: " . $link->getAttribute('href') . "\n";
				}

				// Other parsing and extraction operations can be performed similarly

			} catch (Exception $e) {
				echo "Error: " . $e->getMessage();
			}

		}


		




}
