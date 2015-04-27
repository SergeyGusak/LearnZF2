<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace LearnZF2AuthenticationTest\Factory;

use PHPUnit_Framework_TestCase;
use LearnZF2Authentication\Factory\DigestAuthenticationAdapterFactory;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class DigestAuthenticationAdapterFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var BasicAuthenticationAdapterFactory */
    protected $digestFactory;

    /** @var ControllerManager */
    protected $controllerManager;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ControllerManager $controllerManager */
        $controllerManager = $this->getMock('Zend\Mvc\Controller\ControllerManager');
        $this->controllerManager = $controllerManager;

        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $dataArray = ['authentication_digest' => [
                        'adapter' => [
                            'config' => [
                                'accept_schemes' => 'digest',
                                'realm'          => 'authentication',
                                'digest_domains' => '/learn-zf2-authentication/digest',
                                'nonce_timeout'  => 3600,
                            ],
                            'digest' => dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/config/auth/digest.txt',
                        ],
                    ]];

        $controllerManager->expects($this->once())
                       ->method('get')
                       ->with('Config')
                       ->willReturn($dataArray);

        $this->digestFactory = new DigestAuthenticationAdapterFactory();
        $this->serviceLocator = $serviceLocator;
    }

    public function testCreateService()
    {
        $digest = $this->digestFactory->createService($this->controllerManager);
        $this->assertInstanceOf('Zend\Authentication\Adapter\Http', $digest);
    }
}
