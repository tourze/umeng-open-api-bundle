<?php

/* Version 0.9, 6th April 2003 - Simon Willison ( http://simon.incutio.com/ )
   Manual: http://scripts.incutio.com/httpclient/
*/

class HttpClient
{
    // Request vars
    public $host;

    public $port;

    public $path;

    public $method;

    public $postdata = '';

    public $cookies = [];

    public $referer;

    public $accept = 'text/xml,application/xml,application/xhtml+xml,text/html,text/plain,image/png,image/jpeg,image/gif,*/*';

    public $accept_encoding = 'gzip';

    public $accept_language = 'en-us';

    public $user_agent = 'Incutio HttpClient v0.9';

    // Options
    public $timeout = 20;

    public $use_gzip = true;

    public $persist_cookies = true;  // If true, received cookies are placed in the $this->cookies array ready for the next request

    // Note: This currently ignores the cookie path (and time) completely. Time is not important,
    //       but path could possibly lead to security problems.
    public $persist_referers = true; // For each request, sends path of last request as referer

    public $debug = false;

    public $handle_redirects = true; // Auaomtically redirect if Location or URI header is found

    public $max_redirects = 5;

    public $headers_only = false;    // If true, stops receiving once headers have been read.

    // Basic authorization variables
    public $username;

    public $password;

    // Response vars
    public $status;

    public $headers = [];

    public $content = '';

    public $errormsg;

    // Tracker variables
    public $redirect_count = 0;

    public $cookie_host = '';

    public function __construct($host = '', $port = 80)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function HttpClient($host, $port = 80)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getHeader($header)
    {
        $header = mb_strtolower($header);
        if (isset($this->headers[$header])) {
            return $this->headers[$header];
        }

        return false;
    }

    public function getError()
    {
        return $this->errormsg;
    }

    public function getCookies()
    {
        return $this->cookies;
    }

    public function setCookies($array)
    {
        $this->cookies = $array;
    }

    public function setUserAgent($string)
    {
        $this->user_agent = $string;
    }

    public function setAuthorization($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function useGzip($boolean)
    {
        $this->use_gzip = $boolean;
    }

    public function setPersistCookies($boolean)
    {
        $this->persist_cookies = $boolean;
    }

    public function setPersistReferers($boolean)
    {
        $this->persist_referers = $boolean;
    }

    public function setHandleRedirects($boolean)
    {
        $this->handle_redirects = $boolean;
    }

    // Setter methods

    public function setMaxRedirects($num)
    {
        $this->max_redirects = $num;
    }

    public function setHeadersOnly($boolean)
    {
        $this->headers_only = $boolean;
    }

    public function setDebug($boolean)
    {
        $this->debug = $boolean;
    }

    // Option setting methods

    public function quickGet($url)
    {
        $bits = parse_url($url);
        $host = $bits['host'];
        $port = $bits['port'] ?? 80;
        $path = $bits['path'] ?? '/';
        if (isset($bits['query'])) {
            $path .= '?' . $bits['query'];
        }
        $client = new HttpClient($host, $port);
        if (!$client->get($path)) {
            return false;
        }

        return $client->getContent();
    }

    public function get($path, $data = false)
    {
        $this->path = $path;
        $this->method = 'GET';
        if ($data) {
            $this->path .= '?' . $this->buildQueryString($data);
        }

        return $this->doRequest();
    }

    public function buildQueryString($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        $parts = [];
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                $parts = array_merge($parts, $this->buildArrayQueryParts($key, $val));
            } else {
                $parts[] = urlencode($key) . '=' . urlencode($val);
            }
        }

