<?php

namespace App\Helpers;

use DateTime;

class Helpers
{
    public static function validateCPF($cpf): bool {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/^(\d)\1+$/', $cpf)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int) substr($cpf, $i, 1) * (10 - $i);
        }

        $rest = $sum % 11;
        if ($rest < 2) {
            $dv1 = 0;
        } else {
            $dv1 = 11 - $rest;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int) substr($cpf, $i, 1) * (11 - $i);
        }

        $sum += (int) substr($cpf, 9, 1) * 2;
        $rest = $sum % 11;

        if ($rest < 2) {
            $dv2 = 0;
        } else {
            $dv2 = 11 - $rest;
        }

        if ($dv1 == (int) substr($cpf, 9, 1) && $dv2 == (int) substr($cpf, 10, 1)) {
            return true;
        } else {
            return false;
        }
    }

    public static function convertDateToBD($date) {
        $dateTime = DateTime::createFromFormat('d/m/Y', $date);
        return $dateTime->format('Y-m-d');
      }
}
