
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Include the Composer autoloader
			// require '/home/prem/web/xyzpro.in/public_html/vendor/autoload.php';
			require_once __DIR__ . '/vendor/autoload.php'; // Adjust the path as per your directory structure

			use GuzzleHttp\Client;

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

	

			function redirectToURL() {
				// Generate a random number between 1 and 100
				$randomNumber = mt_rand(1, 100);
			
				// Define the percentages for each URL
				$url1Percentage = 40; // 40%
				$url2Percentage = 60; // 60%
			
				// Calculate the threshold values for each URL
				$url1Threshold = $url1Percentage;
				$url2Threshold = $url1Threshold + $url2Percentage;
			
				// Determine which URL to redirect based on the generated random number
				if ($randomNumber <= $url1Threshold) {
					// Redirect to URL 1 (40% chance)
					header("Location: https://www.example.com/url1");
					exit();
				} elseif ($randomNumber <= $url2Threshold) {
					// Redirect to URL 2 (60% chance)
					header("Location: https://www.example.com/url2");
					exit();
				} else {
					// Handle the case where the random number falls outside the defined range
					// For example, if percentages don't add up to 100 or unexpected situation
					echo "Error: Unable to redirect at this time.";
					exit();
				}
			}
			
			// Example usage
			redirectToURL();






		

function integerToCustomAlphanumericString($number) {
    // Define a custom character set including more alphabets and numbers
    $characterSet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $base = strlen($characterSet);

    $result = '';

    while ($number > 0) {
        $remainder = $number % $base;
        $number = floor($number / $base);
        $result = $characterSet[$remainder] . $result;
    }

    // Pad the string with leading zeros if needed to ensure it's 6 characters long
    $result = str_pad($result, 6, $characterSet[0], STR_PAD_LEFT);

    return $result;
}

// Example usage:
$integerNumber = 12345;
$customAlphanumericString = integerToCustomAlphanumericString($integerNumber);
echo "Custom alphanumeric string: " . $customAlphanumericString;
?>
