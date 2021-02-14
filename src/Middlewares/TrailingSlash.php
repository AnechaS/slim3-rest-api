<?php

namespace App\Middlewares;

class TrailingSlash {

    public function __invoke($req, $res, $next) {
        $uri = $req->getUri();
        $path = $uri->getPath();

        if ($path != '/' && substr($path, -1) == '/') {
            $uri = $uri->withPath(substr($path, 0, -1));
    
            if($req->getMethod() == 'GET') {
                return $res->withRedirect((string)$uri, 301);
            }
            else {
                return $next($req->withUri($uri), $res);
            }
        }
        
        return $next($req, $res);
    }
}