        return implode('&', $parts);
    }

    private function buildArrayQueryParts($key, $values): array
    {
        $parts = [];
        foreach ($values as $val) {
            $parts[] = urlencode($key) . '=' . urlencode($val);
        }

        return $parts;
    }

    public function doRequest()
    {
        $fp = $this->openConnection();
        if (!$fp) {
            return false;
        }

        $this->sendRequest($fp);
        $this->readResponse($fp);
        fclose($fp);

        $this->processResponse();

        return $this->handleRedirects();
    }

    public function debug($msg, $object = false)
    {
        if ($this->debug) {
            // 使用标准 PHP 错误日志，在生产环境中应该配置合适的日志处理器
            trigger_error('[HttpClient Debug] ' . $msg, E_USER_NOTICE);
            if ($object) {
                trigger_error('[HttpClient Debug Object] ' . json_encode($object, JSON_PRETTY_PRINT), E_USER_NOTICE);
            }
        }
    }

    private function handleSocketError($errno, $errstr): void
    {
        switch ($errno) {
            case -3:
                $this->errormsg = 'Socket creation failed (-3)';
                break;
            case -4:
                $this->errormsg = 'DNS lookup failure (-4)';
                break;
            case -5:
                $this->errormsg = 'Connection refused or timed out (-5)';
                break;
            default:
                $this->errormsg = 'Connection failed (' . $errno . ')';
                $this->errormsg .= ' ' . $errstr;
        }
        $this->debug($this->errormsg);
    }

    private function parseStatusLine($line): bool
    {
        if (!preg_match('/HTTP\/(\d\.\d)\s*(\d+)\s*(.*)/', $line, $m)) {
            $this->errormsg = 'Status code line invalid: ' . htmlentities($line);
            $this->debug($this->errormsg);

            return false;
        }
        $this->status = $m[2];
        $this->debug(trim($line));

        return true;
    }

    public function buildRequest()
    {
        $headers = [];
        $headers[] = "{$this->method} {$this->path} HTTP/1.0"; // Using 1.1 leads to all manner of problems, such as "chunked" encoding
        $headers[] = "Host: {$this->host}";
        $headers[] = "User-Agent: {$this->user_agent}";
        $headers[] = "Accept: {$this->accept}";
        if ($this->use_gzip) {
            $headers[] = "Accept-encoding: {$this->accept_encoding}";
        }
        $headers[] = "Accept-language: {$this->accept_language}";
        if ($this->referer) {
            $headers[] = "Referer: {$this->referer}";
        }
        // Cookies
        if ($this->cookies) {
            $cookie = 'Cookie: ';
            foreach ($this->cookies as $key => $value) {
                $cookie .= "{$key}={$value}; ";
            }
            $headers[] = $cookie;
        }
        // Basic authentication
        if ($this->username && $this->password) {
            $headers[] = 'Authorization: BASIC ' . base64_encode($this->username . ':' . $this->password);
        }
        // If this is a POST, set the content type and length
        if ($this->postdata) {
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            $headers[] = 'Content-Length: ' . mb_strlen($this->postdata);
        }

        return implode("\r\n", $headers) . "\r\n\r\n" . $this->postdata;
    }

    public function getRequestURL()
    {
        $url = 'http://' . $this->host;
        if (80 != $this->port) {
            $url .= ':' . $this->port;
        }
        $url .= $this->path;

        return $url;
    }

    // "Quick" static methods

    public function getContent()
    {
        return $this->content;
    }

    public function quickPost($url, $data)
    {
        $bits = parse_url($url);
        $host = $bits['host'];
        $port = $bits['port'] ?? 80;
        $path = $bits['path'] ?? '/';
        $client = new HttpClient($host, $port);
        if (!$client->post($path, $data)) {
            return false;
        }

        return $client->getContent();
    }

    public function post($path, $data)
    {
        $this->path = $path;
        $this->method = 'POST';
        $this->postdata = $this->buildQueryString($data);

        return $this->doRequest();
    }

    private function openConnection()
    {
        $fp = @fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
        if (!$fp) {
            $this->handleSocketError($errno, $errstr);

            return false;
        }
        socket_set_timeout($fp, $this->timeout);

        return $fp;
    }

    private function sendRequest($fp): void
    {
        $request = $this->buildRequest();
        $this->debug('Request', $request);
        fwrite($fp, $request);

        // Reset all the variables that should not persist between requests
        $this->headers = [];
        $this->content = '';
        $this->errormsg = '';
    }

    private function readResponse($fp): void
    {
        $inHeaders = true;
        $atStart = true;

        while (!feof($fp)) {
            $line = fgets($fp, 4096);

            if ($atStart) {
                $atStart = false;
                if (!$this->parseStatusLine($line)) {
                    return;
                }
                continue;
            }

            if ($inHeaders) {
                if ($this->processHeaderLine($line)) {
                    $inHeaders = false;
                    if ($this->headers_only) {
                        break;
                    }
                }
                continue;
            }

            $this->content .= $line;
        }
    }

    private function processHeaderLine(string $line): bool
    {
        if ('' == trim($line)) {
            $this->debug('Received Headers', $this->headers);

            return true;
        }

        if (!preg_match('/([^:]+):\s*(.*)/', $line, $m)) {
            return false;
        }

        $key = mb_strtolower(trim($m[1]));
        $val = trim($m[2]);

        if (isset($this->headers[$key])) {
            if (is_array($this->headers[$key])) {
                $this->headers[$key][] = $val;
            } else {
                $this->headers[$key] = [$this->headers[$key], $val];
            }
        } else {
            $this->headers[$key] = $val;
        }

        return false;
    }

    private function processResponse(): void
    {
        $this->decompressContent();
        $this->handleCookies();
        $this->handleReferers();
    }

    private function decompressContent(): void
    {
        if (isset($this->headers['content-encoding']) && 'gzip' == $this->headers['content-encoding']) {
            $this->debug('Content is gzip encoded, unzipping it');
            $this->content = mb_substr($this->content, 10);
            $this->content = gzinflate($this->content);
        }
    }

    private function handleCookies(): void
    {
        if (!$this->persist_cookies || !isset($this->headers['set-cookie']) || $this->host != $this->cookie_host) {
            return;
        }

        $cookies = $this->headers['set-cookie'];
        if (!is_array($cookies)) {
            $cookies = [$cookies];
        }

        foreach ($cookies as $cookie) {
            if (preg_match('/([^=]+)=([^;]+);/', $cookie, $m)) {
                $this->cookies[$m[1]] = $m[2];
            }
        }

        $this->cookie_host = $this->host;
    }

    private function handleReferers(): void
    {
        if ($this->persist_referers) {
            $this->debug('Persisting referer: ' . $this->getRequestURL());
            $this->referer = $this->getRequestURL();
        }
    }

    private function handleRedirects(): bool
    {
        if (!$this->handle_redirects) {
            return true;
        }

        if (++$this->redirect_count >= $this->max_redirects) {
            $this->errormsg = 'Number of redirects exceeded maximum (' . $this->max_redirects . ')';
            $this->debug($this->errormsg);
            $this->redirect_count = 0;

            return false;
        }

        $location = $this->headers['location'] ?? '';
        $uri = $this->headers['uri'] ?? '';

        if ($location || $uri) {
            $url = parse_url($location . $uri);

            return $this->get($url['path']);
        }

        return true;
    }
}
