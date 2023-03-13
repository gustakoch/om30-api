<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Address;
use App\Models\Pacient;
use App\Traits\CNSValidation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    use CNSValidation;

    public function importCsv(Request $request)
    {
        $file = $request->file('csv');
        if (!$file)
            return response()->json(['message' => 'Arquivo CSV não informado.'], 404);

        $handle = fopen($file, 'r');

        if ($handle) {
            $row = 0;

            DB::beginTransaction();
            while (($data = fgetcsv($handle, 1000, ';'))) {
                if ($row == 0) {
                    $row++;
                    continue;
                }

                $address = Address::create([
                    'zip_code' => $data[0],
                    'street' => $data[1],
                    'number' => $data[2],
                    'complement' => $data[3],
                    'district' => $data[4],
                    'city' => $data[5],
                    'state' => $data[6]
                ]);

                if (!Helpers::validateCPF($data[10])) {
                    DB::rollBack();
                    continue;
                }

                if (in_array($data[11], ['1', '2'])) {
                    if (!$this->numbersStartedWithOneOrTwo($data[11])) {
                        DB::rollBack();
                        continue;
                    }
                } else {
                    if (!$this->numbersStartedWithSevenEightOrNine($data[11])) {
                        DB::rollBack();
                        continue;
                    }
                }

                Pacient::create([
                    'full_name' => $data[7],
                    'mother_full_name' => $data[8],
                    'birth_day' => Helpers::convertDateToBD($data[9]),
                    'cpf' => $data[10],
                    'cns' => $data[11],
                    'address_id' => $address->id
                ]);

                $row++;
            }

            DB::commit();
            fclose($handle);

            return response()->json(['message' => 'Arquivo importado com sucesso.']);
        }
    }
}
