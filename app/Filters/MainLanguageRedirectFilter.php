<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class MainLanguageRedirectFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        //d($request);

        $method = $request->getMethod(true);
        //d($method);
        $config = new \Config\App();
        $uri = $request->uri;
        if ($method === 'GET' && $uri->getTotalSegments() > 0 && $uri->getSegment(1) === $config->defaultLocale) {
            $newUrl = base_url($uri->setSegment(1, '')->getPath());
            return redirect()->to($newUrl, 301);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}