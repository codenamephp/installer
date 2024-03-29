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

use de\codenamephp\installer\templateCopy\variableReplacer\StringReplace;
use PHPUnit\Framework\TestCase;

class StringReplaceTest extends TestCase {

  private StringReplace $sut;

  protected function setUp() : void {
    $this->sut = new StringReplace();
  }

  public function testReplace() : void {
    self::assertEquals('/some/path/without/placeholders/path', $this->sut->replace(
        '/some/__placeholder1__/without/__placeholder2__/__placeholder1__',
        ['__placeholder1__' => 'path', '__placeholder2__' => 'placeholders'])
    );
  }
}
