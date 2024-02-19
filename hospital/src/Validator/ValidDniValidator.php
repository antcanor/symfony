<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidDniValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (0 === preg_match("/\d{1,8}[a-z]/i", $value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
            return;
        }

        $numero = substr($value, 0, -1);
        $letra  = strtoupper(substr($value, -1));
        if ($letra != substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($numero, "XYZ", "012")%23, 1)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
