<?php declare(strict_types=1);
/**
 * Copyright 2021 Bastian Schwarz <bastian@codename-php.de>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

namespace de\codenamephp\installer\test\templateCopy\variableReplacer;

use de\codenamephp\installer\templateCopy\variableReplacer\FramedStringReplace;
use PHPUnit\Framework\TestCase;

class FramedStringReplaceTest extends TestCase {

  private FramedStringReplace $sut;

  protected function setUp() : void {
    $this->sut = new FramedStringReplace();
  }

  public function testReplace() : void {
    self::assertEquals('/some/not_placeholder/vendor/not_vendor/not_placeholder', $this->sut->replace(
        '/some/__placeholder__/vendor/__vendor__/__placeholder__',
        ['vendor' => 'not_vendor', 'placeholder' => 'not_placeholder'])
    );
  }

  public function testReplace_withCustomPrefixAndSuffix() : void {
    $this->sut->prefix = '++';
    $this->sut->suffix = '~~';

    self::assertEquals('/some/not_placeholder/vendor/not_vendor/not_placeholder/__placeholder__', $this->sut->replace(
        '/some/++placeholder~~/vendor/++vendor~~/++placeholder~~/__placeholder__',
        ['vendor' => 'not_vendor', 'placeholder' => 'not_placeholder'])
    );
  }
}
