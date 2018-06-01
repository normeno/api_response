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
 * @package  Normeno\ApiResponse\Test
 * @author   Nicolas Ormeno <ni.ormeno@gmail.com>
 * @license  http://opensource.org/licenses/mit-license.php MIT License
 * @link     https://github.com/normeno/gjson
 */
namespace Normeno\ApiResponse\Test;

use PHPUnit\Framework\TestCase;
use Normeno\ApiResponse\ApiResponse;

/**
 * Tests for Format
 *
 * @category Test
 * @package  Normeno\ApiResponse\Test
 * @author   Nicolas Ormeno <ni.ormeno@gmail.com>
 * @license  http://opensource.org/licenses/mit-license.php MIT License
 * @link     https://github.com/normeno/gjson
 */
class ApiResponseTest extends TestCase
{
    /**
     * Set a simple response with http
     */
    public function testSimpleSuccess()
    {
        $code = 200;
        $response = ApiResponse::success($code, 'test', ['id' => 50, 'type' => 'post']);
        $stringContent = '{"data":{"type":"test","attributes":{"id":50,"type":"post"}}}';
        $this->setTestCases($response, $code, $stringContent);
    }

    /**
     * Set a simple response with http
     */
    public function testSuccessWithRelationship()
    {
        $code = 200;
        $response = ApiResponse::success(
            $code,
            'test',
            [
                'id' => 50,
                'type' => 'post'
            ],
            [
                [
                    'key' => 'relationships',
                    'value' => [
                        'author' => [
                            'id' => 42,
                            'type' => 'people'
                        ]
                    ]
                ]
            ]
        );
        $stringContent = '{"data":{"type":"test","attributes":{"id":50,"type":"post"},"relationships":{"author":{"id":42,"type":"people"}}}}';
        $this->setTestCases($response, $code, $stringContent);
    }

    private function setTestCases($response, $code, $stringContent)
    {
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals($code, $response->getStatusCode());
        $this->assertEquals('application/vnd.api+json', $response->headers->get('Content-Type'));
        $this->assertEquals($stringContent, $response->getContent());
    }
}