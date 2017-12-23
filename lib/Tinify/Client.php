<?php

namespace Tinify;

class Client {
    const API_ENDPOINT = "https://api.tinify.com";

    const RETRY_COUNT = 1;
    const RETRY_DELAY = 500;

    private $options;

    public static function userAgent() {
        $curl = curl_version();
        return "Tinify/" . VERSION . " PHP/" . PHP_VERSION . " curl/" . $curl["version"];
    }

    private static function caBundle() {
        return __DIR__ . "/../data/cacert.pem";
    }

    function __construct($key, $app_identifier = NULL, $proxy = NULL) {
        $curl = curl_version();

        if (!($curl["features"] & CURL_VERSION_SSL)) {
            throw new ClientException("Your curl version does not support secure connections");
        }

        if ($curl["version_number"] < 0x071201) {
            $version = $curl["version"];
            throw new ClientException("Your curl version ${version} is outdated; please upgrade to 7.18.1 or higher");
        }

        $this->options = array(
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_USERPWD => "api:" . $key,
            CURLOPT_CAINFO => self::caBundle(),
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => join(" ", array_filter(array(self::userAgent(), $app_identifier))),
        );

        if ($proxy) {
            $parts = parse_url($proxy);
            if (isset($parts["host"])) {
                $this->options[CURLOPT_PROXYTYPE] = CURLPROXY_HTTP;
                $this->options[CURLOPT_PROXY] = $parts["host"];
            } else {
                throw new ConnectionException("Invalid proxy");
            }

            if (isset($parts["port"])) {
                $this->options[CURLOPT_PROXYPORT] = $parts["port"];
            }

            $creds = "";
            if (isset($parts["user"])) $creds .= $parts["user"];
            if (isset($parts["pass"])) $creds .= ":" . $parts["pass"];

            if ($creds) {
                $this->options[CURLOPT_PROXYAUTH] = CURLAUTH_ANY;
                $this->options[CURLOPT_PROXYUSERPWD] = $creds;
            }
        }
    }

    function request($method, $url, $body = NULL) {
        $header = array();
        if (is_array($body)) {
            if (!empty($body)) {
                $body = json_encode($body);
                array_push($header, "Content-Type: application/json");
            } else {
                $body = NULL;
            }
        }

        for ($retries = self::RETRY_COUNT; $retries >= 0; $retries--) {
            if ($retries < self::RETRY_COUNT) {
                usleep(self::RETRY_DELAY * 1000);
            }

            $request = curl_init();
            if ($request === false || $request === null) {
                throw new ConnectionException(
                    "Error while connecting: curl extension is not functional or disabled."
                );
            }

            curl_setopt_array($request, $this->options);

            $url = strtolower(substr($url, 0, 6)) == "https:" ? $url : self::API_ENDPOINT . $url;
            curl_setopt($request, CURLOPT_URL, $url);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, strtoupper($method));

            if (count($header) > 0) {
                curl_setopt($request, CURLOPT_HTTPHEADER, $header);
            }

            if ($body) {
                curl_setopt($request, CURLOPT_POSTFIELDS, $body);
            }

            $response = curl_exec($request);

            if (is_string($response)) {
                $status = curl_getinfo($request, CURLINFO_HTTP_CODE);
                $headerSize = curl_getinfo($request, CURLINFO_HEADER_SIZE);
                curl_close($request);

                $headers = self::parseHeaders(substr($response, 0, $headerSize));
                $body = substr($response, $headerSize);

                if (isset($headers["compression-count"])) {
                    Tinify::setCompressionCount(intval($headers["compression-count"]));
                }

                if ($status >= 200 && $status <= 299) {
                    return (object) array("body" => $body, "headers" => $headers);
                }

                $details = json_decode($body);
                if (!$details) {
                    $message = sprintf("Error while parsing response: %s (#%d)",
                        PHP_VERSION_ID >= 50500 ? json_last_error_msg() : "Error",
                        json_last_error());
                    $details = (object) array(
                        "message" => $message,
                        "error" => "ParseError"
                    );
                }

                if ($retries > 0 && $status >= 500) continue;
                throw Exception::create($details->message, $details->error, $status);
            } else {
                $message = sprintf("%s (#%d)", curl_error($request), curl_errno($request));
                curl_close($request);
                if ($retries > 0) continue;
                throw new ConnectionException("Error while connecting: " . $message);
            }
        }
    }

    protected static function parseHeaders($headers) {
        if (!is_array($headers)) {
            $headers = explode("\r\n", $headers);
        }

        $res = array();
        foreach ($headers as $header) {
            if (empty($header)) continue;
            $split = explode(":", $header, 2);
            if (count($split) === 2) {
                $res[strtolower($split[0])] = trim($split[1]);
            }
        }
        return $res;
    }
}
