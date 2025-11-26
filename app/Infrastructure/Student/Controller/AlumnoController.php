<?php

namespace App\Infrastructure\Student\Controller;

class AlumnoController {
  public function __construct() {

  }

  public function __invoke() {

    return view('student', compact('grupos'));
  }
}
