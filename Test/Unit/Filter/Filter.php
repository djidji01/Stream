<?php

declare(strict_types=1);

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2017, Hoa community. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace igorora\Stream\Test\Unit\Filter;

use igorora\Stream as LUT;
use igorora\Stream\Filter as SUT;
use igorora\Test;

/**
 * Class \igorora\Stream\Test\Unit\Filter\Filter.
 *
 * Test suite of the filter class.
 *
 * @license    New BSD License
 */
class Filter extends Test\Unit\Suite
{
    public function case_constants(): void
    {
        $this
            ->boolean(SUT::OVERWRITE)
                ->isTrue()
            ->boolean(SUT::DO_NOT_OVERWRITE)
                ->isFalse()
            ->integer(SUT::READ)
                ->isEqualTo(STREAM_FILTER_READ)
            ->integer(SUT::WRITE)
                ->isEqualTo(STREAM_FILTER_WRITE)
            ->integer(SUT::READ_AND_WRITE)
                ->isEqualTo(STREAM_FILTER_ALL);
    }

    public function case_register(): void
    {
        $this
            ->when($result = SUT::register('foo', \StdClass::class))
            ->then
                ->boolean($result)
                    ->isTrue();
    }

    public function case_register_already_registered_do_not_overwrite(): void
    {
        $this
            ->given(
                $name  = 'foo',
                $class = \StdClass::class,
                SUT::register($name, $class)
            )
            ->exception(function () use ($name, $class): void {
                SUT::register($name, $class);
            })
                ->isInstanceOf(LUT\Filter\Exception::class)
                ->hasMessage('Filter foo is already registered.');
    }

    public function case_register_already_registered_do_overwrite(): void
    {
        $this
            ->given(
                $name = 'foo',
                SUT::register($name, \StdClass::class),
                new \Mock\StdClass() // create it
            )
            ->when($result = SUT::register($name, \Mock\StdClass::class, SUT::OVERWRITE))
            ->then
                ->boolean($result)
                    ->isFalse();
    }

    public function case_register_empty_name(): void
    {
        $this
            ->exception(function (): void {
                SUT::register('', \StdClass::class);
            })
                ->isInstanceOf(LUT\Filter\Exception::class)
                ->hasMessage(
                    'Filter name cannot be empty ' .
                    '(implementation class is StdClass).'
                );
    }

    public function case_register_unknown_class(): void
    {
        $this
            ->exception(function (): void {
                SUT::register('foo', '42Foo');
            })
                ->isInstanceOf(LUT\Filter\Exception::class)
                ->hasMessage(
                    'Cannot register the 42Foo class for the filter foo ' .
                    'because it does not exist.'
                );
    }

    public function case_append(): void
    {
        $this
            ->given(
                $stream = fopen('igorora://Test/Vfs/Foo?type=file', 'r'),
                $name   = 'string.toupper'
            )
            ->when($result = SUT::append($stream, $name))
            ->then
                ->resource($result)
                    ->isStreamFilter();
    }

    public function case_prepend(): void
    {
        $this
            ->given(
                $stream = fopen('igorora://Test/Vfs/Foo?type=file', 'r'),
                $name   = 'string.toupper'
            )
            ->when($result = SUT::prepend($stream, $name))
            ->then
                ->resource($result)
                    ->isStreamFilter();
    }

    public function case_remove(): void
    {
        $this
            ->given(
                $stream = fopen('igorora://Test/Vfs/Foo?type=file', 'r'),
                $name   = 'string.toupper',
                $filter = SUT::append($stream, $name)
            )
            ->when($result = SUT::remove($filter))
            ->then
                ->boolean($result)
                    ->isTrue();
    }

    public function case_remove_by_name(): void
    {
        $this
            ->given(
                $stream = fopen('igorora://Test/Vfs/Foo?type=file', 'r'),
                $name   = 'string.toupper',
                $filter = SUT::append($stream, $name)
            )
            ->when($result = SUT::remove($name))
            ->then
                ->boolean($result)
                    ->isTrue();
    }

    public function case_remove_unknown(): void
    {
        $this
            ->exception(function (): void {
                SUT::remove('foo');
            })
                ->isInstanceOf(LUT\Filter\Exception::class)
                ->hasMessage(
                    'Cannot remove the stream filter foo ' .
                    'because no resource was found with this name.'
                );
    }

    public function case_is_registered(): void
    {
        $this
            ->when($result = SUT::isRegistered('string.toupper'))
            ->then
                ->boolean($result)
                    ->isTrue();
    }

    public function case_is_not_registered(): void
    {
        $this
            ->when($result = SUT::isRegistered('foo'))
            ->then
                ->boolean($result)
                    ->isFalse();
    }

    public function case_get_registered(): void
    {
        $this
            ->when($result = SUT::getRegistered())
            ->then
                ->array($result)
                    ->containsValues([
                        'string.rot13',
                        'string.toupper',
                        'string.tolower',
                        'string.strip_tags',
                        'consumed',
                        'dechunk'
                    ]);
    }
}
