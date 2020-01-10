<?php

class F1 extends BaseMath
{
  protected $a, $b, $c, $f;

  function __construct($a, $b, $c) {
    $this->a = $a;
    $this->b = $b;
    $this->c = $c;
    $this->f = ($this->exp1($a, $b, $c) + ($this->exp2($a, $b, $c)%3)^min($a, $b, $c));
  }
}
