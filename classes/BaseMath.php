<?php

abstract class BaseMath
{
  function exp1($a, $b, $c) {
    return $a * ($b ^ $c);
  }

  function exp2($a, $b, $c) {
    return ($a / $b) ^ $c;
  }

  function getValue() {
    return $this->f;
  }
}
