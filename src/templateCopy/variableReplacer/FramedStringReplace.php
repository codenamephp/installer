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

namespace de\codenamephp\installer\templateCopy\variableReplacer;

/**
 * Frames the variable names with a pre- and suffix so common folder names like "vendor" are not replaced by accident
 */
final class FramedStringReplace implements iVariableReplacer {

  public function __construct(public string $prefix = '__', public string $suffix = '__') { }

  /**
   * Applies the prefix and suffix to all variable names (the array keys) and passes them as search to str_replace, the values as replacment and the path
   * as subject.
   *
   * @inheritDoc
   */
  public function replace(string $path, array $variables) : string {
    return str_replace(array_map(fn($name) => $this->prefix . $name . $this->suffix, array_keys($variables)), $variables, $path);
  }
}