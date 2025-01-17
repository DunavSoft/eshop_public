<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LocaleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Directly get the first URI segment (which should be the locale)
        $localeSegment = $request->uri->getSegment(1);

        $config = new \Config\App();
        if (!in_array($localeSegment, $config->supportedLocales)) {
            // If the segment isn't a valid locale, throw a 404 error.
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing required in this case.
    }
}