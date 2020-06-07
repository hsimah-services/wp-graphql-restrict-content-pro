<?php

final class WPGraphQL_RCP_Utils {
    /**
   * Convert a snake case string into a lower camelcase string
   */
  public static function to_camel_case($input)
  {
    if (is_array($input)) {
      foreach ($input as $key => $value) {
        $key = self::to_camel_case($key);
        $out[$key] = $value;
      }

      return $out;
    }

    return lcfirst(str_replace('_', '', ucwords($input, ' /_')));
  }
}