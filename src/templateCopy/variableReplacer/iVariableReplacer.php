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
 * Interface to replace variables in the given path
 */
interface iVariableReplacer {

  /**
   * Implementations MUST make sure that all variables are replaced and return the final path
   *
   * @param string $path The path containing the placeholders
   * @param array $variables The variables to use to replace the placeholders
   * @return string The path with the placeholders replaced
   */
  public function replace(string $path, array $variables) : string;
}