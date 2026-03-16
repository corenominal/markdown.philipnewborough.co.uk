<?php

namespace App\Controllers\Api;

use League\CommonMark\GithubFlavoredMarkdownConverter;

class Converter extends BaseController
{

    /**
     * Handles the conversion of Markdown to HTML via an API endpoint.
     *
     * @return \CodeIgniter\HTTP\Response
     * 
     * This method performs the following steps:
     * 1. Attempts to retrieve JSON data from the request.
     *    - Returns an error response if the JSON is invalid.
     * 2. Validates the request data to ensure it contains a 'markdown' key.
     *    - Returns an error response if the request is invalid or the 'markdown' key is missing.
     * 3. Ensures the 'markdown' data is a non-empty string.
     *    - Returns an error response if the 'markdown' data is empty or not a string.
     * 4. Converts the provided Markdown string to HTML using the `GithubFlavoredMarkdownConverter`.
     * 5. Returns the converted HTML in the response as JSON.
     * 
     * Error Responses:
     * - `['error' => 'Invalid JSON']` if the JSON data cannot be parsed.
     * - `['error' => 'Invalid request']` if the request data is empty or missing the 'markdown' key.
     * - `['error' => 'Invalid markdown format']` if the 'markdown' data is not a string.
     * - `['error' => 'Markdown cannot be empty']` if the 'markdown' data is an empty string.
     * 
     * Success Response:
     * - Returns a JSON object containing the original 'markdown' and the converted 'html'.
     */
    public function index()
    {
        // Try to get the JSON data from the request, or return an error if it fails
        try {
            $data = $this->request->getJSON(true);
        } catch (\Exception) {
            return $this->response->setJSON(['error' => 'Invalid JSON'])->setStatusCode(400);
        }

        // Check if the request is valid
        if (empty($data) || !isset($data['markdown'])) {
            return $this->response->setJSON(['error' => 'Invalid request'])->setStatusCode(400);
        }

        // Validate the markdown data
        if (!is_string($data['markdown'])) {
            return $this->response->setJSON(['error' => 'Invalid markdown format'])->setStatusCode(400);
        }

        // Check if the markdown is empty
        if (trim($data['markdown']) === '') {
            return $this->response->setJSON(['error' => 'Markdown cannot be empty'])->setStatusCode(400);
        }

        // Convert the markdown to HTML
        $converter = new GithubFlavoredMarkdownConverter();
        $html = $converter->convert($data['markdown']);
        $data['html'] = $html->getContent();
        // Return the HTML
        return $this->response->setJSON($data);
    }
}