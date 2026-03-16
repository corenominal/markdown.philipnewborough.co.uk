<?php

namespace App\Controllers;

use League\CommonMark\GithubFlavoredMarkdownConverter;

class Home extends BaseController
{
    /**
     * Display the home page
     *
     * Renders the home view with associated stylesheets and scripts.
     * Sets up the page title and passes data to the view layer.
     *
     * @return string The rendered home view
     */
    public function index(): string
    {
        // Array of javascript files to include
        $data['js'] = ['home', 'markdown-expanders'];
        // Array of CSS files to include
        $data['css'] = ['home'];
        // Set the page title
        $data['title'] = 'Markdown Converter';
        return view('home', $data);
    }

    /**
     * Convert Markdown to HTML
     *
     * Accepts a JSON POST body with a 'markdown' key and returns
     * the converted HTML using GithubFlavoredMarkdownConverter.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function convert(): \CodeIgniter\HTTP\ResponseInterface
    {
        try {
            $data = $this->request->getJSON(true);
        } catch (\Exception) {
            return $this->response->setJSON(['error' => 'Invalid JSON'])->setStatusCode(400);
        }

        if (empty($data) || !isset($data['markdown'])) {
            return $this->response->setJSON(['error' => 'Invalid request'])->setStatusCode(400);
        }

        if (!is_string($data['markdown'])) {
            return $this->response->setJSON(['error' => 'Invalid markdown format'])->setStatusCode(400);
        }

        if (trim($data['markdown']) === '') {
            return $this->response->setJSON(['error' => 'Markdown cannot be empty'])->setStatusCode(400);
        }

        if (strlen($data['markdown']) > 1_000_000) {
            return $this->response->setJSON(['error' => 'Markdown exceeds maximum size (1 MB)'])->setStatusCode(400);
        }

        $converter = new GithubFlavoredMarkdownConverter();
        $html = $converter->convert($data['markdown'])->getContent();

        return $this->response->setJSON(['html' => $html]);
    }
}
