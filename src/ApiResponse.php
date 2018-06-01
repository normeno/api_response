<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * This file is part of the Api Response library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 7
 *
 * LICENSE: This source file is subject to the MIT license that is available
 * through the world-wide-web at the following URI:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category Test
 * @package  Normeno\ApiResponse
 * @author   Nicolas Ormeno <ni.ormeno@gmail.com>
 * @license  http://opensource.org/licenses/mit-license.php MIT License
 * @link     https://github.com/normeno/gjson
 */
namespace Normeno\ApiResponse;

use Symfony\Component\HttpFoundation\Response;

/**
 * Response Class
 *
 * @category Test
 * @package  Normeno\ApiResponse
 * @author   Nicolas Ormeno <ni.ormeno@gmail.com>
 * @license  http://opensource.org/licenses/mit-license.php MIT License
 * @link     https://github.com/normeno/gjson
 */
class ApiResponse {

    /**
     * Generate standard success output
     *
     * @param integer $code
     * @param string $type
     * @param array|object $attributes
     * @param array $extras
     *
     * @return string json
     */
    public static function success($code, $type, $attributes, $extras=[])
    {
        $response = [ // Basic structure
            'data' => [
                'type' => $type,
                'attributes' => $attributes
            ]
        ];

        if (!empty($extras)) { // Add extra params e.g relationships
            foreach ($extras as $extra) {
                $response['data'][$extra['key']] = $extra['value'];
            }
        }

        return self::response($response, $code);

    }

    /**
     * Generate standard error output
     *
     * @param integer $type
     * @param string $message
     *
     * @return string json
     */
    public static function error($type, $message)
    {
        return response(Collect([
            'error' => [
                'type' => $type,
                'message' => $message
            ]
        ]), 409)
            ->header('Content-Type', 'application/vnd.api+json')
            ->header('Content-Type', 'application/vnd.api+json');
    }

    /**
     * Set standard output
     *
     * @param array $structure
     * @param integer $code
     *
     * @return string json
     */
    private static function response($structure, $code)
    {
        $response = new Response();
        $response->setContent(json_encode($structure));
        $response->headers->set('Content-Type', 'application/vnd.api+json');
        $response->setStatusCode($code);

        return $response;
    }
}