<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait CNSValidation
{
    function numbersStartedWithOneOrTwo($cns) {
        if (trim($cns) != 15) {
            return false;
        }

        $soma = 0;
        $resto = 0;
        $dv = 0;
        $pis = "";
        $resultado = "";

        $pis = substr($cns, 0, 11);

        $soma = (intval(substr($pis, 0, 1)) * 15) +
            (intval(substr($pis, 1, 1)) * 14) +
            (intval(substr($pis, 2, 1)) * 13) +
            (intval(substr($pis, 3, 1)) * 12) +
            (intval(substr($pis, 4, 1)) * 11) +
            (intval(substr($pis, 5, 1)) * 10) +
            (intval(substr($pis, 6, 1)) * 9) +
            (intval(substr($pis, 7, 1)) * 8) +
            (intval(substr($pis, 8, 1)) * 7) +
            (intval(substr($pis, 9, 1)) * 6) +
            (intval(substr($pis, 10, 1)) * 5);

        $resto = $soma % 11;
        $dv = 11 - $resto;

        if ($dv == 11) {
            $dv = 0;
        }

        if ($dv == 10) {
            $soma = (intval(substr($pis, 0, 1)) * 15) +
                (intval(substr($pis, 1, 1)) * 14) +
                (intval(substr($pis, 2, 1)) * 13) +
                (intval(substr($pis, 3, 1)) * 12) +
                (intval(substr($pis, 4, 1)) * 11) +
                (intval(substr($pis, 5, 1)) * 10) +
                (intval(substr($pis, 6, 1)) * 9) +
                (intval(substr($pis, 7, 1)) * 8) +
                (intval(substr($pis, 8, 1)) * 7) +
                (intval(substr($pis, 9, 1)) * 6) +
                (intval(substr($pis, 10, 1)) * 5) + 2;

            $resto = $soma % 11;
            $dv = 11 - $resto;
            $resultado = $pis . "001" . strval((int)$dv);
        } else {
            $resultado = $pis . "000" . strval((int)$dv);
        }

        if ($cns != $resultado) {
            return false;
        }

        return true;
    }

    function numbersStartedWithSevenEightOrNine($cns) {
        if (strlen(trim($cns)) != 15) {
            return false;
        }

        $soma = (intval(substr($cns, 0, 1)) * 15) +
                (intval(substr($cns, 1, 1)) * 14) +
                (intval(substr($cns, 2, 1)) * 13) +
                (intval(substr($cns, 3, 1)) * 12) +
                (intval(substr($cns, 4, 1)) * 11) +
                (intval(substr($cns, 5, 1)) * 10) +
                (intval(substr($cns, 6, 1)) * 9) +
                (intval(substr($cns, 7, 1)) * 8) +
                (intval(substr($cns, 8, 1)) * 7) +
                (intval(substr($cns, 9, 1)) * 6) +
                (intval(substr($cns, 10, 1)) * 5) +
                (intval(substr($cns, 11, 1)) * 4) +
                (intval(substr($cns, 12, 1)) * 3) +
                (intval(substr($cns, 13, 1)) * 2) +
                (intval(substr($cns, 14, 1)) * 1);

        $resto = $soma % 11;

        if ($resto != 0) {
            return false;
        }

        return true;
    }
}
