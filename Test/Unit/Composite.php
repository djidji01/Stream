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

namespace igorora\Stream\Test\Unit;

use igorora\Stream as LUT;
use igorora\Test;
use Mock\igorora\Stream\Composite as SUT;

/**
 * Class \igorora\Stream\Test\Unit\Composite.
 *
 * Test suite of the composite stream.
 *
 * @license    New BSD License
 */
class Composite extends Test\Unit\Suite
{
    public function case_set_stream(): void
    {
        $this
            ->given(
                $stream    = new \StdClass(),
                $composite = new SUT()
            )
            ->when($result = $this->invoke($composite)->setStream($stream))
            ->then
                ->variable($result)
                    ->isNull();
    }

    public function case_get_stream(): void
    {
        $this
            ->given(
                $stream    = new \StdClass(),
                $composite = new SUT(),
                $this->invoke($composite)->setStream($stream)
            )
            ->when($result = $composite->getStream())
            ->then
                ->object($result)
                    ->isIdenticalTo($stream);
    }

    public function case_set_inner_stream(): void
    {
        $this
            ->given(
                $innerStream = new MockedStream(),
                $composite   = new SUT()
            )
            ->when($result = $this->invoke($composite)->setInnerStream($innerStream))
            ->then
                ->variable($result)
                    ->isNull();
    }

    public function case_get_inner_stream(): void
    {
        $this
            ->given(
                $innerStream = new MockedStream(),
                $composite   = new SUT(),
                $this->invoke($composite)->setInnerStream($innerStream)
            )
            ->when($result = $composite->getInnerStream())
            ->then
                ->object($result)
                    ->isIdenticalTo($innerStream);
    }
}

class MockedStream extends LUT\Stream
{
    public function __construct()
    {
    }

    public function &_open(string $fileName, LUT\Context $context = null)
    {
    }

    public function _close(): bool
    {
        return false;
    }
}
