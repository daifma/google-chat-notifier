<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Notifier\Bridge\GoogleChat\Tests;

use Symfony\Component\Notifier\Bridge\GoogleChat\GoogleChatTransportFactory;
use Symfony\Component\Notifier\Test\TransportFactoryTestCase;

final class GoogleChatTransportFactoryTest extends TransportFactoryTestCase
{
    public function createFactory(): GoogleChatTransportFactory
    {
        return new GoogleChatTransportFactory();
    }

    public function createProvider(): iterable
    {
        yield [
            'googlechat://chat.googleapis.com/AAAAA_YYYYY',
            'googlechat://abcde-fghij:kl_mnopqrstwxyz%3D@chat.googleapis.com/AAAAA_YYYYY',
        ];

        yield [
            'googlechat://chat.googleapis.com/AAAAA_YYYYY?thread_key=abcdefg',
            'googlechat://abcde-fghij:kl_mnopqrstwxyz%3D@chat.googleapis.com/AAAAA_YYYYY?thread_key=abcdefg',
        ];
    }

    public function supportsProvider(): iterable
    {
        yield [true, 'googlechat://host/path'];
        yield [false, 'somethingElse://host/path'];
    }

    public function incompleteDsnProvider(): iterable
    {
        yield 'missing credentials' => ['googlechat://chat.googleapis.com/v1/spaces/AAAAA_YYYYY/messages'];
        yield 'using old option: threadKey' => ['googlechat://abcde-fghij:kl_mnopqrstwxyz%3D@chat.googleapis.com/AAAAA_YYYYY?threadKey=abcdefg', 'GoogleChat DSN has changed since 5.3, use "thread_key" instead of "threadKey" parameter.']; // can be removed in Symfony 5.4
    }

    public function unsupportedSchemeProvider(): iterable
    {
        yield ['somethingElse://host/path'];
    }
}
