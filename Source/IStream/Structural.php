<?php

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

namespace igorora\Stream\IStream;

/**
 * Interface \igorora\Stream\IStream\Structural.
 *
 * Interface for structural input/output.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
interface Structural extends Stream
{
    /**
     * Select root of the document: :root.
     *
     * @return  \igorora\Stream\IStream\Structural
     */
    public function selectRoot();

    /**
     * Select any elements: *.
     *
     * @return  array
     */
    public function selectAnyElements();

    /**
     * Select elements of type E: E.
     *
     * @param   string  $E    Element E.
     * @return  array
     */
    public function selectElements($E = null);

    /**
     * Select F elements descendant of an E element: E F.
     *
     * @param   string  $F    Element F.
     * @return  array
     */
    public function selectDescendantElements($F = null);

    /**
     * Select F elements children of an E element: E > F.
     *
     * @param   string  $F    Element F.
     * @return  array
     */
    public function selectChildElements($F = null);

    /**
     * Select an F element immediately preceded by an E element: E + F.
     *
     * @param   string  $F    Element F.
     * @return  \igorora\Stream\IStream\Structural
     */
    public function selectAdjacentSiblingElement($F);

    /**
     * Select F elements preceded by an E element: E ~ F.
     *
     * @param   string  $F    Element F.
     * @return  array
     */
    public function selectSiblingElements($F = null);

    /**
     * Execute a query selector and return the first result.
     *
     * @param   string  $query    Query.
     * @return  \igorora\Stream\IStream\Structural
     */
    public function querySelector($query);

    /**
     * Execute a query selector and return one or many results.
     *
     * @param   string  $query    Query.
     * @return  array
     */
    public function querySelectorAll($query);
}
