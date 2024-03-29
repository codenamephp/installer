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
 * Uses str_replace to replace all placeholders in the path with the variables array the name matching must be 1:1
 */
final class StringReplace implements iVariableReplacer {
  /**
   * Passes the array kes of the variables which are the names of the placeholders as search, the values as replace and the path as subject and returns
   * the result.
   *
   * @inheritDoc
   */
  public function replace(string $path, array $variables) : string {
    return str_replace(array_keys($variables), $variables, $path);
  }
}